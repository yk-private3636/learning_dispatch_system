<?php

namespace App\Http\Controllers\Traits;

use Symfony\Component\HttpFoundation\Response;

trait RtnCodeMsg
{
	private string $msg;
	private int $statusCode;

	final public function setSuccessField(string $msg): void
	{
		$this->msg = $msg;
		$this->statusCode = Response::HTTP_OK;
	}

	final public function setErrorField(?string $msg = null, ?int $statusCode = null): void
	{
		if($msg === null){
			$this->msg = __('message.err.system');
		}
		else{
			$this->msg = $msg;
		}

		if($statusCode === null){
			$this->statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
		}
		else{
			$this->statusCode = $statusCode;
		}
	}
}