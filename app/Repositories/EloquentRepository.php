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


    /**
     * EloquentRepository constructor.
     */
    public function __construct()
    {
        $this->setModel();
    }

    /**
     * @return mixed
     */
    abstract public function getModel();

    /**
     *
     */
    public function setModel()
    {
        $this->_model = app()->make($this->getModel());
    }

    /**
     * @return mixed
     */
    public function getAll()
    {
        return $this->_model->all();
    }

    /**
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return $this->_model->create($attributes);
    }


    /**
     * @param $id
     * @param array $attributes
     * @return bool|mixed
     */
    public function update($id, array $attributes)
    {
       $result = $this->find($id);
        if ($result) {
            $result->update($attributes);

            return $result;
        }

        return false;
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $result = $this->find($id);
        if ($result) {
            $result->delete();

            return true;
        }

        return false;
    }

    /**
     * @param $filter
     * @return mixed
     */
    public function find($filter) {
        $model = $this->_model;

        foreach ($filter as $key => $value) {
            $model = $model->where($key, $value);
        }

        return $model->where('del_flg', 0)
            ->first();
    }

    /**
     * @param $filter
     * @return mixed
     */
    public function finds($filter) {
        $model = $this->_model;
        foreach ($filter as $key => $value) {
            $model = $model->where($key, $value);
        }

        return $model->where('del_flg', 0)
                     ->get();
    }

    /**
     * @param $model
     * @return mixed
     */
    public function remove($model) {
        return $model->delete();
    }

    /**
     * @param $model
     * @return mixed
     */
    public function save($model) {
        $model->save();

        return $model;
    }
}