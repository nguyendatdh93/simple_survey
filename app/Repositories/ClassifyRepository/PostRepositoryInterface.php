<?php
/**
 * Created by PhpStorm.
 * User: nguyen-dat
 * Date: 16/11/2017
 * Time: 20:23
 */
namespace App\Respositories\ClassifyRepositoty;

interface PostRepositoryInterface
{
    public function getAllPublished();

    public function findOnlyPublished($id);
}