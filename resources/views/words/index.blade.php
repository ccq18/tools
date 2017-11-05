@extends('layouts.full')
@section('title')
    {{$w->word}}:{{$w->getFirstTranslateText()}}
@endsection
@section('css')
    <style>
        delay {
            display: none;
        }
    </style>
@endsection
@section('content')

    <div class="container" style="margin-left: 10px">
        <div class="row">
            <h3>{{$progress}}</h3>
            <h1>{{$w->word}}</h1>
        </div>
        <div class="row">
            {{--美 --}}
            @if(!empty($w->getPham())) [{{$w->getPham()}}]@endif

            @if(!empty($w->getAmAudio()))
                <div class="glyphicon glyphicon-play word-play" id="ph_am_mp3" data-src="{{$w->getAmAudio()}}">
                    <audio src="{{$w->getAmAudio()}}"></audio>
                </div>
            @endif


        </div>

        <div class="row">
            <div class="delay">
                @if(empty($w->getTranslateTexts()))
                    {{$w->getFirstTranslateText()}}
                @else
                    @foreach($w->getTranslateTexts() as $v)
                        {{$v}}<br>
                    @endforeach
                @endif
            </div>
        </div>
        @if($englishTrans != 0)
            <div class="row">
                <div class="delay">
                    @if(empty($w->getEnglishTrans()))
                        <span class="translateWord">{{$w->getFirstEnglishTran()}}</span>
                    @else
                        @foreach($w->getEnglishTrans() as $v)
                            <span class="translateWord">{{$v}}</span><br>
                        @endforeach
                    @endif
                </div>
            </div>
        @endif
        <br><br>
        @if($example != 0)
            <div class="row">
                <div class="delay">
                    @if($example == 1)
                        @if(!empty($sent['audio_uk']))
                            <div class="glyphicon glyphicon-play word-play"
                                 data-src="{{$sent['audio_uk']}}">
                                <audio src="{{$sent['audio_uk']}}"></audio>
                            </div>
                        @endif
                        @if(!empty($w->firstSent()))
                            <span class="translateWord">{!!$w->firstSent()['orig'] !!} </span><br>
                            {!!$w->firstSent()['trans'] !!} <br>
                        @endif
                    @elseif($example == 2)
                        @foreach($w->sents() as $sent)
                            @if(!empty($sent['audio_uk']))
                                <div class="glyphicon glyphicon-play word-play"
                                     data-src="{{$sent['audio_uk']}}">
                                    <audio src="{{$sent['audio_uk']}}"></audio>
                                </div>
                            @endif
                            @if(!empty($sent))
                                <span class="translateWord">{!!$sent['orig'] !!} </span><br>
                                {!!$sent['trans'] !!} <br>
                            @endif
                        @endforeach
                    @endif
                    <br>
                </div>
            </div>
        @endif
    </div>
    <nav class="navbar navbar-default navbar-fixed-bottom">
        <div class="container">
            <div class="row center-block">
                @if(!empty($lastUrl))
                    <div class="col-md-1 col-xs-1 col-md-offset-2 col-xs-offset-2 ">
                        <a style="font-size: 3em" href="{{url($lastUrl)}}"
                           class="glyphicon glyphicon-chevron-left"
                           aria-hidden="true"></a>
                    </div>
                @endif
                @if(!empty($nextUrl))
                    <div class="col-md-1 col-xs-1 col-md-offset-3 col-xs-offset-3">
                        <a style="font-size: 3em" href="{{url($nextUrl)}}"
                           class="glyphicon glyphicon-chevron-right" id="next_page"
                           aria-hidden="true"></a>
                    </div>
                @endif
                @if($notCollect)
                    <div class="col-md-1 col-xs-1 col-md-offset-2 col-xs-offset-2">
                        <span class="glyphicon glyphicon-plus" id="follow" style="font-size: 3em"></span>
                    </div>
                @endif
            </div>

        </div>
    </nav>


    {{--单词查询--}}
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="trans_word"></h4>
                </div>
                <div class="modal-body">
                    <span id="trans_content"></span><br>
                </div>
                <div class="modal-footer">
                    <a id="trans_url" class="btn btn-default btn-xs" href="">详细</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $('.translateWord').each(function () {
            var strs = $(this).html();
            var vocab = strs.match(/<vocab>.*<\/vocab>/g);

            strs = strs.replace(/\b(\w+)\b/g, "<span class=\"word\">$1</span>");
            strs = strs.replace('<<span class="word">vocab</span>>', '<span style="font-weight:bold;">');
            strs = strs.replace('</<span class="word">vocab</span>>', '</span>');
            console.log(strs)

            $(this).html(strs);
        });
        $('.word').click(function () {
            $.get("{{url('words/word')}}", {word: $(this).text()}, function (rs) {
                if (rs.status != 200) {
                    return;
                }
                $('#trans_word').html(rs.data.word);
                $('#trans_content').html(rs.data.simple_trans);
                $('#trans_url').attr('href', rs.data.url);
                $('#myModal').modal();

            })
        });
        var wait = function (t) {
            var $d = $.Deferred();
            setTimeout(function () {
                $d.resolve();
            }, t);
            return $d.promise();
        };
        $('.delay').hide();
        setTimeout(function () {
            $('.delay').show();
        }, parseFloat("{{$delay or 0}}") * 1000)
        $(function () {
            $('#follow').click(function () {
                $.post('/words/add-collect', {'word_id': "{{$w->id}}"}, function () {
                    $('#follow').hide();
                });

            });
            $('.word-play').click(function () {
                $(this).removeClass('glyphicon-play').addClass('glyphicon-pause');
                $(this).find('audio').attr('src', $(this).attr('data-src'));
                $(this).find('audio')[0].play();
                var that = $(this);
                setTimeout(function () {
                    $(that).addClass('glyphicon-play').removeClass('glyphicon-pause');
                }, 1000)
            });

            var playNum = parseInt("{{$playNum or 0}}");
            var nowPlayNum = 0;
            var recall = setInterval(function () {
                if (nowPlayNum >= playNum) {
                    return clearInterval(recall);
                }
                $('#ph_am_mp3').click();
                nowPlayNum++;
            }, 2000);


        })
    </script>
    @if($isAuto)
        <script>
            $(function () {
                var defer = $.Deferred();
                defer.then(function () {
                    return wait(8000)
                }).then(function () {
                    window.location.href = $('#next_page').attr('href');
                });
                defer.resolve();
            })
        </script>
    @endif
@endsection

