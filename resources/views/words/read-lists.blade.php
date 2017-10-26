@extends('layouts.app')

@section('content')

    <div class="container" style="margin-left: 10px">

        <div class="row">
            @foreach($listIds as $listId)

                <a href="{{url("/words/read-list/{$listId}")}}">
                    <div class="col-md-3 col-xs-3 text-center" style="background-color: #FFFFFF;margin: 1rem;padding-top: 1rem;padding-bottom: 1rem">
                       list-{{$listId}}
                    </div>
                </a>
            @endforeach
        </div>

    </div>



@endsection

@section('js')
    <script>
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
        })
    </script>
@endsection