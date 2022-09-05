<!DOCTYPE html>
<html>
<head>
	<title>Categories</title>
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

		body
		{
			background-color: #ccffff;
		}

		button
		{
			color: blue;
			background-color: #66ffff;
		}

		.btn
		{
			color: blue;
			background-color: #66ffff;
		}

		.category
		{
			display: flex;
			flex-direction: column;

		}

		.content
		{
			display: flex;
			flex-direction: column;
		}

		.adminForms
		{
			display: flex;
		}

	</style>
</head>
<body>
	<div class="navigation">
		<nav>
			<a href="{{ route('indexCategory') }}"><button >Категории</button></a> 
			<a href="{{ route('indexThread') }}"><button>Список Тем</button></a>
		</nav>
@if (Auth::check())
   <a href="{{ route('userShow', ['user' => Auth::id()]) }}"><button>Мой Профиль</button></a>
   @if (Auth::user()->isAdmin)
   		<form method="POST" action="{{ route('createCategory') }}">
   			@csrf
   			<input type="text" name="name">
   			<input type="submit" name="sub" value="Добавить Категорию" class="btn">
   		</form>
   @endif
@endif
	</div>

<div class="content">
@foreach($content as $cat)
<div class="category">
	<a href="{{ route('threadCategory', ['category' => $cat->id]) }}">{{ $cat->name }}</a>
	   @if (Auth::check() && Auth::user()->isAdmin)
	   	<div class="adminForms">
	   		<form method="POST" action="{{ route('updateCategory', ['category' => $cat->id]) }}">
	   			@csrf
	   			<input type="text" name="name" value="{{ $cat->name }}">
	   			<input type="submit" name="sub1" value="Изменить Название Категории" class="btn">
	   		</form>
	   		<form method="POST" action="{{ route('deleteCategory', ['category' => $cat->id]) }}">
	   			@csrf
	   			<input type="submit" name="sub2" value="Удалить Категорию" class="btn">
	   		</form>
	   	</div>
</div>
	   @endif
	@endforeach
</div>
</body>
</html>