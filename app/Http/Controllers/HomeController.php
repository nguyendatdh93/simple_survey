<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.3/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Config;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function setupLanguage()
    {
        $language = trans('adminlte_lang::datatable');
        return json_encode($language);die;
    }

    public function showImage($image_name)
    {
        $fileDir = Config::get('config.upload_file_path');

        if (file_exists($fileDir .'/'. $image_name))
        {
            $contents = file_get_contents($fileDir .'/'. $image_name);
            header('Content-type: image/jpeg');

            echo $contents;
        }
    }
}