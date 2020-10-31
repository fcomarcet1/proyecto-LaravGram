<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- CSRF Token -->
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<title>{{ config('app.name', 'Laravel') }}</title>

		<!-- Scripts -->
		<script src="{{ asset('js/app.js') }}" defer></script>
		<script src="{{ asset('js/image_preview.js') }}" defer></script>
		<script src="{{ asset('js/custom_images.js') }}" defer></script>
		<script src="{{ asset('js/main.js') }}" ></script>

		<!-- Fonts -->
		<link rel="dns-prefetch" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

		<!-- Styles -->
		<link href="{{ asset('css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('css/styles.css') }}" rel="stylesheet">
		<link href="{{ asset('css/profile.css') }}" rel="stylesheet">
	</head>
	<body>
		<div id="app">
			<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
				<div class="container">
					<a class="navbar-brand" href="{{ url('/') }}">
						{{ config('app.name', 'Laravel') }}
					</a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
						<span class="navbar-toggler-icon"></span>
					</button>

					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<!-- Left Side Of Navbar -->
						<ul class="navbar-nav mr-auto">

						</ul>

						<!-- Right Side Of Navbar -->
						<ul class="navbar-nav ml-auto">
							<!-- Authentication Links -->
							@guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
						</li>
							@else
							<li class="nav-item">
								<a class="nav-link" href="{{route('home')}}">Inicio</a>
							</li>
							<li class="nav-item">    
								<a  class="nav-link" href="{{route('user.index')}}">Gente</a>
							</li>
							<li class="nav-item">    
								<a  class="nav-link" href="{{route('image.create')}}">Subir Imagen</a>
							</li>
							<li class="nav-item">    
								<a  class="nav-link" href="{{route('like.likes')}}">Favoritos</a>
							</li>

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                                    <a class="dropdown-item" href="{{route('profile',['id' => \Auth::user()->id]) }}">{{ __('Mi perfil') }}</a>

                                    <a class="dropdown-item" href="{{ route('config') }}">{{ __('Configuracion') }}</a>

                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>

                                </div>
                            </li>
							<!--image avatar -->
							<li class="nav-item">
								<div class="container-avatar">
									<img src="{{route('user.avatar', ['filename' => Auth::user()->image ] )}}" class="img-avatar"/>
								</div>
							</li>
							@endguest
						</ul>
					</div>
				</div>
			</nav>

			<main class="py-4">
				@yield('content')
			</main>
		</div>
	</body>
</html>
