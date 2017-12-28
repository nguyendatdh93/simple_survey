<?php
/**
 * Created by PhpStorm.
 * User: nguyen-dat
 * Date: 16/11/2017
 * Time: 20:23
 */
namespace App\Respositories\InterfacesRepository;

interface PostInterfaceRepository
{
    public function getAllPublished();

    public function findOnlyPublished($id);
}