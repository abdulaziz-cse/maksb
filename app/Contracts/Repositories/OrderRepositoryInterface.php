<?php

namespace App\Contracts\Repositories;

/**
 * Order Repository Interface
 */
interface OrderRepositoryInterface
{
    public function getFirstTrans($user_id,$transaction_id);
}
