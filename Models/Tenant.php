<?php

declare(strict_types=1);

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\User\Contracts\TenantContract;

/**
 * Modules\User\Models\Tenant.
 *
 * @method static \Modules\User\Database\Factories\TenantFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant   newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant   newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tenant   query()
 *
 * @property \Illuminate\Database\Eloquent\Collection<int, \Modules\Xot\Contracts\UserContract> $members
 * @property int|null                                                                 $members_count
 * @property \Modules\Xot\Contracts\ProfileContract|null                              $creator
 * @property \Modules\Xot\Contracts\ProfileContract|null                              $updater
 *
 * @mixin \Eloquent
 */
class Tenant extends BaseModel implements TenantContract
{
    protected $fillable = [
        'id',
        'name',
        'email_address',
        'phone',
        'mobile',
        'address',
        'primary_color',
        'secondary_color',
    ];

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(\Modules\Xot\Datas\XotData::make()->getUserClass());
    }
}
