<?php

namespace App\Http\Controllers;

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
        $posts = $this->postRepository->getAllPublished();
        var_dump($posts);die;
    }
}
