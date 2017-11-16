<?php
/**
 * Created by PhpStorm.
 * User: nguyen-dat
 * Date: 16/11/2017
 * Time: 20:27
 */

namespace App\Repositories\Contracts;

use App\Post;
use App\Respositories\ClassifyRepositoty\PostRepositoryInterface;

class PostEloquentRepository extends \EloquentRepository implements PostRepositoryInterface
{

    public function getModel()
    {
        return Post::class;
    }

    public function getAllPublished()
    {
        $result = $this->_model->where('is_published', 1)->get()->toArray();

        return $result;
    }

    public function findOnlyPublished($id)
    {
        $result = $this->_model->where('id',$id)->where('is_published',1)->first();

        return $result;
    }
}