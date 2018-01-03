<?php
/**
 * Created by PhpStorm.
 * User: nguyen-dat
 * Date: 04/12/2017
 * Time: 19:32
 */
namespace App\Repositories\InterfacesRepository;

interface UserInterfaceRepository
{
    public function getAll();
    public function saveUser($user_info);
}