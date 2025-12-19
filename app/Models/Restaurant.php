<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Restaurant extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'name',
        'logo',
        'settings',
        'phone',
        'address',
    ];

    protected $casts = [
        'settings' => 'array',
    ];

    public function questionnaires(): HasMany
    {
        return $this->hasMany(Questionnaire::class, 'tenant_id', 'tenant_id');
    }

    public function qrCodes(): HasMany
    {
        return $this->hasMany(QrCode::class, 'tenant_id', 'tenant_id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'tenant_id', 'tenant_id');
    }
}
