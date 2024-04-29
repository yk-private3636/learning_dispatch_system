<?php

namespace App\Consts;

class CommonConst
{
	/** アカウント利用ステータス **/
	public const ACCOUNT_USAGE = 0; // 利用中
	public const ACCOUNT_LEAVED = 1; // 退会中
	public const ACCOUNT_LOCKD = 2; // ロック中
	public const ACCOUNT_SUSPEND = 3; // 停止中
	public const ACCOUNT_DELETE_PENDING = 4; // 削除待ち
	/***                ***/

	/** パスワード入力間違え回数閾値 **/
	public const MISTAKE_STEP_FIR = 3; // 入力間違えステップ1(3回まで)
	public const MISTAKE_STEP_SEC = 6; // 入力間違えステップ2(6回まで)
	public const MISTAKE_STEP_THI = 9; // 入力間違えステップ3(9回まで)
	/***                      ***/



}