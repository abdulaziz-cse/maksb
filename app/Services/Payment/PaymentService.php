<?php

namespace App\Services\Payment;

use App\Models\Ad;
use App\Models\Order;
use App\Models\User;
use App\Contracts\Repositories\OrderRepositoryInterface;
use Exception;
use Omnipay\Omnipay;

/**
 * To handle payment for a new entity
 * Add a new class with the same name as payment type in the Handlers folder
 * and implement all required methods className === ucfirst(payment_type)
 */

class PaymentService {

	/**
	 * An instance of current payment gateway
	 *
	 * @var \App\Services\Payment\PaymentMethod
	 */
	private $paymentMethod;

	/**
	 * Course Service
	 * @var \App\Services\EnrollService;
	 */
	private $enrollService;

	/**
	 * Data provided to process the payment
	 *
	 * @var array
	 */
	private $data;

	private $defaultPaymentType = 'product';

	public function __construct(OrderRepositoryInterface $orderRepository)
	{
		$this->orderRepository = $orderRepository;
	}

	/**
	 * Initialize the service
	 *
	 * @param  string  $gateway
	 * @return void
	 */
	public function initialize(string $gateway): void
	{
		$this->paymentMethod = PaymentMethodFactory::make($gateway);
	}

	public function handlePayment(User $user, array $data): Order
	{
		$data['payment_type'] = $data['payment_type'] ?? $this->defaultPaymentType;

		$this->initialize($data['gateway']);

		$handler = $this->getPaymentHandler($user, $data);
		$order = $handler->purchase();

		return $order;
	}

	public function verify(int $userId, string $transactionId)
	{
		$order = $this->orderRepository->getFirstTrans($userId,$transactionId);

//        $order->load('shippingAddress');

        return $order;
	}

	public function handleWebhookRequest(array $data): void
	{
		$order = $this->orderRepository->getFirst('transaction_id',$data['data']['id']);

        if (!$order) {
        	\Log::error('Payment order not found - transaction_id = ' . $data['data']['id']);
        	return;
        }

        if ($order->status != 'Pending') {
			\Log::error('Error: Invalid order status, the order is ' . $order->status . ' - ' . $order->id);
		}

		if ($data['type'] === 'payment_paid') {
			$this->initialize($order->payment_gateway);
			$order->load('user');

			$products = [];

			foreach ($order->items as $key => $orderItem) {
				$products[] = [
					'id' => $orderItem->item_id,
					'quantity' => $orderItem->quantity,
					'price' => $orderItem->price,
				];
			}

			$handler = $this->getPaymentHandler($order->user, [
				'payment_type' => 'product',
				'products' => $products,
			]);

			$handler->setAsPaid();

			$order->update(['status' => 'Completed']);

        } elseif ($data['type'] === 'payment_failed') {
            \Log::error('Payment failed: '.$order->id.':transaction_id = ' . $data['data']['id']);
            $order->update(['status' => 'Failed']);
        } else {
        	\Log::error('invalid webhook object type: ' . $data['type']);
        }
	}

	public function getPaymentHandler(User $user, array $data) {
		$handlerClassName = '\App\Services\Payment\Handlers\\' . ucfirst($data['payment_type']);

		if (! class_exists($handlerClassName)) {
			abort(400, ucfirst($data['payment_type']) . ' payment not available');
		}

		return new $handlerClassName(
			$user,
			$data,
			$this->paymentMethod,
			$this->orderRepository,
		);
	}
}
