<?php
/**
 * Created by PhpStorm.
 * User: nguyen-dat
 * Date: 19/11/2017
 * Time: 09:12
 */
namespace App\BaseWidget;

use \App\BaseWidget\Validator;
use Illuminate\Support\Facades\View;
use Config;

class Menu
{
    protected $menus = array();

    public function __construct()
    {
        $menus['header'] = trans('adminlte_lang::message.header_menu');
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $menus['survey_list'] = Array(
            "text"   => trans('adminlte_lang::survey.menu_survey_list'),
            "icon"   => "fa fa-table",
            "active" => true,
            "url"    => '/survey/list',
        );

        $menus['survey_list_download'] = Array(
            "text"   => trans('adminlte_lang::survey.menu_survey_download'),
            "icon"   => "fa fa-cloud-download",
            "active" => false,
            "url"    => '/download/list',
        );

        if(in_array($ip_address, Config::get("config.ip_private"))) {
            $menus['survey_list']['hidden'] = true;
        }

        $this->menus = $menus;
    }

    public static function setLeftMenu(Menu $menus)
    {
        return view('admin::layouts.partials.sidebar', array('menus' => $menus->getLeftMenu()));
    }

    public function getLeftMenu()
    {
        return $this->menus;
    }

    public static function setLogo(Menu $menus)
    {
        return view('admin::layouts.partials.mainheader', array('logo' => $menus->getLogo()));
    }

    public function getLogo()
    {
        return trans('adminlte_lang::header.logo');
    }
}