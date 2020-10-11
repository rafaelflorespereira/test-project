@extends('main')

@section('content')
    <table-contents
        subjects="{{json_encode($subjects)}}"
        messages="{{json_encode($messages)}}"
    ></table-contents>
@endsection