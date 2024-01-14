<?php

namespace App\Services\Payment\Responses;

use App\Services\Payment\PaymentResponse;
use Illuminate\Support\Str;

class CashResponse implements PaymentResponse
{
	public function getTransactionReference(): string
	{
		return Str::uuid();
	}

	public function isSuccessful(): bool
	{
		return true;
	}

	public function hasError(): bool
	{
		return false;
	}

	public function getMessage(): ?string
	{
		return null;
	}

	public function getData(): array
	{
		return [];
	}

	public function getRedirectUrl(): ?string
	{
		return null;
	}
}
