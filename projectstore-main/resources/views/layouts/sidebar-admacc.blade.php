<div class="col-md-2 sidebar-admin">
    <ul class="nav-admin sidebar-admin__nav-admin">
        <li class="nav-admin__item">
            <a href="{{ route('admacc_projects') }}" class="nav-admin__link @if(Route::is('admacc_projects')) nav-admin__link_active @endif">Проекты</a>
        </li>
        <li class="nav-admin__item">
            <a href="{{ route('admacc_supervisors') }}" class="nav-admin__link @if(Route::is('admacc_supervisors')) nav-admin__link_active @endif">Руководители</a>
        </li>
        <li class="nav-admin__item">
            <a href="{{ route('admacc_expertise') }}" class="nav-admin__link @if(Route::is('admacc_expertise')) nav-admin__link_active @endif">Экспертиза заявок</a>
        </li>
        <li class="nav-admin__item">
            <a href="{{ route('admacc_tags') }}" class="nav-admin__link @if(Route::is('admacc_tags')) nav-admin__link_active @endif">Справочник тегов</a>
        </li>
    </ul> <!-- nav-admin -->
</div> <!-- sidebar-admin -->
