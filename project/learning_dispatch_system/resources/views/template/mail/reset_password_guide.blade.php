<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
	<div>{{ $resetPasswordToken->adminUser->full_name . '様、' }}</div>
	<br>
	@extends('template.mail.common')
	@section('content')
		<div>ご利用のアカウントのパスワードリセット手続きについて、以下の手順に従ってください。</div>
		<div>1. 以下のリンクをクリックしてパスワードリセットページにアクセスしてください。</div>
		<div>
			@if($resetPasswordToken->user_division === UserEnum::GENERAL->division())
				{{ route('passwordResetShow', $resetPasswordToken->token) }}
			@elseif($resetPasswordToken->user_division === UserEnum::ADMIN->division())
				{{ url(CommonConst::ADMIN_PREFIX . '/password/reset/' . $resetPasswordToken->token) }}
			@else
				{{ throw new \App\Exceptions\LackException }}
			@endif
		</div>
		<div>2. パスワードリセットページで、新しいパスワードを入力し、確認のためもう一度入力してください。</div>
		<div>3. パスワードをリセットするには、"パスワードリセット"ボタンをクリックしてください。</div>
	@endsection
</body>
</html>