<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardService
{
    /**
     * Get overview statistics.
     */
    public function getStats($tenantId, $range = 30)
    {
        $query = DB::table('feedback_responses')
            ->where('tenant_id', $tenantId)
            ->when($range !== 'all', function ($q) use ($range) {
                $q->where('created_at', '>=', Carbon::now()->subDays((int) $range));
            });

        $totalFeedback = $query->count();

        $allFeedbacks = $query->select('ratings')->get();
        $totalScore = 0;
        $count = 0;

        foreach ($allFeedbacks as $f) {
            $ratings = json_decode($f->ratings, true);
            if (is_array($ratings)) {
                foreach ($ratings as $score) {
                    if (is_numeric($score)) {
                        $totalScore += $score;
                        $count++;
                    }
                }
            }
        }

        $avgRating = $count > 0 ? round($totalScore / $count, 1) : 0;

        return [
            'total_feedback' => $totalFeedback,
            'avg_rating' => $avgRating,
        ];
    }

    /**
     * Get sentiment distribution for Pie Chart.
     * Positive >= 4, Neutral = 3, Negative <= 2
     */
    public function getSentimentData($tenantId, $range = 30)
    {
        $query = DB::table('feedback_responses')
            ->where('tenant_id', $tenantId)
            ->when($range !== 'all', function ($q) use ($range) {
                $q->where('created_at', '>=', Carbon::now()->subDays((int) $range));
            });

        $feedbacks = $query->select('ratings')->get();

        $positive = 0;
        $neutral = 0;
        $negative = 0;

        foreach ($feedbacks as $f) {
            $ratings = json_decode($f->ratings, true);

            // Support both JSON array stored as string and legacy CSV-like strings.
            if (!is_array($ratings)) {
                if (is_string($f->ratings) && strpos($f->ratings, ',') !== false) {
                    $ratings = array_map('trim', explode(',', $f->ratings));
                } else {
                    // can't parse ratings, skip
                    continue;
                }
            }

            // Ensure we only sum numeric values to avoid array_sum errors on non-numeric strings
            $sum = 0;
            $count = 0;
            foreach ($ratings as $r) {
                if (is_numeric($r)) {
                    $sum += (float) $r;
                    $count++;
                }
            }

            $avg = $count > 0 ? $sum / $count : 0;

            if ($avg >= 4) {
                $positive++;
            } elseif ($avg >= 3) {
                $neutral++;
            } else {
                $negative++;
            }
        }

        return [
            'labels' => ['Positive', 'Neutral', 'Negative'],
            'data' => [$positive, $neutral, $negative],
        ];
    }

    /**
     * Get trend data for Line Chart (Daily average of feedback submission avg).
     */
    public function getTrendData($tenantId, $range = 30)
    {
        $days = $range === 'all' ? 365 : (int) $range;
        $startDate = Carbon::now()->subDays($days);

        $feedbacks = DB::table('feedback_responses')
            ->where('tenant_id', $tenantId)
            ->where('created_at', '>=', $startDate)
            ->orderBy('created_at')
            ->get(['created_at', 'ratings']);

        $dailyData = [];

        foreach ($feedbacks as $f) {
            $date = Carbon::parse($f->created_at)->format('Y-m-d');
            $ratings = json_decode($f->ratings, true);

            if (!is_array($ratings)) {
                if (is_string($f->ratings) && strpos($f->ratings, ',') !== false) {
                    $ratings = array_map('trim', explode(',', $f->ratings));
                } else {
                    continue;
                }
            }

            $sum = 0;
            $count = 0;
            foreach ($ratings as $r) {
                if (is_numeric($r)) {
                    $sum += (float) $r;
                    $count++;
                }
            }

            $avg = $count > 0 ? $sum / $count : 0;

            if (!isset($dailyData[$date])) {
                $dailyData[$date] = ['total' => 0, 'count' => 0];
            }
            $dailyData[$date]['total'] += $avg;
            $dailyData[$date]['count']++;
        }

        // Fill missing dates
        $period = \Carbon\CarbonPeriod::create($startDate, Carbon::now());
        $labels = [];
        $data = [];

        foreach ($period as $date) {
            $formattedDate = $date->format('Y-m-d');
            $labels[] = $date->format('M d');

            if (isset($dailyData[$formattedDate])) {
                $data[] = round($dailyData[$formattedDate]['total'] / $dailyData[$formattedDate]['count'], 1);
            } else {
                $data[] = 0; // Or null for breakage
            }
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }
}
