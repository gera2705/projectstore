@extends('layouts.admacc-master')

@section('title','Управление руководителями')

@section('content')
    <div style="padding-left:20px">
        @include('messages.success')
        <form method="POST" action="{{ route('admacc_registerSupervisor') }}" class="supervisor-registration">
            @csrf
            <div class="supervisor-registration__row">
                <label for="" class="supervisor-registration__label">ФИО</label>
                <div>
                    @error('s_fio')
                        <div class="error">{{ $message }}</div>
                    @enderror
                    <input name="s_fio" type="text" class="supervisor-registration__input not_required" value="{{ old('s_fio') }}">
                </div>
            </div>
            <div class="supervisor-registration__row">
                <label for="" class="supervisor-registration__label">Логин</label>
                <div>
                    @error('login')
                        <div class="error">{{ $message }}</div>
                    @enderror
                    <input name="login" type="text" class="supervisor-registration__input not_required" value="{{ old('login') }}">
                </div>
            </div>
            <div class="supervisor-registration__row">
                <label for="" class="supervisor-registration__label">Пароль</label>
                <div>
                    @error('s_password')
                        <div class="error">{{ $message }}</div>
                    @enderror
                    <input name="s_password" type="text" class="supervisor-registration__input not_required" value="{{ old('s_password') }}">
                </div>
            </div>
            <div class="supervisor-registration__row">
                <label for="" class="supervisor-registration__label">Почта</label>
                <div>
                    @error('s_email')
                        <div class="error">{{ $message }}</div>
                    @enderror
                    <input name="s_email" type="email" class="supervisor-registration__input not_required" value="{{ old('s_email') }}">
                </div>
            </div>
            <div class="supervisor-registration__row">
                <label for="" class="supervisor-registration__label">Должность</label>
                <div>
                    @error('position')
                        <div class="error">{{ $message }}</div>
                    @enderror
                    <input name="position" type="text" class="supervisor-registration__input not_required" value="{{ old('position') }}">
                </div>
            </div>
            <div class="supervisor-registration__row">
                <div></div>
                <div style="text-align:center;">
                    <button class="button button_flat button_blue" type="submit">Зарегистрировать</button>
                </div>
            </div>
        </form>
        <table style="width:500px;margin-top:30px;" class="admacc-table supervisors-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th><span style="margin-left: -25px;">ФИО</span></th>
                    <th>Почта</th>
                </tr>
            </thead>
            <tbody>
                @foreach($supervisors as $supervisor)
                    <tr>
                        <td>{{ $supervisor->id }}</td>
                        <td>{{ preg_replace('~^(\S++)\s++(\S)\S++\s++(\S)\S++$~u', '$1 $2.$3.', $supervisor->fio) }}</td>
                        <td>{{ $supervisor->email }}</td>
                        <td style="padding-left: 9px;padding-right: 3px;" class="supervisors-table__manage-link"><a href="{{ route('admacc_supervisor_edit',['supervisorId'=>$supervisor->id]) }}"><img src="/images/editIcon.svg" alt=""></a></td>
                        <td style="padding: 0;" class="supervisors-table__manage-link"><a href="{{ route('admacc_supervisor_delete',['supervisorId'=>$supervisor->id]) }}"><img src="/images/deleteIcon.svg" alt=""></a></td>
                    </tr>
                @endforeach
                {{ $supervisors->appends($_GET)->links() }}
            </tbody>

        </table>
    </div>
@endsection
