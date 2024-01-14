<?php

namespace App\Services\Payment;

use App\Services\Payment\PaymentResponse;
use Omnipay\Common\Message\AbstractResponse;

interface PaymentMethod {

	/**
	 * Get the data required by payment gateway
	 * 
	 * @param  array  $data
	 * 
	 * @return array
	 */
	public function getData( array $data): array;

	/**
	 * Send purchase request to api
	 * 
	 * @return \App\Services\Payment\PaymentResponse
	 */
	public function purchase(array $data): PaymentResponse;

	/**
	 * Convert gateway purchase response status
	 * to one of our order statuses
	 *
	 * @param  array $data Purchase response data
	 * 
	 * @return string
	 */
	public function getPurchaseOrderStatus(array $data): string;
}
