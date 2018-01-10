<?php
/**
 * Created by PhpStorm.
 * User: atb
 * Date: 04/01/2018
 * Time: 09:51
 */

namespace App\Repositories\Contracts;

use App\ConfirmContent;

interface ConfirmContentsRepositoryInterface
{
    public function createEmptyObject();
    public function save(ConfirmContent $confirm_content);
}