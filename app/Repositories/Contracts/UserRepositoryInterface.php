<?php
/**
 * Created by PhpStorm.
 * User: nguyen-dat
 * Date: 04/12/2017
 * Time: 19:32
 */
namespace App\Repositories\Contracts;

interface UserRepositoryInterface
{
    /**
     * @return mixed
     */
    public function getAll();

    /**
     * @param $user_info
     * @return mixed
     */
    public function saveUser($user_info);
}