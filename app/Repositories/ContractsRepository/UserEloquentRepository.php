<?php
/**
 * Created by PhpStorm.
 * User: nguyen-dat
 * Date: 04/12/2017
 * Time: 19:33
 */
namespace App\Repositories\ContractsRepository;

use App\Account;
use App\Respositories\InterfacesRepository\UserRepositoryInterface;
use App\User;

class UserEloquentRepository extends \EloquentRepository implements UserRepositoryInterface
{

    public function getModel()
    {
        return Account::class;
    }

    public function getAll()
    {
        $result = $this->_model->select('name','email','created_at')->get()->toArray();

        return $result;
    }

}