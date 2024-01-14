<?php

namespace App\Services\Payment\Responses;

use App\Services\Payment\PaymentResponse;

class MoyasarResponse implements PaymentResponse
{
	private $response;

	public function __construct(object $moyasarResponse)
	{
		$this->response = $moyasarResponse;
	}

	public function getTransactionReference(): string
	{
		return $this->response->getTransactionReference();
	}

	public function isSuccessful(): bool
	{
		return $this->response->isSuccessful();
	}

	public function hasError(): bool
	{
		return $this->response->hasError();
	}

	public function getMessage(): ?string
	{
		return $this->response->getMessage();
	}

	public function getData(): array
	{
		return $this->response->getData();
	}

	public function getRedirectUrl(): ?string
	{
		return $this->response->getRedirectUrl();
	}
}
