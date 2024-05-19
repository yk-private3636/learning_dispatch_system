<?php

return [
	'successful' => [
		'passwordReset' => 'パスワードの再設定が完了しました。',
		'passwordProcedureReset' => 'パスワードリセットご案内メールを送信しました。',
		'userRegist' => '会員登録が完了しました。'
	],

	'unsuccessful' => [
		'auth' => '認証に失敗しました。',
	],

	'mail' => [
		'passwordReset' => 'パスワードリセットの手続きメールを送信しました。'
	],
	
	'mistake' => [
		'step_fir' => 'パスワード入力間違えが規定回数超えました。5分間アカウントロック中です。',
		'step_sec' => 'パスワード入力間違えが規定回数超えました。1時間アカウントロック中です。',
		'step_thi' => 'パスワード入力間違えが規定回数超えました。アカウントが利用停止中です。',
	],

	'err' => [
		'system' => 'システムエラーが発生しました。'
	],

	'exception' => [
		'retryThresholdExceed' => 'リトライ回数が閾値を超えました。',
		'lackException' => '扱っているパラメータが欠けています。',
		'argvArrInvalidException' => '想定外の配列の中身です。'
	]
];