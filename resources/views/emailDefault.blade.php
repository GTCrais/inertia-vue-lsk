<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

		<style>
			.email-body {
              background: #f7f7f7;
			  padding-top: 20px;
              margin: 0;
			}

			.inner-container {
              width: 640px;
              max-width: 80%;
              margin: 0 auto;
              padding: 35px 30px 30px 30px;
			  border-radius: 8px;
              background: #ffffff;
			}

			.table-container {
				font-family: 'Nunito', Tahoma, Verdana, sans-serif;
				color: #2a2a2a;
				border-collapse: collapse;
				width: 100%;
				line-height: 24px;
			}

			p {
				word-wrap: break-word;
			}

			.logo-container {
				margin: 0 0 45px;
				max-width: 100%;
			}

			.logo-link {
				display: block;
			}

			.logo {
				display: block;
				margin: 0 auto;
				width: 300px !important; /* Increase if needed */
				max-width: 100% !important;
			}

			@media screen and (max-width: 400px) {
				.logo-container {
					width: 150px; /* MAX: 250px */
				}

				.logo {
					width: 150px !important; /* MAX: 250px */
				}
			}

			.content-container {
				padding: 0;
			}

			h2 {
              	font-family: 'Nunito', Tahoma, Verdana, sans-serif;
				margin: 0 0 20px 0;
				font-weight: 700;
			  	font-size: 32px;
			  	line-height: 32px;
			}

			a {
				color: #177fce;
				text-decoration: none;
			}

			a:hover {
              	color: #1987da;
			}

			.break-all {
				overflow-wrap: break-word;
				word-wrap: break-word;
				-ms-word-break: break-all;
				/* This is the dangerous one in WebKit, as it breaks things wherever */
				word-break: break-all;
				/* Instead use this non-standard one: */
				word-break: break-word;
				-ms-hyphens: auto;
				-moz-hyphens: auto;
				-webkit-hyphens: auto;
				hyphens: auto;
			}

			a.button {
				color: #fff;
				background: #177fce;
              	border-radius: 9999px;
              	padding: 8px 30px 8px 30px;
				font-size: 17px;
			  	font-weight: 700;
				display: inline-block;
			}

			a.button:hover {
				color: #fff;
				text-decoration: none;
				background: #1987da;
			}

			.with-bm {
				margin-bottom: 15px;
			}
		</style>
	</head>

	<body class="email-body">
		<div class="outer-container">
			<div class="inner-container">
				<table class="table-container">
					<tbody>
						<tr>
							<td>
								<div class="logo-container">
									<a class="logo-link" href="{{ route('pages.show') }}">

										@if(config('mail.default') == 'log')
											<img class="logo" width="150" src="{{ public_path("img/logos/email_logo.png") }}" alt="{{ config('app.name') }}" />
										@else
											<img class="logo" width="150" src="{{ $message->embed(public_path("img/logos/email_logo.png")) }}" alt="{{ config('app.name') }}" />
										@endif

									</a>
								</div>

								<div class="content-container">
									@yield('content')
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</body>
</html>