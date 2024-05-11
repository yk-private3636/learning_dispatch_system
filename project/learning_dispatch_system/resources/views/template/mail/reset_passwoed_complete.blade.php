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
		<div>ご利用のアカウント({{ $user->email }})のパスワードがリセットされました。</div>
		<div>お客様がこの変更を行っていない場合、または他人が不正にアクセスしていると思われる場合は、</div>
		<div>{{ route('login.forget.show') }}にアクセスをして、速やかにパスワードを変更してください。</div>
	@endsection
</body>
</html>