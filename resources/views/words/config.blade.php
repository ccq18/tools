@extends('layouts.app')
@section('title')
单词设置
@endsection
@section('content')

    <div class="container" style="margin-left: 10px">
        <div class="row">
            <div class="switch switch-large">
                <input type="checkbox" checked />
            </div>
        </div>



    </div>

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

@endsection

