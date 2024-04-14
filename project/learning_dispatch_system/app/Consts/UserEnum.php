<?php

namespace App\Consts;

enum UserEnum
{
	case GENERAL;

	public function guardName(): string
	{
		return match($this) {
			self::GENERAL => 'general'
		};
	}
}