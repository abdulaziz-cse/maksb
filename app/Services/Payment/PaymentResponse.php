<?php

namespace App\Services\Payment;

interface PaymentResponse
{
	/**
	 * Get transaction id
	 * 
	 * @return string
	 */
	public function getTransactionReference(): string;

	/**
	 * Check whether payment has any errors or not.
	 * 
	 * @return boolean
	 */
	public function hasError(): bool;

	/**
	 * Check whether payment was successful or not.
	 * 
	 * @return boolean
	 */
	public function isSuccessful(): bool;

	/**
	 * Get error message if exists
	 * 
	 * @return string|null
	 */
	public function getMessage(): ?string;

	/**
	 * Get redirect url if applicable
	 * 
	 * @return string|null
	 */
	public function getRedirectUrl(): ?string;

	/**
	 * Return response data
	 * 
	 * @return array
	 */
	public function getData(): array;
}