@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-2">
                可用余额：{{$account->amount}}
            </div>
            <div class="col-md-4 col-md-offset-2">
                冻结金额：{{$frozenAccount->amount}}
            </div>
            <div class="col-md-8 col-md-offset-2">
                <form action="/account/transfer" method="post">
                    <input type="text" value="{{ old('to_account') }}" name="to_account" class="form-control" placeholder="对方账户"
                           id="to_account">
                    <input type="text" value="{{ old('amount') }}" name="amount" class="form-control" placeholder="转帐金额"
                           id="amount">

                    <button class="btn btn-success pull-right" type="submit">转账</button>
                    {{ csrf_field() }}
                </form>
            </div>
            <div class="col-md-8 col-md-offset-2">
                <form action="/account/recharge" method="post">
                    <input type="text" value="{{ old('to_account') }}" name="to_account" class="form-control" placeholder="充值账户"
                           id="to_account">
                    <input type="text" value="{{ old('amount') }}" name="amount" class="form-control" placeholder="充值金额"
                           id="amount">
                    <button class="btn btn-success pull-right" type="submit">充值</button>
                    {{ csrf_field() }}
                </form>
            </div>
            <div class="col-md-8 col-md-offset-2">
                @foreach($transfers as $transfer)
                    <div class="media">

                        <div class="media-body">
                            <h4 class="media-heading">
                                {{ $transfer->title }}
                                {{ $transfer->amount }}¥
                                {{ $transfer->created_at->format('Y.m.d H:i')}}
                            </h4>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
