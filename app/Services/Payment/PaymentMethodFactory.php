<?php

namespace App\Services\Payment;

use App\Services\Payment\Methods\Cash;
use App\Services\Payment\Methods\Moyasar;
use App\Services\Payment\Methods\Paypal;

class PaymentMethodFactory {

	public static function make(string $gateway)
	{
		switch ($gateway) {
			case 'moyasar':
				return new Moyasar();
				break;
			case 'paypal':
				return new Paypal();
				break;
			case 'cash':
				return new Cash();
				break;
			default:
				throw new \Exception('Payment method not found');
				break;
		}
	}
}
