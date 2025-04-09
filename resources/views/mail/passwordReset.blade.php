@extends('emailDefault')

@section('content')

	<h2>Password reset</h2>

	<p>
		Hi!
	</p>

	<p>
		Please click the button to reset your password:
	</p>

	<div class="with-bm">
		<a class="button" href="{!! $resetLink  !!}">RESET PASSWORD</a>
	</div>

	<p class="break-all">
		The button doesn't work? Try the reset link:<br>
		<a href="{!! $resetLink  !!}">
			{!! $resetLink  !!}
		</a>
	</p>

@endsection