<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Traits\BelongsToTenant;

class FeedbackResponse extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'qr_code_id',
        'ratings',
        'feedback_text',
        'customer_info',
        'status',
    ];

    protected $casts = [
        'ratings' => 'array',
        'customer_info' => 'array',
    ];

    public function qrCode(): BelongsTo
    {
        return $this->belongsTo(QrCode::class);
    }

    public function scopeUnread($query)
    {
        return $query->where('status', 'unread');
    }

    public function scopeArchived($query)
    {
        return $query->where('status', 'archived');
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
