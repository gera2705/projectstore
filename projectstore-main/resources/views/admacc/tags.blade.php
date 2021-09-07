@extends('layouts.admacc-master')

@section('title','Справочник тегов')

@section('content')
    <div style="padding-left:20px;">
        @include('messages.success')
        @include('messages.error')
        <form style="margin-bottom:23px;" method="POST" action="{{ route('admacc_tag_add') }}">
            @csrf
            @error('tag_add')
                <div class="error">{{ $message }}</div>
            @enderror
            <input class="not_required" placeholder="Название тега" name="tag_add" type="text" required>
            <button style="margin-left:20px;" class="button button_blue button_flat" type="submit">Добавить тег</button>
        </form>
        <table class="tags-table">
            <thead>
            <tr>
                <th style="text-align:left"><span style="">Тег</span></th>
            </tr>
            </thead>
            <tbody>
            @foreach($tags as $tag)
                <tr>
                    <td style="">{{ $tag->tag }}</td>
                    <td class="tags-table__cross"><a href="{{ route('admacc_tag_delete',['tagId'=>$tag->id]) }}"><img src="/images/deleteIcon.svg" alt=""></a></td>
                </tr>
            @endforeach
            {{ $tags->appends($_GET)->links() }}
            </tbody>
        </table>
    </div>
@endsection
