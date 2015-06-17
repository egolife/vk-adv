@extends('app')


@section('content')

  <form class="form-horizontal" action="/" method="post">
    <div class="col-sm-8 col-sm-offset-2">
      <h1 class="page-header">Новое объявление</h1>


      <div class="form-group">
        {!! Form::label('company_id', 'Рекламная компания:', ['class' => 'control-label col-sm-4']) !!}
        <div class="col-sm-8">{!! Form::select('company_id', $campaigns, null, ['class'=> 'form-control']) !!}</div>
      </div>

      <div class="form-group">
        {!! Form::label('ad_format', 'Формат объявления:', ['class' => 'control-label col-sm-4']) !!}

        <div class="col-sm-8">
          <div class="radio">
            <label>
              {!! Form::radio('ad_format', 1, true) !!}
              Изображение и текст
            </label>
          </div>
          <div class="radio">
            <label>
              {!! Form::radio('ad_format', 2, false) !!}
              Большое изображение
            </label>
          </div>
        </div>
      </div>

      <div class="form-group">
        {!! Form::label('cost_type', 'Способ оплаты:', ['class' => 'control-label col-sm-4']) !!}

        <div class="col-sm-8">
          <div class="radio">
            <label>
              {!! Form::radio('cost_type', 0, true) !!}
              Оплата за переходы
            </label>
          </div>
          <div class="radio">
            <label>
              {!! Form::radio('cost_type', 1, false) !!}
              Оплата за показы
            </label>
          </div>
        </div>
      </div>

      @include('forms.input',['name' => 'cpc', 'label' => 'Стоимость перехода (руб):'])
      @include('forms.input',['name' => 'cpm', 'label' => 'Стоимость 1000 показов (руб):'])

      <div class="form-group">
        {!! Form::label('category_id', 'Тематика объявления:', ['class' => 'control-label col-sm-4']) !!}
        <div class="col-sm-8">{!! Form::select('category_id', $categories, null, ['class'=> 'form-control']) !!}</div>
      </div>

      <div class="form-group">
        {!! Form::label('title', 'Заголовок:', ['class' => 'control-label col-sm-4']) !!}
        <div class="col-sm-8">
          {!! Form::text('title', null, ['class'=> 'form-control js-count', 'data-max-length' => 25]) !!}
          <span id="helpBlockTitle" class="help-block">Осталось символов: <i class="js-fillable">25</i></span>
        </div>
      </div>



      <div class="form-group">
        {!! Form::label('description', 'Описание:', ['class' => 'control-label col-sm-4']) !!}
        <div class="col-sm-8">
          {!! Form::text('description', null, ['class'=> 'form-control js-count', 'data-max-length' => 60]) !!}
          <span id="helpBlockDescription" class="help-block">Осталось символов: <i class="js-fillable" data-max-length="60">60</i></span>
        </div>
      </div>


    </div>
  </form>
@stop