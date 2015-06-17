<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
              data-target="#bs-example-navbar-collapse-1">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/">Ads Manager</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href=" {{ route("compaigns", [ $acc or null ]) }} ">Компании</a></li>
        <li class="active"><a href="#">Все объявления</a></li>
        <li class=""><a href=" {{ route('ad.create') }} ">Создать объявление</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
             aria-expanded="false">Кабинет {{ $acc or null }} <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            @foreach($accounts as $item)
              {{--TODO: подсветка активного элемента и возможность смены кабинета при нажатии --}}
              <li><a href="/">{{ $item->account_id . " " . $item->access_role }}</a></li>
            @endforeach
          </ul>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Пользователь</a></li>
      </ul>
    </div>
    <!-- /.navbar-collapse -->
  </div>
  <!-- /.container-fluid -->
</nav>