<?php
/**
 * Created by PhpStorm.
 * User: nguyen-dat
 * Date: 16/11/2017
 * Time: 20:27
 */

namespace App\Repositories\ContractsRepository;

use App\Post;
use App\Respositories\InterfacesRepository\PostInterfaceRepository;

class PostEloquentRepository extends \EloquentRepository implements PostInterfaceRepository
{

    public function getModel()
    {
        return Post::class;
    }

    public function getAllPublished()
    {
        $result = $this->_model->select('id','title','content','is_published')->where('is_published', 1)->get()->toArray();

        return $result;
    }

    public function findOnlyPublished($id)
    {
        $result = $this->_model->where('id',$id)->where('is_published',1)->first();

        return $result;
    }
}