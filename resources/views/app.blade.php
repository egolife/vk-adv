<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'Vk ads manager')</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
</head>
<body>
  @include('inc/navbar')
  <div class="container-fluid">
    @yield('content')
  </div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
{{--<script src=" {{ asset('js/main.js') }} "></script>--}}
<script>
  $(function(){
    $(".js-count").on("input", function(e){
      var $el = $(this);
      var maxLength = $el.data('max-length');
      var val = $el.val();
      var length = val.length;
      if(length > maxLength) {
        $el.val(val.substr(0, maxLength));
        return;
      }
      $(this).closest(".form-group").find(".js-fillable").text(maxLength - length);
    });
  });
  $('#myModal').modal('show');
</script>
</html>