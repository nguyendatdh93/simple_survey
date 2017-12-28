<?php

namespace App\Http\Controllers;

use App\Respositories\InterfacesRepository\PostInterfaceRepository;

class PostController extends Controller
{
    protected $postRepository;

    public function __construct(PostInterfaceRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function index()
    {
        $title = 'Posts';
        $title_headers = array('ID','Title', 'Context', 'Published');
        $posts = $this->postRepository->getAllPublished();
        return view('admin::datatable', array('title' => $title, 'titleHeaders' => $title_headers, 'datas' => $posts));
    }
}
