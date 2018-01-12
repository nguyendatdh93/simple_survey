<?php
/**
 * Created by PhpStorm.
 * User: nguyen-dat
 * Date: 16/11/2017
 * Time: 20:12
 */
use App\Repositories;

abstract class EloquentRepository implements Repositories\InterfaceRepository
{
    protected $_model;


    public function __construct()
    {
        $this->setModel();
    }

    abstract public function getModel();

    public function setModel()
    {
        $this->_model = app()->make($this->getModel());
    }

    public function getAll()
    {
        return $this->_model->all();
    }

//    public function find($id)
//    {
//        $result = $this->_model->find($id);
//
//        return $result;
//    }

    public function create(array $attributes)
    {
        return $this->_model->create($attributes);
    }


    public function update($id, array $attributes)
    {
       $result = $this->find($id);
        if ($result) {
            $result->update($attributes);

            return $result;
        }

        return false;
    }

    public function delete($id)
    {
        $result = $this->find($id);
        if ($result) {
            $result->delete();

            return true;
        }

        return false;
    }

    public function find($filter) {
        $model = $this->_model;

        foreach ($filter as $key => $value) {
            $model = $model->where($key, $value);
        }

        return $model->where('del_flg', 0)
            ->first();
    }

    public function finds($filter) {
        $model = $this->_model;

        foreach ($filter as $key => $value) {
            $model = $model->where($key, $value);
        }

        return $model->where('del_flg', 0)
            ->get();
    }

    public function remove($model) {
        return $model->delete();
    }

    public function save($model) {
        $model->save();

        return $model;
    }
}