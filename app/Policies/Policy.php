<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class Policy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function before(User $user, $ability)
	{
	    // if ($user->isSuperAdmin()) {
	    // 		return true;
        // }
        //授权基类,在所有授权之前判断
        //如果用户拥有管理内容的权限的话，即授权通过
        if($user->can('manage_contents')){
            return true;
        }
	}
}
