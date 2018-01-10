<?php
/**
 * Created by PhpStorm.
 * User: nguyen-dat
 * Date: 04/12/2017
 * Time: 19:33
 */
namespace App\Repositories\Eloquents;

use App\ConfirmContent;
use App\Repositories\Contracts\ConfirmContentsRepositoryInterface;

class ConfirmContentsRepository extends \EloquentRepository implements ConfirmContentsRepositoryInterface
{

    public function getModel()
    {
        return ConfirmContent::class;
    }

    public function createEmptyObject() {
        return new ConfirmContent();
    }

    public function save(ConfirmContent $confirm_content) {
        $confirm_content->save();

        return $confirm_content;
    }
}