<?php
/**
 * Created by PhpStorm.
 * User: atb
 * Date: 04/01/2018
 * Time: 09:51
 */

namespace App\Repositories\Contracts;

use App\QuestionChoice;

interface QuestionChoiceRepositoryInterface
{
    public function getQuestionChoiceByQuestionId($question_id);
    public function createEmptyObject();
    public function save(QuestionChoice $question_choice);
	public function getChoiceTextByChoiceId($choice_id);
}