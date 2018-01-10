<?php

namespace App\Http\Controllers;

use App\Http\Services\EncryptionService;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function showQuestionSurvey($encrypt)
    {
        $encryption_service       = new EncryptionService();
        $id = $encryption_service->decrypt($encrypt);
        echo $id;
    }
}
