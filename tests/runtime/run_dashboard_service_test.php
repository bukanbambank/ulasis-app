<?php



// Minimal stub for Illuminate\Support\Facades\DB so we can run DashboardService without bootstrapping Laravel.
namespace Illuminate\Support\Facades {
    class DB {
        public static $data = [];
        public static function table($name)
        {
            return new \QueryStub(self::$data);
        }
    }
}

namespace {
    require __DIR__ . '/../../vendor/autoload.php';
    use Carbon\Carbon;
    class QueryStub
    {
        protected $data;
        protected $wheres = [];
        protected $orderBy = null;

        public function __construct($data)
        {
            $this->data = $data;
        }

        public function where($column, $operator = null, $value = null)
        {
            // Support where('col', $val) and where('col', '>=', $val)
            if (func_num_args() === 2) {
                $value = $operator;
                $operator = '=';
            }

            $this->wheres[] = [$column, $operator, $value];
            return $this;
        }

        public function when($cond, $closure)
        {
            if ($cond !== false) {
                $closure($this);
            }
            return $this;
        }

        public function select($cols)
        {
            // ignore: we will filter fields in get()
            return $this;
        }

        public function orderBy($col, $dir = 'asc')
        {
            $this->orderBy = [$col, strtolower($dir)];
            return $this;
        }

        public function get($cols = null)
        {
            $rows = array_filter($this->data, function ($row) {
                foreach ($this->wheres as $w) {
                    [$col, $op, $val] = $w;
                    $left = $row[$col] ?? null;

                    if ($op === '=') {
                        if ($left != $val) return false;
                    } elseif ($op === '>=') {
                        if (strtotime($left) < strtotime($val)) return false;
                    } else {
                        // other ops not implemented
                        return false;
                    }
                }
                return true;
            });

            // order
            if ($this->orderBy) {
                [$col, $dir] = $this->orderBy;
                usort($rows, function ($a, $b) use ($col, $dir) {
                    $va = $a[$col] ?? null;
                    $vb = $b[$col] ?? null;
                    if ($va === $vb) return 0;
                    if ($dir === 'asc') return strtotime($va) < strtotime($vb) ? -1 : 1;
                    return strtotime($va) > strtotime($vb) ? -1 : 1;
                });
            }

            $result = [];
            foreach ($rows as $r) {
                $obj = new stdClass();
                if (is_array($cols)) {
                    foreach ($cols as $c) {
                        $obj->{$c} = $r[$c] ?? null;
                    }
                } else {
                    // default: return all
                    foreach ($r as $k => $v) {
                        $obj->{$k} = $v;
                    }
                }
                $result[] = $obj;
            }

            return collect($result);
        }

        public function count()
        {
            return count($this->get());
        }
    }

    // Prepare sample data
    \Illuminate\Support\Facades\DB::$data = [
        // tenant 1 entries
        [
            'tenant_id' => 1,
            'ratings' => json_encode([5,4,4]),
            'created_at' => Carbon::now()->subDays(1)->toDateTimeString(),
        ],
        [
            'tenant_id' => 1,
            'ratings' => '5,4,invalid',
            'created_at' => Carbon::now()->subDays(2)->toDateTimeString(),
        ],
        [
            'tenant_id' => 1,
            'ratings' => '["3","3","2"]', // stored as quoted JSON strings
            'created_at' => Carbon::now()->subDays(3)->toDateTimeString(),
        ],
        // different tenant
        [
            'tenant_id' => 2,
            'ratings' => json_encode([1,2,2]),
            'created_at' => Carbon::now()->subDays(1)->toDateTimeString(),
        ],
    ];

    echo "Running DashboardService runtime test...\n";

    $svc = new \App\Services\DashboardService();

    $stats = $svc->getStats(1, 30);
    $sentiment = $svc->getSentimentData(1, 30);
    $trend = $svc->getTrendData(1, 30);

    echo "\ngetStats(tenant=1):\n";
    echo json_encode($stats, JSON_PRETTY_PRINT) . "\n";

    echo "\ngetSentimentData(tenant=1):\n";
    echo json_encode($sentiment, JSON_PRETTY_PRINT) . "\n";

    echo "\ngetTrendData(tenant=1) (labels first 5):\n";
    // shorten labels for display
    $outTrend = $trend;
    $outTrend['labels'] = array_slice($outTrend['labels'], -7); // last 7 days labels
    $outTrend['data'] = array_slice($outTrend['data'], -7);
    echo json_encode($outTrend, JSON_PRETTY_PRINT) . "\n";

    echo "\nDone.\n";
}
