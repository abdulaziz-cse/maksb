<?php

namespace App\Services\Payment;

use App\Models\Order;
use App\Models\User;
use App\Contracts\Repositories\OrderRepositoryInterface;
use Illuminate\Support\Facades\Http;


/**
 * To handle payment for a new entity
 * Add a new class with the same name as payment type in the Handlers folder
 * and implement all required methods className === ucfirst(payment_type)
 */

class PaymentService {

	public function __construct(OrderRepositoryInterface $orderRepository)
	{
		$this->orderRepository = $orderRepository;
	}


	public function handlePayment(User $user, array $data)
	{
        $callbackUrl = config('maksb.frontend_url').'/checkout/result';
        $secret_key = config('maksb.moyasar_api_key');
        $response = Http::withBasicAuth($secret_key, '')->post('https://api.moyasar.com/v1/payments',
        [
        "amount"=> $data['amount'],
        "currency" => "SAR",
        "description"=> "Payment for project",
        "callback_url"=> $callbackUrl,
        "source" => [
            "type"=> "creditcard",
            "name"=> $data['card_name'],
            "number"=> $data['card_number'],
            "cvc"=> $data['card_cvc'],
            "month"=> $data['card_month'],
            "year"=> $data['card_year']
                    ]
        ]);
       $responseArray =  $response->json();
       $order = $this->orderRepository->create([
           'user_id' => $user->id,
           'amount' => $responseArray['amount'],
           'currency' => $responseArray['currency'],
           'payment_gateway' => 'Moyasar',
           'payment_method' => 'creditcard',
           'status' => $responseArray['status'],
           'transaction_id' => $responseArray['id'],
           'transaction_url' => $responseArray['source']['transaction_url']
       ]);

       return $order;

	}

	public function verify(int $userId, string $transactionId)
	{
		$order = $this->orderRepository->getFirstTrans($userId,$transactionId);

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

}
