<?php

namespace App\Services\Payment\Methods;

use App\Services\Payment\PaymentMethod;
use App\Services\Payment\PaymentResponse;
use App\Services\Payment\Responses\CashResponse;

class Cash implements PaymentMethod {

	protected $data;

	/**
	 * Create payment
	 * 
	 */
	public function purchase(array $data): PaymentResponse
	{
		return new CashResponse();
	}

	/**
	 * Cash payment order status is always Pending until confirmed by admin
	 *
	 * @param  array $data Purchase response data
	 * 
	 * @return string
	 */
	public function getPurchaseOrderStatus(array $data): string
	{
		return 'Pending';
	}

	/**
	 * Get the data required by payment gateway
	 * 
	 * @param  array  $data
	 * 
	 * @return array
	 */
	public function getData(array $data): array
	{
		return $data;
	}
}
