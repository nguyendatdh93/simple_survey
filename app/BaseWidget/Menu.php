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

class Menu
{
    protected $menus = array();

    public function __construct()
    {
        $menus['header'] = trans('adminlte_lang::message.header_menu');
        $menus[] = Array(
            "text"   => trans('adminlte_lang::message.home'),
            "icon"   => "fa fa-link",
            "active" => true,
            "url"    => 'posts',
        );

        $menus[] = Array(
            "text" => trans('adminlte_lang::message.anotherlink'),
            "icon" => "fa fa-link",
            "url"  => '#',
        );

        $menus[] = Array(
            "text"  => trans('adminlte_lang::message.multilevel'),
            "icon"  => "fa fa-link",
            "url"   => '#',
            'child' => array (
                array(
                    "text" => trans('adminlte_lang::message.linklevel2'),
                    "icon" => "fa fa-link",
                    "url"  => '#',
                ),
                array(
                    "text" => trans('adminlte_lang::message.linklevel2'),
                    "icon" => "fa fa-link",
                    "url"  => '#',
                )
            )
        );

        $this->menus = $menus;
    }

    public static function setLeftMenu(Menu $menus)
    {
        return view('adminlte::layouts.partials.sidebar', array('menus' => $menus->getLeftMenu()));
    }

    public function getLeftMenu()
    {
        return $this->menus;
    }

    public static function setLogo(Menu $menus)
    {
        return view('adminlte::layouts.partials.mainheader', array('logo' => $menus->getLogo()));
    }

    public function getLogo()
    {
        return trans('adminlte_lang::header.logo');
    }
}