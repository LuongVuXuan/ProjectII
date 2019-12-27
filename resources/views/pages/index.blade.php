@extends('layouts.app')

@section('content')
    <div class="jumbotron text-center">
        <h1>{{ $title }}</h1>
        <p>This is the laravel application which can have you to find your student in HUST</p>
        <a href="/students" class="btn btn-primary" role="button">Search Now</a>
    </div>
@endsection
