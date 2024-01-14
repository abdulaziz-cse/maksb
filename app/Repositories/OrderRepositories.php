<?php

namespace App\Repositories;


use App\Contracts\Repositories\OrderRepositoryInterface;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderRepositories extends GeneralRepositories implements OrderRepositoryInterface
{
    public function __construct(Order $model)
    {
        parent::__construct($model);
    }

    public function getFirstTrans($user_id,$transaction_id)
    {
      return  $this->model->where('user_id',$user_id)->where('transaction_id',$transaction_id)->first();
    }
}
