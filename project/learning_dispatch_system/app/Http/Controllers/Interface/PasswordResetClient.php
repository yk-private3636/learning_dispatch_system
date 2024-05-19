<?php

namespace App\Http\Controllers\Interface;

use App\Http\Requests\PasswordProcedureResetRequest;
use App\Http\Requests\PasswordResetRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

interface PasswordResetClient
{
	public function procedure(PasswordProcedureResetRequest $req): RedirectResponse|JsonResponse;
	public function passwordReset(PasswordResetRequest $req): RedirectResponse|JsonResponse;
	// public function procedure(FormRequest $req): RedirectResponse|JsonResponse;
}