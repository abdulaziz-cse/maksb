<?php

namespace App\Http\Controllers\Api\V1\Payment;

use App\Exceptions\PaymentGatewayException;
use App\Http\Controllers\Api\V1\BaseApiController;
use App\Http\Requests\Api\V1\PaymentRequest;
use App\Services\Payment\PaymentService;
use Illuminate\Http\Request;

/**
 * @group Payments
 */
class PaymentController extends BaseApiController
{
	private $paymentService;

	public function __construct(PaymentService $paymentService)
	{
        parent::__construct();

		$this->paymentService = $paymentService;
	}

    /**
     * Payment
     *
     * Redirect the user to `transaction_url` of the response if the returned order status is `Pending`.
     * If returned order status is `Completed` no redirect required and payment succeeded.
     * Order status could also be `Canceled` or `Failed`. Use `4111111111111111` as card number
     * and any future date/cvc/name for testing.
     *
     * @responseFile 200 responses/orders/details.json
     * @responseFile 401 scenario="Unauthenticated" responses/errors/401.json
     * @responseFile 422 scenario="Validation errors" responses/errors/422.json
     *
     * @param  \App\Http\Requests\PaymentRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function pay(PaymentRequest $request)
    {
    	$data = $request->validated();
        $order = $this->paymentService->handlePayment(auth()->user(), $data);
        return response()->json($order);

    }

    public function webhook(Request $request): void
    {
        \Log::debug('Payment webhook called: '.json_encode($request->all()));
        if (urldecode($request->get('secret_token')) !== config('maksb.webhook_secret')) {
            \Log::error('Invalid webhook secret: '.$request->get('secret_token'));
            abort(400, 'Invalid webhook secret.');
        }

        $this->paymentService->handleWebhookRequest($request->all());
    }

    /**
     * Verify payment
     *
     * @responseFile 200 responses/orders/details.json
     * @responseFile 401 scenario="Unauthenticated" responses/errors/401.json
     * @responseFile 404 scenario="Order not found" responses/errors/404.json
     *
     * @param  string $transactionId  Transaction id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function verify($transactionId)
    {
        $order = $this->paymentService->verify(auth()->id(), $transactionId);
        if (! $order) {
            abort(404, 'Order not found');
        }

        return response()->json($order);
    }
}
