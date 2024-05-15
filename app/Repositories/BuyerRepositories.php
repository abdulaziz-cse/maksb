<?php

namespace App\Repositories;

use App\Models\Buyer;
use App\Services\BuilderService;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Contracts\Repositories\BuyerRepositoryInterface;

class BuyerRepositories extends GeneralRepositories implements BuyerRepositoryInterface
{
    public function __construct(Buyer $model)
    {
        parent::__construct($model);
    }

    public function store(array $data, array $BuyertData): Buyer
    {
        return DB::transaction(function () use ($BuyertData, $data) {

            $buyer = $this->create($BuyertData);

            $buyer->projects()->attach($data['project_id']);

            if (!empty($data['file']))
                $buyer->addMedia($data['file'])->toMediaCollection('files');

            return $buyer->refresh();
        });
    }

    // public function store(array $data, array $BuyertData): Buyer
    // {
    //     DB::beginTransaction();

    //     try {
    //         $buyer = $this->create($BuyertData);
    //         $buyer->projects()->attach($data['project_id']);
    //         if (!empty($data['file']))
    //             $buyer->addMedia($data['file'])->toMediaCollection('files', 's3');
    //         DB::commit();
    //         return $buyer;
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         // something went wrong
    //         dd($e);
    //     }
    // }
}
