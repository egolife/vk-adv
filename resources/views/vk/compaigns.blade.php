@extends('app')

@section('content')
<h1 class="page-header">Компании аккаунта {{ $acc }}</h1>

<table class="table table-striped">
  <tr>
    <th>id</th>
    <th>Название</th>
    <th>Статус</th>
    <th>Дневной лимит</th>
    <th>Общий лимит</th>
    <th>Время запуска</th>
    <th>Время остановки</th>
  </tr>
@foreach($res as $compaign)
  <tr>
    <td><a href=" {{ route('ads', [$acc, $compaign->id]) }} ">{{ $compaign->id }}</a></td>
    <td><a href=" {{ route('ads', [$acc, $compaign->id]) }} ">{{ $compaign->name }}</a></td>
    <td>{{ $compaign->status }}</td>
    <td>{{ $compaign->day_limit }}</td>
    <td>{{ $compaign->all_limit }}</td>
    <td>{{ $compaign->start_time ?: 'Не задано' }}</td>
    <td>{{ $compaign->stop_time ?: 'Не задано' }}</td>
  </tr>
@endforeach

</table>
@stop
