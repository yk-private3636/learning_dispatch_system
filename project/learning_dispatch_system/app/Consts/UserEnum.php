<?php

namespace App\Consts;

enum UserEnum
{
	case GENERAL;
	case ADMIN;

	public function guardName(): string
	{
		return match($this) {
			self::GENERAL => 'general',
			self::ADMIN => 'admin'
		};
	}
}