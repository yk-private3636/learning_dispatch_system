<?php

return [
	'required' => '必須項目です。',
	'size' => ':size文字で入力してください。',
	'email' => 'メールアドレスの形式に誤りがあります。',
	'same' => ':attributeと同じ値を入力してください。',
	'password' => [
		'combin' => '大文字・小文字・数字・記号を組み合わせた12文字以上で入力してください。'
	],

	'exists' => [
		'email' => '登録されていないメールアドレスになります。'
	],

	'rule' => [
		'ActivateTokenExistsCkRule' => '有効なURLではありません。'
	]
];