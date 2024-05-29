<?php

namespace App\Http\Controllers\Api\V2\General;

use App\Models\V2\General\Inquiry;
use App\Services\V2\General\InquiryService;
use App\Http\Controllers\Api\V2\BaseApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Http\Resources\V2\General\Inquiry\InquiryResource;
use App\Http\Requests\Api\V2\General\Inquiry\InquiryIndexRequest;
use App\Http\Requests\Api\V2\General\Inquiry\InquiryManageRequest;
use App\Http\Requests\Api\V2\General\Inquiry\InquiryUpdateRequest;

class InquiryController extends BaseApiController
{
    public function __construct(private InquiryService $service)
    {
    }

    public function index(InquiryIndexRequest $request): JsonResponse
    {
        $inquiryFilters = $request->validated();
        $inquiries = $this->service->getMany($inquiryFilters);

        return $this->returnDateWithPaginate(
            $inquiries,
            'success',
            InquiryResource::class
        );
    }

    public function store(InquiryManageRequest $request): JsonResponse
    {
        $inquiryData = $request->validated();
        $inquiry = $this->service->createOne($inquiryData);

        return $this->returnDate(
            new InquiryResource($inquiry),
            'success'
        );
    }

    public function update(InquiryUpdateRequest $request, Inquiry $inquiry): JsonResponse
    {
        $inquiryData = $request->validated();
        $inquiry = $this->service->updateOne($inquiryData, $inquiry);

        return $this->returnDate(
            new InquiryResource($inquiry),
            'success'
        );
    }

    public function show(Inquiry $inquiry): JsonResponse
    {
        return $this->returnDate(
            new InquiryResource($inquiry),
            'inquiry data send successfully.'
        );
    }

    public function destroy(Inquiry $inquiry): JsonResponse
    {
        $this->service->deleteOne($inquiry);

        return $this->returnSuccessMessage('inquiry deleted successfully.');
    }
}