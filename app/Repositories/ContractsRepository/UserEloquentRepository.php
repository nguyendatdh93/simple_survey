<?php
/**
 * Created by PhpStorm.
 * User: nguyen-dat
 * Date: 04/12/2017
 * Time: 19:33
 */
namespace App\Repositories\ContractsRepository;

use App\Account;
use App\Repositories\InterfacesRepository\UserInterfaceRepository;
use App\User;

class UserEloquentRepository extends \EloquentRepository implements UserInterfaceRepository
{

    public function getModel()
    {
        return Account::class;
    }

    public function getAll()
    {
        $result = $this->_model->select('id','name','email','created_at')->get()->toArray();

        return $result;
    }

    public function saveUser($email)
    {
        $user = new User();
        $user->email = $email;
        $user->save();

        return $user;
    }

    public function getUserInfoByEmail($email)
    {
        return User::where('email', $email)
            ->where('del_flg', 0)->first();
    }
}