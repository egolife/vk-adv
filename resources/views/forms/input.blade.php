<div class="form-group {{ $errors->has($name) ? 'has-error has-feedback' : null }}">
  @if(isset($labelClass))
    {!! Form::label($name, $label, ['class' => $labelClass . ' control-label']) !!}
  @else
    {!! Form::label($name, $label, ['class' => 'col-sm-4 control-label']) !!}
  @endif
  <div class="{{$inputWrapperClass or 'col-sm-8'}}">
    @if(isset($type))
      {!! Form::input($type, $name, isset($value) ? $value : null, ['class' => 'form-control']) !!}
    @else
      {!! Form::text($name, null, ['class' => 'form-control']) !!}
    @endif

    @if($errors->has($name))
      <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
      <span class="help-block">{{ $errors->first($name) }}</span>
    @endif
  </div>
</div>