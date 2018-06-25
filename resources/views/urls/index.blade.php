@extends('layouts.full')

@section('content')

    <div class="container" style="margin-left: 10px;margin-top: 100px">
        <div class="row">
            {{--<form action="/url/add">--}}
            <div class="form-group">
                <label for="exampleInputPassword1"> 短网址:</label>
                {{ url('/u/') }}/<input type="text" name="code" width="20%"><br>
            </div>
            <div class="form-group">

                type: <select name="type" name="type" class="form-control">
                    <option value="1" selected>网址</option>
                    <option value="2">网页</option>
                </select>
            </div>
            <div class="form-group">
                <br>
                内容:<br><textarea class="form-control" name="data"></textarea>
            </div>
            <br>
            <div class="form-group">
                <input id='add_url' type="button" value="添加">
            </div>

            <div id="show">
                短网址:<span id="short_url"></span>
            </div>
        </div>


    </div>
@endsection
@section('js')
    <script>
      $('#show').hide();
      $('#add_url').click(function() {
        $('#show').hide();
        var code = $('[name=code]').val();
        var data = $('[name=data]').val();
        var type = $('[name=type]').val();
        $.post('/url/add', {code: code, data: data, type: type}, function(rs) {
          $('#show').show();
          $('#short_url').html(rs.data.short_url);
          // console.log(rs);
          // alert(rs.message);
        });

      });

    </script>
@endsection

