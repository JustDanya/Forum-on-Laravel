<!DOCTYPE html>
<html>
<head>
	<title>Update Message</title>
	<style type="text/css">
		.navigation
		{
			display: flex;
			justify-content: flex-start;

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
		button
		{
			color: blue;
			background-color: #66ffff;
		}

	</style>
</head>
<body>
	<div class="navigation">
		<a href="{{ route('threadView', ['thread' => $message->related_thread]) }}"><button>Назад</button></a>
		<a href="{{ route('indexCategory') }}"><button>Категории</button></a>
		<a href="{{ route('indexThread') }}"><button>Список Тем</button></a>
	</div>
<form method="POST" action="{{ route('updateMessage', ['message' => $message->id]) }}">
	@csrf
	<textarea name="body">{{ $message->body }}</textarea>
	<input class="btn" type="submit" value="Изменить">
</form>
</body>
</html>