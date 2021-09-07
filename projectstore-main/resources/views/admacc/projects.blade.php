@extends('layouts.admacc-master')

@section('title','Проекты')

@section('content')
    <div style="padding-left:20px;">
        @include('messages.success')
        @include('messages.error')
    </div>
    <table class="projects-table">
        <thead>
        <tr>
            <th><span style="margin-left: -25px;">Название</span></th>
            <th>Руководитель</th>
            <th>Состояние</th>
        </tr>
        </thead>
        <tbody>
        @foreach($projects as $project)
            <tr>
                <td style="width:53%;max-width:53%;">{{ $project->title }}</td>
                <td style="width:22%;max-width:22%;">{{ preg_replace('~^(\S++)\s++(\S)\S++\s++(\S)\S++$~u', '$1 $2.$3.', $project->user->fio) }}</td>
                <td style="width:14%;max-width:14%;">{{ $project->state_name }}</td>
                <td class="projects-table__show"><a href="{{ route('admacc_project_show',['projectId'=>$project->id]) }}"><img src="/images/magnifying_glass.svg" alt=""></a></td>
                <td class="projects-table__cross"><a href="{{ route('admacc_project_delete',['projectId'=>$project->id]) }}"><img src="/images/deleteIcon.svg" alt=""></a></td>
            </tr>
        @endforeach
        {{ $projects->appends($_GET)->links() }}
        </tbody>
    </table>
@endsection
