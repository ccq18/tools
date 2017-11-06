@extends('layouts.app')
@section('title')
    单词设置
@endsection
@section('content')

    <div class="container" style="margin-left: 10px">
        <form action="/words/config" method="post">
            <div class="input-group">
                <label>
                    单词本
                    <div class="radio">
                        <label>
                            <input type="radio"
                                   {{$config['book_id']==1?"checked":""}} name="book_id"
                                   value="1">
                            7000常用词
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio"
                                   {{$config['book_id']==2?"checked":""}} name="book_id"
                                   value="2">
                            CET6
                        </label>
                    </div>
                </label>
            </div>
            <div class="input-group">
                <label>
                    例句
                    <div class="radio">
                        <label>
                            <input type="radio"
                                   @if(isset($config['example'])){{$config['example']==0?"checked":""}}@endif name="example"
                                   value="0">
                            不显示
                        </label>
                    </div>
                    <div class="radio ">
                        <label>
                            <input type="radio"
                                   @if(isset($config['example'])){{$config['example']==1?"checked":""}}@endif  name="example"
                                   value="1">
                            一条
                        </label>
                    </div>
                    <div class="radio ">
                        <label>
                            <input type="radio"
                                   @if(isset($config['example'])){{$config['example']==2?"checked":""}}@endif name="example"
                                   value="2">
                            多条
                        </label>
                    </div>
                </label>
            </div>
            <div class="input-group">
                <label>
                    是否显示英文释义
                    <div class="radio">
                        <label>
                            <input type="radio"
                                   @if(isset($config['english_trans'])){{$config['english_trans']==0?"checked":""}}@endif name="english_trans"
                                   value="0">
                            不显示
                        </label>
                    </div>
                    <div class="radio ">
                        <label>
                            <input type="radio"
                                   @if(isset($config['english_trans'])){{$config['english_trans']==1?"checked":""}}@endif name="english_trans"
                                   value="1">
                            显示
                        </label>
                    </div>
                </label>
            </div>

            <div class="input-group">
                <label>
                    自动发音次数
                    <select class="form-control" name="audio_num" value="">
                        <option @if(isset($config['audio_num'])){{$config['audio_num']==0?"selected":""}}@endif value="0">
                            0
                        </option>
                        <option @if(isset($config['audio_num'])){{$config['audio_num']==1?"selected":""}}@endif value="1">
                            1
                        </option>
                        <option @if(isset($config['audio_num'])){{$config['audio_num']==2?"selected":""}}@endif value="2">
                            2
                        </option>
                        <option @if(isset($config['audio_num'])){{$config['audio_num']==3?"selected":""}}@endif value="3">
                            3
                        </option>
                    </select>
                </label>
            </div>
            <div class="input-group">
                <label>
                    自动跳转时间
                    <select class="form-control" name="auto_jump">
                        <option @if(isset($config['auto_jump'])){{$config['auto_jump']==0?"selected":""}} @endif value="0">
                            不跳转
                        </option>
                        <option @if(isset($config['auto_jump'])){{$config['auto_jump']==6?"selected":""}} @endif value="6">
                            6
                        </option>
                        <option @if(isset($config['auto_jump'])){{$config['auto_jump']==8?"selected":""}} @endif value="8">
                            8
                        </option>
                        <option @if(isset($config['auto_jump'])){{$config['auto_jump']==10?"selected":""}}@endif  value="10">
                            10
                        </option>
                        <option @if(isset($config['auto_jump'])){{$config['auto_jump']==13?"selected":""}}@endif  value="13">
                            13
                        </option>
                    </select>
                </label>
            </div>
            <div class="input-group">
                <label>
                    延迟时间
                    <select class="form-control" name="delay_time">
                        <option @if(isset($config['delay_time'])){{$config['delay_time']==0?"selected":""}} @endif value="0">
                            0
                        </option>
                        <option @if(isset($config['delay_time'])){{$config['delay_time']==1?"selected":""}} @endif value="1">
                            1
                        </option>
                        <option @if(isset($config['delay_time'])){{$config['delay_time']==2?"selected":""}} @endif value="2">
                            2
                        </option>
                        <option @if(isset($config['delay_time'])){{$config['delay_time']==3?"selected":""}}@endif  value="3">
                            3
                        </option>
                        <option @if(isset($config['delay_time'])){{$config['delay_time']==4?"selected":""}}@endif  value="4">
                            4
                        </option>
                    </select>
                </label>
            </div>
            <div class="input-group">
               <button type="submit" class="btn btn-primary ">保存</button>
            </div>
        </form>


    </div>

@endsection
@section('js')
    <script>

    </script>

@endsection

