@extends('main')

@section('content')
    <table-contents
        contacts="{{json_encode($contacts)}}"
        emails="{{ json_encode($emails) }}"
    ></table-contents>
@endsection