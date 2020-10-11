@extends('main')

@section('content')
    <my-app
        error="{!! session('error') ?? null  !!}"
    ></my-app>
@endsection