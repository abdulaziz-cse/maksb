<?php

namespace App\Services\Payment\Methods;

use App\Services\Payment\PaymentMethod;
use App\Services\Payment\PaymentResponse;
use App\Services\Payment\Responses\MoyasarResponse;
use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Omnipay;

class Moyasar implements PaymentMethod {

	protected $gateway;

	public function __construct()
	{
		$this->gateway = Omnipay::create('Moyasar');
		$this->gateway->setApiKey(config('maksb.moyasar_api_key'));
	}

	/**
	 * Create payment at moyasar api
	 *
	 * @return \App\Services\Payment\PaymentResponse
	 */
	public function purchase(array $data): PaymentResponse
	{
		$data = $this->getData($data);

		$response = $this->gateway->purchase($data)->send();

		return new MoyasarResponse($response);
	}

	/**
	 * Convert gateway initial response to one of
	 * our order statuses
	 *
	 * @param  array $data Purchase response data
	 *
	 * @return string
	 */
	public function getPurchaseOrderStatus(array $data): string
	{
		$status = $data['status'];
		switch ($status) {
			case 'initiated':
				return 'Pending';
				break;
			case 'succeeded':
				return 'Completed';
				break;
			default:
				return 'Failed';
				break;
		}
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
		$callbackUrl = config('biker.frontend_url').'/checkout/result';

		return [
			'amount' => $data['amount'],
			'currency' => $data['currency'],
			'description' => $data['description'],
			'callbackUrl' => $callbackUrl,
			'source' => $this->getSource($data),
		];
	}

	/**
	 * Get payment source for moyasar api
	 *
	 * @param  array  $data
	 *
	 * @return array
	 */
	public function getSource(array $data): array
	{
		if ($data['method'] === 'creditcard') {
			return [
				'type' => 'creditcard',
				'name' => $data['card_name'],
				'number' => $data['card_number'],
				'month' => $data['card_month'],
				'year' => $data['card_year'],
				'cvc' => $data['card_cvc'],
				'3ds' => true,
			];
		} else {
			return [
				'type' => 'sadad',
				'username' => $data['sadad_username'],
			];
		}
	}
}
