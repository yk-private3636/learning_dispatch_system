<?php

namespace App\Services\Common;

class UrlService
{
	public static function adminSideJudge(string $url): bool
	{
		$url = preg_replace('/^api/', '', $url);

		return (bool)preg_match('/^' . \CommonConst::ADMIN_PREFIX . '|\/' . \CommonConst::ADMIN_PREFIX . '/', $url);
	}
}