<div class="sidebar col-md-4">
    @if(Route::is('personalcab'))
        <div style="width:73%;height:55px;margin-bottom:14px;border:1px solid #148F00;border-radius:5px;">
            <a href="{{ route('createProject') }}" class="addProject">Добавить проект</a>
        </div>
    @endif
    <form class="side-form" action="" method="GET">
        <div class="fieldset fieldset_projects">
            <p>Проекты</p>
            @if(Route::is('personalcab'))
                <label>Обработка
                    <input class="checkbox" name='Обработка' type='checkbox' @if(request()->has('Обработка')) checked @endif>
                    <span class="checkmark"></span>
                </label>
            @endif
            <label>Открытые
                <input class="checkbox" name='Открытый' type='checkbox' @if(request()->has('Открытый')) checked @endif>
                <span class="checkmark"></span>
            </label>
            <label>Активные
                <input name='Активный' type='checkbox' @if(request()->has('Активный')) checked @endif>
                <span class="checkmark"></span>
            </label>
            <label>Закрытые
                <input name='Закрытый' type='checkbox' @if(request()->has('Закрытый')) checked @endif>
                <span class="checkmark"></span>
            </label>
        </div>
        <div class="fieldset fieldset_select">
            <p>Тип проекта
                <span class="triangle triangle_line"></span>
                <span class="fieldset__line"></span>
            </p>
            @foreach($types as $type)
                <label>{{ $type->type }}
                    <input name='{{ $type->type }}' type='checkbox' @if(request()->has($type->type)) checked @endif>
                    <span class="checkmark"></span>
                </label>
            @endforeach
        </div>
        @unless(Route::is('personalcab'))
            <div class="fieldset fieldset_select">
                <p>Руководитель
                    <span class="triangle triangle_line"></span>
                    <span class="fieldset__line"></span>
                </p>
                @foreach($supervisors as $supervisor)
                    <label>{{ preg_replace('~^(\S++)\s++(\S)\S++\s++(\S)\S++$~u', '$1 $2.$3.', $supervisor->fio) }}
                        <input name='{{ $supervisor->fio }}' type='checkbox' @if(request()->has(str_replace(' ','_',$supervisor->fio))) checked @endif>
                        <span class="checkmark"></span>
                    </label>
                @endforeach
            </div>
        @endunless
        <div class="fieldset fieldset_select">
            <p>Теги проекта
                <span class="triangle triangle_line"></span>
                <span class="fieldset__line"></span>
            </p>
            @foreach($tags as $tag)
                <label>{{ $tag->tag }}
                    <input name='{{ $tag->tag }}' type='checkbox' @if(request()->has($tag->tag)) checked @endif>
                    <span class="checkmark"></span>
                </label>
            @endforeach
        </div>
        <p>Сроки реализации</p>
        <p>от</p>
        <input class="not_required" name='date_start' type='date' @if(request()->has('date_start')) value="{{ request()->get('date_start') }}" @endif>
        <p>до</p>
        <input class="not_required" name='date_end' type='date' @if(request()->has('date_end')) value="{{ request()->get('date_end') }}" @endif>
        <button class="side-form__button button button_black button_hover_gray" type='submit'>Применить</button>
        <a href="{{ route('index') }}" class="side-form__button button button_black button_hover_lightgray">Сбросить</a>
    </form>
</div> <!-- sidebar -->
