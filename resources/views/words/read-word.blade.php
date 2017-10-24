@extends('layouts.full')

@section('content')

    <div class="container" style="margin-left: 10px">
        <div class="row">
            <h3>{{$apr}}%</h3>
            <h1>{{$word['word_name']}}</h1>
        </div>
        @foreach($word['symbols'] as $symbol)
            <div class="row">
                {{--英 [{{$symbol['ph_en']}}]--}}

                {{--<div class="glyphicon glyphicon-play word-play">--}}
                    {{--<audio src="{{$symbol['ph_en_mp3']}}" ></audio>--}}
                {{--</div>--}}


                {{--美 --}}
                [{{$symbol['ph_am']}}]
                <div class="glyphicon glyphicon-play word-play" id="ph_am_mp3" data-src="{{$symbol['ph_am_mp3']}}" >
                    <audio src="{{$symbol['ph_am_mp3']}}"></audio>
                </div>



            </div>
            <div class="row">

                @foreach($symbol['parts'] as $v)
                    {{$v['part']}}  {{implode(' ',$v['means'])}}<br>
                @endforeach
            </div>
        @endforeach


    </div>
    <nav class="navbar navbar-default navbar-fixed-bottom">
        <div class="container">
            <div class="row center-block">
                <div class="col-md-1 col-xs-1  ">
                    <a style="font-size: 3em" href="{{build_url('/words')}}"
                    class="glyphicon glyphicon-remove" aria-hidden="true"></a>
                </div>
                <div class="col-md-1 col-xs-1 col-md-offset-1 col-xs-offset-1 ">

                    <a style="font-size: 3em" href="{{build_url('/words/read-word',['action'=>'last'])}}"
                       class="glyphicon glyphicon-chevron-left"
                       aria-hidden="true"></a>
                </div>
                <div class="col-md-1 col-xs-1 col-md-offset-4 col-xs-offset-4">
                    <a style="font-size: 3em" href="{{build_url('/words/read-word',['action'=>'next'])}}"
                       class="glyphicon glyphicon-chevron-right" id="next_page"
                       aria-hidden="true"></a>
                </div>
            </div>
        </div>
    </nav>
@endsection
@section('js')
    <script>
        var wait = function (t) {
            var $d = $.Deferred();
            setTimeout(function () {
                $d.resolve();
            }, t);
            return $d.promise();
        };
        $(function () {
            $('.word-play').click(function () {
                $(this).removeClass('glyphicon-play').addClass('glyphicon-pause');
                $(this).find('audio').attr('src',$(this).attr('data-src'));
                $(this).find('audio')[0].play();
                var that = $(this);
                setTimeout(function () {
                    $(that).addClass('glyphicon-play').removeClass('glyphicon-pause');
                },1000)
            });

            
            var defer = $.Deferred();
            defer.then(function () {
                $('#ph_am_mp3').click();
                return wait(2000)
            }).then(function () {
                $('#ph_am_mp3').click();
                return wait(2000)
            }).then(function () {
                $('#ph_am_mp3').click();
                return wait(4000)
            });

            defer.resolve();


        })
    </script>
    @if($isAuto)
        <script>
            $(function () {
                var defer = $.Deferred();
                defer.then(function () {
                    return wait(8000)
                }).then(function () {
                    window.location.href=$('#next_page').attr('href');
                });
                defer.resolve();
            })
        </script>
    @endif
@endsection

