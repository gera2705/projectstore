@extends('layouts.master')


@section('title','Мой кабинет')

@section('content')
    <div class="main col-md-8">
        @include('messages.success')
        @foreach($projects as $project)
            @include ('layouts.project', compact('project'))
        @endforeach
        {{ $projects->appends($_GET)->links() }}
    </div> <!-- main -->
    @include('layouts.sidebar')
@endsection
