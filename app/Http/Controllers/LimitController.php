<?php

namespace App\Http\Controllers;

use App\Codes\Repositories\User\Repository as UserRepository;
use App\Codes\Repositories\Product\Repository as ProductRepository;

class LimitController extends Controller
{

    protected $productRepository;

    protected $userRepository;

    public function __construct(ProductRepository $productRepository, UserRepository $userRepository)
    {
        $this->productRepository = $productRepository;
        $this->userRepository = $userRepository;
    }

    public function index()
    {

        $users = $this->userRepository->getAllWithRoles();

//        event(new LimitChangeEvent("Berhasil Yeay"));

        return view('pages.limit.index', compact('users'));

    }
}
