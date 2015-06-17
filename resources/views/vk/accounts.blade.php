@extends('app')

@section('content')
  <h1 class="page-header">Рекламные кабинеты</h1>
  <ul>
  @foreach($accounts as $item)
    <li>
      {!! link_to_route('vk.acc.put', "$item->account_id {$item->access_role}", $item->account_id) !!}
    </li>
  @endforeach

  </ul>
@stop
