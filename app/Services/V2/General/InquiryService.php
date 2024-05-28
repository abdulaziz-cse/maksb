<?php

namespace App\Services\V2\General;

use App\Services\BuilderService;
use App\Models\V2\General\Inquiry;
use App\Enums\General\InquiryStatus;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Services\V2\Settings\PredefinedValueService;

class InquiryService
{
    public function __construct(private PredefinedValueService $predefinedValueService)
    {
    }

    public function getMany($inquiryFilters): LengthAwarePaginator
    {
        $paginate = $inquiryFilters['paginate'] ?? request()->paginate;
        $builder = Inquiry::select();
        $this->buildGetManyQuery($inquiryFilters, $builder);

        // Prepare sort & search filter if provided
        BuilderService::prepareFilters($inquiryFilters, $builder);
        BuilderService::prepareSort($inquiryFilters, $builder);

        return $builder->paginate($paginate);
    }

    private function buildGetManyQuery($inquiryFilters, $builder)
    {
        $status_id = $inquiryFilters['status_id'];

        if (isset($status_id)) {
            $builder->where('status_id', $status_id);
        }
    }

    public function createOne(array $inquiryData): Inquiry
    {
        $statusId = $this->predefinedValueService->getOneBySlug(
            InquiryStatus::NEW->value
        )?->id;
        $inquiryData['status_id'] = $statusId;

        return Inquiry::create($inquiryData)->fresh();
    }

    public function updateOne(array $inquiryData, Inquiry $inquiry): Inquiry
    {
        return tap($inquiry)->update($inquiryData);
    }

    public function deleteOne(Inquiry $inquiry): bool
    {
        return $inquiry->delete();
    }
}