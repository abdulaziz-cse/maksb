<?php

namespace App\Contracts;

use App\Models\Order;
use App\Services\Payment\PaymentResponse;

interface PaymentHandler
{
	/**
	 * Start item purchase
	 * 
	 * @return \App\Models\Order $order
	 */
	public function purchase(): Order;

	/**
	 * Create order for purchased entity
	 * 
	 * @param  \App\Services\Payment\PaymentResponse $paymentResponse	Payment response
	 * 
	 * @return \App\Models\Order
	 */
	public function createOrder(PaymentResponse $paymentResponse): Order;
	
	/**
	 * Set order as paid
	 * 
	 * @param int    $userId
	 * @param object $purchaseableEntiry
	 *
	 * @return void
	 */
	public function setAsPaid(): void;
}
