<?php
/**
 * Created by PhpStorm.
 * User: nguyen-dat
 * Date: 04/12/2017
 * Time: 19:33
 */
namespace App\Repositories\Eloquents;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Models\User;

class UserRepository extends \EloquentRepository implements UserRepositoryInterface
{

    /**
     * @return mixed
     */
    public function getModel()
    {
        return User::class;
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        $result = $this->_model
	                   ->select('id','name','email','created_at')
	                   ->get()
	                   ->toArray();

        return $result;
    }

    /**
     * @param $email
     * @return User
     */
    public function saveUser($email)
    {
        $user        = new User();
        $user->email = $email;
        $user->save();

        return $user;
    }

    /**
     * @param $email
     * @return mixed
     */
    public function getUserInfoByEmail($email)
    {
        return User::where('email', $email)
                    ->where('del_flg', 0)
	                ->first();
    }
}