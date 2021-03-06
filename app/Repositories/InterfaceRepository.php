<?php
namespace App\Repositories;

interface InterfaceRepository {

    /**
     * Get all
     * @return mixed
     */
    public function getAll();

    /**
     * Create
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes);

    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return mixed
     */
    public function update($id, array $attributes);

    /**
     * Delete
     * @param $id
     * @return mixed
     */
    public function delete($id);

    /**
     * @param $filter
     * @return mixed
     */

    public function find($filter);

    /**
     * @param $filter
     * @return mixed
     */
    public function finds($filter);

    /**
     * @param $model
     * @return mixed
     */
    public function remove($model);

    /**
     * @param $model
     * @return mixed
     */
    public function save($model);
}