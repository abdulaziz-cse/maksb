<?php

namespace App\Http\Controllers\Api\V2\Settings;

use App\Traits\GeneralTrait;
use Illuminate\Http\JsonResponse;
use App\Services\V2\Settings\CategoryService;
use App\Http\Controllers\Api\V1\BaseApiController;
use App\Http\Resources\V2\Settings\Category\CategoryResource;

class CategoryController extends BaseApiController
{
    use GeneralTrait;

    public function __construct(private CategoryService $categoryService)
    {
        parent::__construct();
    }

    public function index(): JsonResponse
    {
        $categories = $this->categoryService->getMany();

        return $this->returnDateWithPaginate(
            $categories,
            'success',
            CategoryResource::class
        );
    }
}
