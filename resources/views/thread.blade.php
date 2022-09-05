<!DOCTYPE html>
<html>
<head>
	<title>Threads</title>
	<style type="text/css">
		.navigation
		{
			display: flex;
			justify-content: flex-start;

		}
a
		{
			color: blue;
			text-decoration: none;
		}
		button
		{
			color: blue;
			background-color: #66ffff;
		}
body
		{
			background-color: #ccffff;
		}
		.btn
		{
			color: blue;
			background-color: #66ffff;
		}

		.content
		{
			display: flex;
			flex-direction: row;
			justify-content: space-around;
		}

		.item
		{
			display: flex;
		}

	</style>
</head>
<body>
	<div class="navigation">
		<a href="{{ route('indexCategory') }}"><button>Категории</button></a>
		<a href="{{ route('indexThread') }}"><button>Список Тем</button></a>
	@if (Auth::check())
	<!-- <div class="userInfo"> -->
		<!-- {{ Auth::user() }} -->
           <a href="{{ route('userShow', ['user' => Auth::id()]) }}"><button>Мой Профиль</button></a>
		<form method="POST" action="{{route('logout')}}">
            @csrf
            <input class="btn" type="submit" name="knopka" value="Выйти">
           </form>
       <form method="GET" action="{{route('createThread')}}">
            @csrf
            <input class="btn" type="submit" name="knopka" value="Начать Тему">
           </form>
	<!-- </div> -->
	@else
	<!-- <p>You are not auth</p> -->
			<form method="GET" action="{{route('login')}}">
            @csrf
            <input class="btn" type="submit" name="knopka" value="Войти">
           </form>
           <form method="GET" action="{{route('register')}}">
            @csrf
            <input class="btn" type="submit" name="knopka" value="Зарегистрироваться">
           </form>
	@endif
	</div>
	<div class="content">
<div class="activeItems">
<p>Активные Темы:</p>
@foreach ($active as $athread)
	<div class="item">
	<a href="{{ route('threadView', ['thread' => $athread->id]) }}">{{ $athread->title }}</a>
    @if (Auth::check() && Auth::user()->isAdmin)
		<form method="POST" action="{{ route('deleteThread', ['thread' => $athread->id]) }}">
			@csrf
			<input class="btn" type="submit" name="sub" value="Удалить Тему">
		</form>
	@endif
	</div>
@endforeach
</div>
<div class="closedItems">
<p>Закрытые Темы:</p>
@foreach ($closed as $cthread)
	<div class="item">
	<a href="{{ route('threadView', ['thread' => $cthread->id]) }}">{{ $cthread->title }}</a>
	@if (Auth::check() && Auth::user()->isAdmin)
		<form method="POST" action="{{ route('deleteThread', ['thread' => $cthread->id]) }}">
			@csrf
			<input class="btn" type="submit" name="sub1" value="Удалить Тему">
		</form>
	@endif
 	</div>
@endforeach
</div>
	</div>
</body>
</html>