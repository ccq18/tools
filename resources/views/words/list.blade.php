@extends('layouts.app')

@section('content')

    <div class="container">

        @foreach($words as $word)
            <div class="row">
               <a href="{{build_url('/words/index',['word_id'=>$word->id])}}">{{$word->translate['word_name']}}
                [{{$word->getPham()}}]</a>
                <div style="width: 25px;height: 25px;overflow:hidden;display: inline-block;">
                    <audio src="{{$word->getAudio()}}" controls id="ph_am_mp3"></audio>
                </div>
                {{$word->getFirstTranslate()}}
            </div>
        @endforeach


    </div>
    <nav class="navbar navbar-default navbar-fixed-bottom">
        <div class="container">
            <div class="row center-block">
                {{$words->links()}}
            </div>
        </div>
    </nav>





@endsection
