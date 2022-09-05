<!DOCTYPE html>
<html>
<head>
	<title>New Message</title>
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

	</style>
</head>
<body>
	<div class="navigation">
		@if (!isset($new_thread))
		@if (isset($isAnswer))
		<a href="{{ route('threadView', ['thread' => $q_id->related_thread]) }}"><button>Назад</button></a>
		@elseif (isset($related_thread))
		<a href="{{ route('threadView', ['thread' => $related_thread]) }}"><button>Назад</button></a>
		@endif
		@else
		<a href="{{ route('indexThread') }}"><button>Назад</button></a>
		@endif
		<a href="{{ route('indexCategory') }}"><button>Категории</button></a>
		<a href="{{ route('indexThread') }}"><button>Список Тем</button></a>
	</div>
	<?php $isMainInThread = 0;
	$route = 'storeMessage';
	?>
	@isset ($new_thread)
	<?php 
	$route = 'storeThread';
   ?>
	@endisset
		<!-- {{route('storeThread')}} /new_thread/store-->
	<form method="POST" action="{{ route($route) }}">
		@csrf
		@isset ($new_thread)
			<p>Заголовок дискуссии:</p>
			<input type="text" name="title" value="">
			<p>Выберите категорию:</p>
				<select name="category_id">
					@foreach ($categories as $item)
					<option value="{{ $item->id }}">{{ $item->name }}</option>
					@endforeach
				</select>	
		<input type="hidden" name="isClosed" value="0">		
			<?php $isMainInThread = 1 ?>
		@endisset
		@isset ($isAnswer) 
			<p>Ответ на сообщение: {{ $q_id->id }}</p>
			<input type="hidden" name="question" value="{{ $q_id->id }}">
		@endisset
		@isset ($related_thread)
			<input type="hidden" name="related_thread" value="{{ $related_thread }}">
		@endisset 
		<p>Сообщение:</p>
		<textarea  name="body" value=""></textarea>	
		<!-- @if ($isMainInThread)
		main
		@else
		not-main
		@endif -->	
		<input type="hidden" name="isMainInThread" value="{{ $isMainInThread }}">		
		<input type="hidden" name="user_id" value="{{ Auth::id() }}">		
        <input class="btn" type="submit" name="knopka" value="Отправить">
	</form>
</body>
</html>