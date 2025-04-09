@extends('emailDefault')

@section('content')

	<h2>Email address verification</h2>

	<p>
		Hi!
	</p>

	<p>
		Please click the button below to verify your email address:
	</p>

	<div class="with-bm">
		<a class="button" href="{!! $verificationLink  !!}">VERIFY</a>
	</div>

	<p class="break-all">
		The button doesn't work? Try the verification link:<br>
		<a href="{!! $verificationLink  !!}">
			{!! $verificationLink  !!}
		</a>
	</p>

@endsection