<?php

namespace App\Consts;

use App\Models\GeneralUser;
use App\Models\AdminUser;
use App\Consts\Interface\TextTransInterface;

enum UserEnum implements TextTransInterface
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

	public function getText(): string
	{
		return match ($this) {
			self::GENERAL => '管理者',
			self::ADMIN   => '一般'
		};
	}
}