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
class DatatableController extends Controller
{
	/**
	 * setting language for tools in datatable
	 * @return string
	 */
    public function setupLanguage()
    {
        $language = trans('adminlte_lang::datatable');
        
        return json_encode($language);
    }

    public function showImage($image_path, $image_name)
    {
        $fileDir = Config::get('config.upload_file_path');

        if (file_exists($fileDir .'/'. $image_path.'/'. $image_name))
        {
            $contents = file_get_contents($fileDir .'/'. $image_path.'/'. $image_name);
            header('Content-type: image/png');

            echo $contents;
        }
    }
}