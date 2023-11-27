<?php

namespace App\Http\Controllers\Api\V1\Category;

use App\Http\Controllers\Api\V1\BaseApiController;
use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends BaseApiController
{
    private $service;

    public function __construct(CategoryService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    public function index()
    {
        $categories = $this->service->get();
        return response()->json($categories);
    }
}
