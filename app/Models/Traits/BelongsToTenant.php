<?php

namespace App\Models\Traits;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant as BaseBelongsToTenant;

trait BelongsToTenant
{
    use BaseBelongsToTenant;

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
