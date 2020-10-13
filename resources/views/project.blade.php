@extends('main')

@section('content')
    <my-app
        error="{!! session('error') ?? null  !!}"
        email="{!! session('email') ?? null !!}"
    ></my-app>
@endsection