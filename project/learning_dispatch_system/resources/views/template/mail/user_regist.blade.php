<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<div>{{ $user->full_name }}様、</div>
	<br>
	@extends('template.mail.common')
	@section('content')
		<div>この度は、{{ config('app.name') }} にご登録いただき、誠にありがとうございます。</div>
		<div>ご登録が完了いたしましたので、以下の通りご案内いたします。</div>
		<br>
		<div>登録情報</div>
		<div>・ 氏名: {{ $user->full_name }}</div>
		<div>・ ユーザーID: {{ $user->user_id }}</div>
		<div>・ メールアドレス: {{ $user->email }}</div>
		<br>
		<div>ご利用方法</div>
		<div>1. 下記のURLよりログインしてください。</div>
		<div>2. <a href="{{ $loginUrl }}">{{ $loginUrl }}</a></div>
		<div>3. ログイン後、サービスをご利用いただけます。</div>
	@endsection
</body>
</html>