<?php

namespace App\Services\Payment\Handlers;

use App\Models\Order;
use App\Models\User;
use App\Contracts\PaymentHandler;
use App\Contracts\Repositories\AdRepositoryInterface;
use App\Contracts\Repositories\OrderRepositoryInterface;
use App\Services\Payment\PaymentMethod;
use App\Services\Payment\PaymentResponse;
use App\Exceptions\PaymentGatewayException;

class Product implements PaymentHandler
{
	private $data;

	private $user;

	private $adRepository;

	private $orderRepository;

	private $paymentMethod;

	public function __construct(User $user, array $data,
		PaymentMethod $paymentMethod, OrderRepositoryInterface $orderRepository)
	{
		$this->user = $user;
		$this->data = $data;
//		$this->adRepository = app()->make(AdRepositoryInterface::class);
		$this->orderRepository = $orderRepository;
		$this->paymentMethod = $paymentMethod;
	}

	/**
	 * Purchase products
	 *
	 * @return \App\Models\Order
	 */
	public function purchase(): Order
	{
		if (! isset($this->data['products'])) {
			abort(400, 'products parameter not available');
		}

		$amount = 0;

		foreach ($this->data['products'] as $key => $p) {
//			if (! isset($p['price'])) {
//				$product = $this->adRepository->getOne($p['id']);
//				if (! $product || $product->type !== 'product') {
//					continue;
//				}
//
//				$amount += $product->price * $p['quantity'];
//				$this->data['products'][$key]['price'] = $product->price;
//			}
//            else {
				$amount += 50 * $p['quantity'];
//                $amount += $p['price'] * $p['quantity'];

//			}
		}

		if ($amount === 0) {
			abort(400, 'Order amount should be greater than 0');
		}

    	$this->data['amount'] = $amount;
    	$this->data['currency'] = 'SAR';
    	$this->data['description'] = 'Maksb package purchase.';

    	// Send purchase request to payment gateway
    	$paymentResponse = $this->paymentMethod->purchase($this->data);

    	if ($paymentResponse->hasError()) {
    		throw new PaymentGatewayException('Payment gateway error: '.$paymentResponse->getMessage());
    	}

    	$order = $this->createOrder($paymentResponse);

    	/**
    	 * If the payment was successful, i.e, not 3ds redirect
    	 * required, we should update the enroll immediately
    	 */
    	if ($paymentResponse->isSuccessful()) {
    		$this->setAsPaid();
    	}

    	return $order;
	}

	public function createOrder(PaymentResponse $paymentResponse): Order
	{
		$order = $this->orderRepository->create([
    		'user_id' => $this->user->id,
    		'amount' => $this->data['amount'],
    		'currency' => $this->data['currency'],
    		'status' => $this->paymentMethod->getPurchaseOrderStatus($paymentResponse->getData()),
    		'payment_gateway' => $this->data['gateway'],
    		'payment_method' => $this->data['method'],
    		'transaction_id' => $paymentResponse->getTransactionReference(),
    		'transaction_url' => $paymentResponse->getRedirectUrl(),
//    		'shipping_address_id' => $this->data['shipping_address_id'] ?? null,
    	]);

//    	foreach ($this->data['products'] as $product) {
//    		$order->items()->create([
//	    		'item_id' => $product['id'],
//	    		'item_type' => \App\Models\Ad::class,
//	    		'price' => $product['price'],
//	    		'quantity' => $product['quantity'],
//	    	]);
//    	}

    	return $order;
	}

	public function setAsPaid(): void
	{
		// Process any payment success callbacks
	}
}
