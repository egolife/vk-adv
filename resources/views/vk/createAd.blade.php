@extends('app')


@section('content')

  <form class="form-horizontal" action="/" method="post">
    <div class="form-group {{$errors->has('test') ? 'has-error has-feedback' : null }}">
      {!! Form::label('test', 'Проверка:', ['class' => 'control-label']) !!}
      {{--{!! Form::('test', null, ['class'=> 'form-control']) !!}--}}
      <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
      <span class="help-block">{{ $errors->first('test') }}</span>
    </div>


  </form>
@stop