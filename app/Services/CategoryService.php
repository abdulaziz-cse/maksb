<?php

namespace App\Services;

use App\Contracts\Repositories\CategoryRepositoryInterface;

class CategoryService
{
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function get()
    {
       $categories = $this->categoryRepository->get();
       return $categories;
    }

}
