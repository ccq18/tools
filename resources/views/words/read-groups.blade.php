@extends('layouts.app')

@section('content')

    <div class="container" style="margin-left: 0.2rem">

        @foreach($groups as $units=>$groupArr)
            <div class="row" style="background-color: #ffffff;margin-top: 1rem;">
                @foreach($groupArr as $k=>$group)
                    <a href="{{url("/words/read-list/{$listId}/{$group['group_id']}")}}">
                        <div class="col-md-5 col-xs-5 text-center" style="background-color: #f5f8fa;margin: 0.5rem;padding-top: 1rem;padding-bottom: 1rem">
                           group-{{$group['group_id']}}
                        </div>
                    </a>
                @endforeach
            </div>
        @endforeach

    </div>



@endsection

@section('js')
    <script>

    </script>
@endsection