<?php

namespace App\Consts;

class CommonConst
{
	/** パスワード入力間違え回数閾値 **/
	public const MISTAKE_STEP_FIR = 3; // 入力間違えステップ1(3回まで)
	public const MISTAKE_STEP_SEC = 6; // 入力間違えステップ2(6回まで)
	public const MISTAKE_STEP_THI = 9; // 入力間違えステップ3(9回まで)
	/***                      ***/

	public const ORGANIZATION_MARK = '[会社/サービス名]サポートチーム';

	public const ADMIN_PREFIX = 'admin';

	public const SELECT_INIT_VAL = 0;


}