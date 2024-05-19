<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<div>
		{{ 
			match ($resetPasswordToken->user_division) {
				UserEnum::GENERAL->division() => $resetPasswordToken->generalUser->full_name . '様、',
				UserEnum::ADMIN->division() => $resetPasswordToken->adminUser->full_name . '様、'
			}
		}}
	</div>
	<br>
	@extends('template.mail.common')
	@section('content')
		<div>ご利用のアカウントのパスワードリセット手続きについて、以下の手順に従ってください。</div>
		<div>1. 以下のリンクをクリックしてパスワードリセットページにアクセスしてください。(有効期限は24時間になります。)</div>
		<div>
			@if($resetPasswordToken->user_division === UserEnum::GENERAL->division())
				<a href="{{ route('password.reset.show', $resetPasswordToken->token) }}">{{ route('password.reset.show', $resetPasswordToken->token) }}</a>
			@elseif($resetPasswordToken->user_division === UserEnum::ADMIN->division())
				<a href="{{ url(CommonConst::ADMIN_PREFIX . '/password/reset/' . $resetPasswordToken->token) }}">{{ url(CommonConst::ADMIN_PREFIX . '/password/reset/' . $resetPasswordToken->token) }}</a>
			@else
				{{ throw new \App\Exceptions\LackException }}
			@endif
		</div>
		<div>2. パスワードリセットページで、新しいパスワードを入力し、確認のためもう一度入力してください。</div>
		<div>3. パスワードをリセットするには、"パスワードリセット"ボタンをクリックしてください。</div>
		<div>もし、このリクエストがあなたによるものでない場合は、このメッセージを無視してください。</div>
	@endsection
</body>
</html>