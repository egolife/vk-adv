@extends('app')

@section('content')
<h1 class="page-header">Объявления по компании {{ $campaign or "--" }}</h1>

<table class="table table-striped">
  <tr>
    <th>id</th>
    <th>Формат объявления</th>
    <th>Тип оплаты</th>
    <th>cpc (cpm)</th>
    <th>Лимит показов</th>
    <th>Доп площадки</th>
    <th>Лимит в рублях</th>
    <th>Id Категорий</th>
    <th>Статус</th>
    <th>Название</th>
    <th>Модерация</th>
  </tr>
@foreach($res as $ad)
  <tr>
    <td> {{ $ad->id }}</td>
    <td> {{ $ad->ad_format }}</td>
    <td> {{ $ad->cost_type ? 'За показы' : 'За переходы' }} </td>
    <td>{{ $ad->cpc or $ad->cpm }}</td>
    <td>{{ $ad->impressions_limit or 'н/д'  }}</td>
    <td>{{ $ad->ad_platform ? 'Только ВК' : 'ВК и партнеры' }}</td>
    <td>{{ $ad->all_limit }}</td>
    <td>{{ $ad->category1_id }} {{ $ad->category2_id }}</td>
    <td>{{ $ad->status == 0 ? 'остановлено' : $ad->status == 1 ? 'запущено' : 'удалено' }}</td>
    <td>{{ $ad->name }}</td>
    <td>{{ $ad->approved == 0 ? 'не проходило' : $ad->approved == 1 ? 'ожидает' : $ad->approved == 2 ? 'одобрено' : 'отклонено' }}</td>
  </tr>
@endforeach

</table>
@stop
