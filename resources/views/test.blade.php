@extends('app')


@section('content')
<h1>Just some test</h1>

<form action="/upload-img" method="post" enctype="multipart/form-data">
  {!! csrf_field() !!}

  <p>Грузим файл с картинкой</p>
  <p><input type="file" name="pic"></p>
  <p><input type="submit" value="Отправить"></p>

</form>

@stop