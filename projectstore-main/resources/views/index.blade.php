@extends('layouts.master')

@section('title','Ярмарка проектов')

@section('additional-block')
    @include('layouts.additional-block')
@endsection

@section('banner')
    @include('layouts.banner')
@endsection

@section('content')
    <div class="main col-md-8">
        @include('messages.success')
        @include('messages.error')
        @foreach($projects as $project)
            @include ('layouts.project', compact('project'))
        @endforeach
        {{ $projects->appends($_GET)->links() }}
    </div> <!-- main -->
    @include('layouts.sidebar')
@endsection
