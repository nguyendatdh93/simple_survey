<?php

namespace App\Http\Controllers;

use App\BaseWidget\BaseController;
use App\Repositories\Contracts\PostEloquentRepository;
use App\Respositories\ClassifyRepositoty\PostRepositoryInterface;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function index()
    {
        $title = 'Posts';
        $title_headers = array('ID','Title', 'Context', 'Published');
        $posts = $this->postRepository->getAllPublished();
        return view('adminlte::datatable', array('title' => $title, 'titleHeaders' => $title_headers, 'datas' => $posts));
    }
}
