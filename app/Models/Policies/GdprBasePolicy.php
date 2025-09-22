<?php

declare(strict_types=1);

namespace Modules\Gdpr\Models\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;

abstract class GdprBasePolicy
{
    use HandlesAuthorization;

<<<<<<< HEAD
    public function before(UserContract $user, string $_ability): null|bool
=======
    public function before(UserContract $user, string $ability): ?bool
>>>>>>> 6d1fb23 (.)
    {
        $xotData = XotData::make();
        if ($user->hasRole('super-admin')) {
            return true;
        }

        return null;
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> 6d1fb23 (.)
