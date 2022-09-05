<!DOCTYPE html>
<html>
<head>
	<title>User: {{$user->name}}</title>
	<style type="text/css">
		.navigation
		{
			display: flex;
			justify-content: flex-start;

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
		a
		{
			color: blue;
			text-decoration: none;
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
	</div>
	@if ($user->isAdmin)
	<h2>Имеет права администратора</h2>
	@endif
	<p>Зарегистрирован: {{ $user->updated_at }}</p>
	<p>Обновлен: {{ $user->updated_at }}</p>
	<p>Имя: {{ $user->name }}</p>
	<p>E-Mail: {{ $user->email }}</p>
	@if (Auth::user()->isAdmin && Auth::id() != $user->id)
		@if (!$user->isAdmin) 
		<?php $string = "Наделить правами администратора"; ?>
		@else
		<?php $string = "Снять права администратора"; ?>
		@endif 
		<form method="POST" action="{{ route('changeRole', ['user' => $user->id]) }}">
			@csrf
			<input class="btn" type="submit" name="button" value="{{ $string }}">
		</form>
	@endif
</body>
</html>