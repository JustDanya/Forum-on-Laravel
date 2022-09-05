<!DOCTYPE html>
<html>
<head>
	<title>Viewing Thread</title>
	<style type="text/css">
		.navigation
		{
			display: flex;
			flex-direction: column;

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
			flex-direction: column;
			justify-content: space-around;
			align-items: 
		}

		.message
		{
			display: flex;
			flex-direction: row;
			border: solid 1px;
			margin: 2%;
		}

		.info-msg
		{
			margin: 1%;
			/*padding: 1%;*/
		}

		.msg-body
		{
			border-left: solid 1px;
			padding-left: 10px;
		}

	</style>
</head>
<body>
	<div class="navigation">
		<div style="display: flex;">
			<a href="{{ route('threadCategory', ['category' => $c_thread->category_id]) }}"><button>Назад</button></a>
			<a href="{{ route('indexCategory') }}"><button>Категории</button></a>
			<a href="{{ route('indexThread') }}"><button>Список Тем</button></a>
			@if (Auth::check())
	           <a href="{{ route('userShow', ['user' => Auth::id()]) }}"><button>Мой Профиль</button></a>

			<form method="POST" action="{{route('logout')}}">
	            @csrf
	            <input class="btn" type="submit" name="knopka" value="Выйти">
	           </form>
		</div>
           <div class="thread-manage" style="display: flex;">
		           @if ($main && !$c_thread->isClosed)
		       <form method="GET" action="{{route('createMessage', ['thread' => $main->related_thread])}}">
		            @csrf
		            <input class="btn" type="submit" name="knopka" value="Отправить сообщение">
		           </form>
		           @endif

		           @if (Auth::id() == $main->user_id && !$c_thread->isClosed)
		           <form method="POST" action="{{ route('closeThread', ['thread' => $c_thread->id]) }}">
		           	@csrf
		            <input class="btn" type="submit" name="knopochka" value="Закрыть Тему">
		           </form>
		           <form method="POST" action="{{ route('updateThread', ['thread' => $c_thread->id]) }}">
		           	@csrf
		            <input type="text" name="title" value="{{ $c_thread->title }}">
		            <input class="btn" type="submit" name="knopochka" value="Изменить Заголовок Темы">
		           </form>
		           @endif
			@else
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
	</div>

@if ($c_thread->isClosed)
<h1>Тема закрыта</h1>
@endif

<h2>{{ $c_thread->title }}</h2>

<div style="display: flex; border: solid 5px;">
@if ($main)
		<div style="margin: 1%;">
			<p class="autor">Автор: <a href="{{ route('userShow', ['user' => $main->user_id]) }}">{{ $main->users->name }}</a></p>
			<p class="timestamps">
			@if ($main->created_at)
				Опубликовано: {{ $main->created_at }}
			@endif
			@if ($main->updated_at)
				Изменено: {{ $main->updated_at }}
			@endif
			</p>
		</div>
		<div style="border-left: solid 5px; padding-left: 10px;">
			<div><p name="main" id="{{$main->id}}" >{{ $main->body }}</p></div>
			<div>
				@if (Auth::check() && !$c_thread->isClosed && Auth::id() == $main->user_id)
					<a href="{{ route('editMessage', ['message' => $main->id]) }}">Изменить</a>
				@endif
				Ответы:
					@foreach ($main->answers as $answer)
					<a href="#{{ $answer->answers }}">{{$answer->answers}}</a>
					@endforeach
				@if (!$c_thread->isClosed && Auth::check())
					<a href="{{ route('createAnswerMsg', ['question' => $main->id]) }}">Ответить</a>
				@endif
				@endif
				<br>
			</div>
		</div>
</div>

<div class="content">
@if ($content)
@foreach ($content as $message)
<div class="message">
	<div class="info-msg">
<p class="autor">Автор: <a href="{{ route('userShow', ['user' => $message->user_id]) }}">{{ $message->users->name }}</a></p>

	<p class="timestamps">
	@if ($message->created_at)
		Опубликовано: {{ $message->created_at }}
	@endif
	@if ($message->updated_at)
		Изменено: {{ $message->updated_at }}
	@endif
	</p>

	@if ( count($message->questions) > 0 )
	Ответ на:
	@foreach ($message->questions as $question)
	<a href="#{{ $question->question }}">{{$question->question}}</a>
	@endforeach
	@endif
	</div>


 	<div class="msg-body"><p name="{{ $message->id }}" id="{{$message->id}}" >{{ $message->body }}</p>
		<div class="msg-input">
		@if (Auth::check() && !$c_thread->isClosed && Auth::id() == $message->user_id)
		<a href="{{ route('editMessage', ['message' => $message->id]) }}">Изменить</a>
		@endif

		Ответы:
		@foreach ($message->answers as $answer)
		<a href="#{{ $answer->answers }}">{{$answer->answers}}</a>
		@endforeach

		@if (!$c_thread->isClosed && Auth::check())
		<a href="{{ route('createAnswerMsg', ['question' => $message->id]) }}">Ответить</a>
		@endif

		@if (Auth::check() && ( Auth::user()->isAdmin || Auth::id() == $message->user_id ))
			<form method="POST" action="{{ route('deleteMessage', ['message' => $message->id]) }}">
				@csrf
				<input class="btn" type="submit" name="sub1" value="Удалить Сообщение">
			</form>
		@endif
		</div>
 	</div>
</div>
@endforeach
@endif
</div>

</body>
</html>