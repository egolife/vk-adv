@extends('app')

@section('css')
<style>
  #upload{
    margin:10px 30px; padding:10px;
    font-weight:bold; font-size:12px;
    font-family:Arial, Helvetica, sans-serif;
    text-align:center;
    background:#f2f2f2;
    color:#3366cc;
    border:1px solid #ccc;
    width:140px;
    cursor:pointer !important;
    -moz-border-radius:5px; -webkit-border-radius:5px;
  }
  .darkbg{
    background:#ddd !important;
  }
  #status{
    font-family:Arial; padding:5px;
  }
  ul#files{ list-style:none; padding:0; margin:0; }
  ul#files li{ padding:10px; margin-bottom:2px; width:200px; float:left; margin-right:10px;}
  ul#files li img{  }
  .success{}
  .error{ background:#f0c6c3; border:1px solid #cc6622; }
</style>
@stop


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

      <div class="col-sm-offset-4">
        <div id="upload" ><span>Выбрать файл<span></div><span id="status" ></span>
      </div>

      <div class="col-sm-12">
        <ul id="files" ></ul>
      </div>
      
    </div>
  </form>
@stop

@section('js')
<script src=" {{ asset('js/ajaxupload.3.5.js') }} "></script>
<script type="text/javascript" >
  $(function(){
    var btnUpload=$('#upload');
    var status=$('#status');
    new AjaxUpload(btnUpload, {
      action: '/upload-img',
      name: 'uploadfile',
      onSubmit: function(file, ext){
         if (! (ext && /^(jpg|jpeg)$/.test(ext))){ 
                    // extension is not allowed 
          status.text('Поддерживаемые форматы JPG, PNG или GIF');
          return false;
        }
        status.text('Загрузка...');
      },
      onComplete: function(file, response){
        //On completion clear the status
        status.text('');
        btnUpload.hide();
        //Add uploaded file to list
        if(response==="success"){
          $('<li></li>').appendTo('#files').html('<img class="img-rosponsive" src="/img/img.jpg" alt="" /><br />' + file).addClass('success');

        } else{
          $('<li></li>').appendTo('#files').text('Файл не загружен ' + file).addClass('error');
        }
      }
    });
    
  });
</script>

@stop