<?php

namespace App\Observers;

use App\Models\User;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class UserObserver
{
    public function creating(User $user)
    {
        //添加默认头像
        $user->avatar = 'upload/images/avatar/202005/27/avatar-10-21-048608.png';

    }

    public function updating(User $user)
    {
        //
    }
}
