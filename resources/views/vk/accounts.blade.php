<h1 class="page-header">Рекламные кабинеты</h1>
<ul>
@foreach($res as $acc)
  <li>
    {!! link_to_route('compaigns', "$acc->account_id {$acc->access_role}", $acc->account_id) !!}
  </li>
@endforeach

</ul>
