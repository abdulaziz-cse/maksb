<?php

namespace App\Repositories;

use App\Contracts\Repositories\BuyerRepositoryInterface;
use App\Models\Buyer;
use Illuminate\Support\Facades\DB;

class BuyerRepositories extends GeneralRepositories implements BuyerRepositoryInterface
{
    public function __construct(Buyer $model)
    {
        parent::__construct($model);
    }


    public function store(array $data, array $BuyertData): Buyer
    {

        DB::beginTransaction();

        try {
            $buyer = $this->create($BuyertData);
            $buyer->projects()->attach($data['project_id']);
            if (!empty($data['file']))
                $buyer->addMedia($data['file'])->toMediaCollection('files');
            DB::commit();
            return $buyer;
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            dd($e);
        }


    }
}
