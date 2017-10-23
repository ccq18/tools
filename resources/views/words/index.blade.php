@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <h3>{{$now}}</h3>
            <h1>{{$word['word_name']}}</h1>
        </div>
        @foreach($word['symbols'] as $symbol)
            <div class="row">
                英 [{{$symbol['ph_en']}}]

                <div style="width: 25px;height: 25px;overflow:hidden;display: inline-block;">
                    <audio src="{{$symbol['ph_en_mp3']}}" controls></audio>
                </div>


                美 [{{$symbol['ph_am']}}]
                <div style="width: 25px;height: 25px;overflow:hidden;display: inline-block;">
                    <audio src="{{$symbol['ph_am_mp3']}}" controls id="ph_am_mp3"></audio>
                </div>

                {{--<audio controls="controls" height="100" width="10">--}}
                {{--<source src="{{$symbol['ph_am_mp3']}}" type="audio/mp3" />--}}
                {{--</audio>--}}

            </div>
            <div class="row">
                {{--                <a href="{{$symbol['ph_tts_mp3']}}"></a>--}}

                @foreach($symbol['parts'] as $v)
                    {{$v['part']}}  {{implode(' ',$v['means'])}}<br>
                @endforeach
            </div>
        @endforeach


    </div>
    <nav class="navbar navbar-default navbar-fixed-bottom">
        <div class="container">
            <div class="row center-block">
                <div class="col-md-4 col-xs-1 col-md-offset-1 col-xs-offset-2 ">
                    <a style="font-size: 3.5em" href="{{build_url('/words/index',['word_id'=>$last])}}" class="glyphicon glyphicon-arrow-left"
                       aria-hidden="true"></a>
                </div>
                <div class="col-md-4 col-xs-1 col-md-offset-1 col-xs-offset-5">
                    <a style="font-size: 3.5em" href="{{build_url('/words/index',['word_id'=>$next])}}" class="glyphicon glyphicon-arrow-right "
                       aria-hidden="true"></a>
                </div>
            </div>
        </div>
    </nav>
@endsection
@section('js')
    <script>
        $(function () {
            $.wait = function (ms) {
                var defer = $.Deferred();
                setTimeout(function () {
                    defer.resolve();
                }, ms);
                return defer;
            };
            $('nav.navbar-static-top').hide();
            //3
            var wait = function(t){
                var $d = $.Deferred();
                setTimeout(function(){
                    $d.resolve();
                },t);
                return $d.promise();
            }


//            var heavyWork = doHeavyWork();
            var defer = $.Deferred();
            defer.then(function(){
                $('#ph_am_mp3')[0].play();
                return wait(2000)
            }).then(function(){
                $('#ph_am_mp3')[0].play();
                return wait(2000)
            }).then(function(){
                $('#ph_am_mp3')[0].play();
            });
            defer.resolve();



        })
    </script>
@endsection

