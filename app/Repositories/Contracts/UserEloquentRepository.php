<?php
/**
 * Created by PhpStorm.
 * User: nguyen-dat
 * Date: 04/12/2017
 * Time: 19:33
 */
namespace App\Repositories\Contracts;

use App\Account;
use App\Respositories\ClassifyRepositoty\UserRepositoryInterface;
use App\User;

class UserEloquentRepository extends \EloquentRepository implements UserRepositoryInterface
{

    public function getModel()
    {
        return Account::class;
    }

    public function getAll()
    {
        $result = $this->_model->select('name','email','flg_manager','created_at')->get()->toArray();

        return $result;
    }

}