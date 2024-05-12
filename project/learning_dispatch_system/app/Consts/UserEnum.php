<?php

namespace App\Consts;

use App\Models\GeneralUser;
use App\Models\AdminUser;

enum UserEnum
{
	case GENERAL;
	case ADMIN;

	public function guardName(): string
	{
		return match($this) {
			self::GENERAL => 'general',
			self::ADMIN   => 'admin'
		};
	}

	public function division(): int
	{
		return match($this) {
			self::GENERAL => 0,
			self::ADMIN   => 1,
		};
	}

	public function model(): string
	{
		return match($this) {
			self::GENERAL => GeneralUser::class,
			self::ADMIN   => AdminUser::class,
		};
	}

	public function relationKey(): string
	{
		return match($this) {
			self::GENERAL => 'generalUser',
			self::ADMIN   => 'adminUser',
		};
	}
}