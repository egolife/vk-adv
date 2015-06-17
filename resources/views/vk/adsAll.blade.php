@extends('app')

@section('content')
<h1 class="page-header">Объявления по всем кампаниям</h1>

<table class="table table-striped">
  <tr>
    <th>Кампания</th>
    <th>Заголовок</th>
    <th>Картинка</th>
    <th>Текст</th>
    <th>Цена</th>
    <th>Лимит</th>
    <th>Оплата за</th>
    <th>Потрачено</th>
    <th>CTR</th>
    <th>Переходы</th>
    <th>Показы</th>
    {{--<th>Формат объявления</th>--}}
    {{--<th>Тип оплаты</th>--}}
    {{--<th>cpc (cpm)</th>--}}
    {{--<th>Лимит показов</th>--}}
    {{--<th>Доп площадки</th>--}}
    {{--<th>Лимит в рублях</th>--}}
    {{--<th>Id Категорий</th>--}}
    {{--<th>Статус</th>--}}
    {{--<th>Модерация</th>--}}
  </tr>
@foreach($ads as $key => $ad)
  <tr>
    <td><a href=" {{ route('ads', [$acc, $ad->campaign_id]) }} ">{{ $campaigns[$ad->campaign_id] }}</a></td>
    <td>{{ $layouts[$key]->title }}</td>
    <td><img src="{{ $layouts[$key]->image_src }}" alt=""/></td>
    <td>{{ $layouts[$key]->description or "--" }}</td>
    <td>{{ $ad->cpc or $ad->cpm }}</td>
    <td>{{ $ad->all_limit }}</td>
    <td>{{ $ad->cost_type ? 'За показы' : 'За переходы' }} </td>
    <td>{{ $ad->spent }} руб</td>
    <td>{{ $ad->ctr ? number_format((float)$ad->ctr, 3) : 0 }}%</td>
    <td>{{ $ad->clicks }}</td>
    <td>{{ $ad->impressions }}</td>



    {{--<td>{{ $ad->impressions_limit or 'н/д'  }}</td>--}}
    {{--<td>{{ $formats[$ad->ad_format] }}</td>--}}
    {{--<td>{{ $ad->ad_platform ? 'Только ВК' : 'ВК и партнеры' }}</td>--}}
    {{--<td>{{ $ad->category1_id }} {{ $ad->category2_id }}</td>--}}
    {{--<td>{{ $ad->status == 0 ? 'остановлено' : $ad->status == 1 ? 'запущено' : 'удалено' }}</td>--}}
    {{--<td>{{ $ad->approved == 0 ? 'не проходило' : $ad->approved == 1 ? 'ожидает' : $ad->approved == 2 ? 'одобрено' : 'отклонено' }}</td>--}}
  </tr>
@endforeach

</table>

{{--  @include('vk.createAd')--}}
@stop
