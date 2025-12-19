<?php

namespace App\Exports;

use App\Models\FeedbackResponse;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class FeedbackExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected $tenantId;
    protected $range; // days or 'all'

    public function __construct($tenantId, $range = 30)
    {
        $this->tenantId = $tenantId;
        $this->range = $range;
    }

    public function query()
    {
        return FeedbackResponse::query()
            ->with(['qrCode']) // Eager load
            ->where('tenant_id', $this->tenantId)
            ->when($this->range !== 'all', function ($q) {
                $q->where('created_at', '>=', now()->subDays((int) $this->range));
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Date (UTC)',
            'QR Code Source',
            'Ratings (JSON)',
            'Feedback Text',
            'Customer Info (JSON)',
            'Status',
        ];
    }

    public function map($feedback): array
    {
        return [
            $feedback->id,
            $feedback->created_at,
            $feedback->qrCode->name ?? 'Unknown',
            json_encode($feedback->ratings),
            $feedback->feedback_text,
            json_encode($feedback->customer_info),
            $feedback->status,
        ];
    }
}
