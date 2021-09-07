<div class="additional-block">
    <div class="container">
        <div class="row">
            <a class="why-link" href="{{ route('why-answer') }}">Зачем участвовать в проектах?</a>
            <form class="search-form" action="" method="GET">
                <input class="search-form__field" name="search" type="text" placeholder="Поиск по названию проекта" @if(request()->has('search')) value="{{ request()->get('search') }}" @endif>
                <button class="search-form__submit" type="submit"><svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path class="search-form__path" d="M2 24C2 24 7.76914 18.2005 11.4657 14.4844M11.4657 14.4844C14.5165 17.3815 19.5017 17.0867 22.1936 13.85C24.5647 10.9991 24.6393 7.12089 22.1936 4.33444C19.4217 1.17646 14.3371 1.26759 11.4657 4.33444C8.76332 7.22088 8.76332 11.598 11.4657 14.4844Z" stroke="#848DDF" stroke-opacity="0.47" stroke-width="3"/>
                    </svg>
                </button>
            </form>
            @if (Auth::user() && Auth::user()->role === 'supervisor')
                    <a href="{{ route('createProject') }}" class="addProject addProject_main">Добавить проект</a>
            @endif
        </div>
    </div>
</div> <!-- additional-block -->
