<?php

namespace App\Http\Controllers\Api\V2\Settings;

use Illuminate\Http\JsonResponse;
use App\Models\V2\Settings\Category;
use App\Services\V2\Settings\CategoryService;
use App\Http\Controllers\Api\V2\BaseApiController;
use App\Http\Resources\V2\Settings\Category\CategoryResource;
use App\Http\Requests\Api\V2\Settings\Category\CategoryIndexRequest;

class CategoryController extends BaseApiController
{
    public function __construct(private CategoryService $categoryService)
    {
    }

    public function index(CategoryIndexRequest $request): JsonResponse
    {
        $categoryFilters = $request->validated();
        $regions = $this->categoryService->getMany($categoryFilters);

        return $this->returnDateWithPaginate(
            $regions,
            'success',
            CategoryResource::class
        );
    }

    public function show(Category $category): JsonResponse
    {
        return $this->returnDate(
            new CategoryResource($category),
            'success'
        );
    }
}