<?php

return [
	'required' => '必須項目です。',
	'size' => ':size文字で入力してください。',
	'email' => 'メールアドレスの形式に誤りがあります。',
	'same' => ':attributeと同じ値を入力してください。',
	'max' => '最大:digits文字までの入力です。',
	'unique' => '既に存在する:attributeになります。',
	'string' => '文字を入力してください。',
	'enum' => ':attributeは無効な値です。',

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