<div class="candidate-card">
    @if ($candidate->is_mate == 0)
        <div class="candidate-card__state">Заявка</div>
    @else
        <div class="candidate-card__state candidate-card__state_mate">Назначен</div><span class="candidate-card__triangle triangle"></span>
        <div class="candidate-card__change-window">
            <a class="candidate-card__change-state" href="{{ route('detachMate',['projectId'=>$project->id,'candidateId'=>$candidate->id]) }}">Заявка</a>
        </div>
    @endif
    <div class="candidate-card__name">{{ \AppHelper::truncate($candidate->fio) }}</div>
    <div class="candidate-card__group">Курс: {{ $candidate->course }} Группа: {{ \AppHelper::truncate($candidate->training_group) }}</div>
    <div class="candidate-card__phone"><b>Телефон:</b> {{ substr($candidate->phone,0,31) }}</div>
    <div class="candidate-card__email">{{ \AppHelper::getSubstringFromEnd($candidate->email,90) }}</div>
    <div class="candidate-card__experience"><b>Опыт участия в проектах:</b> {{ \AppHelper::truncate($candidate->experience) }}</div>
    <div class="candidate-card__competencies"><b>Компетенции:</b> {{ \AppHelper::truncate($candidate->competencies) }}</div>
    <div class="candidate-card__skill"><b>Навыки, над чем работали ранее:</b> {{ \AppHelper::truncate($candidate->skill) }} </div>
    @if ($candidate->is_mate == 0)
        <a href="{{ route('assignMate',['projectId'=>$project->id,'candidateId'=>$candidate->id]) }}" class="candidate-card__assign-btn button button_blue">Назначить</a>
    @endif
    @if ($candidate->is_mate == 0 && $candidate->is_watched == 0)
        <a href="{{ route('watch',['projectId'=>$project->id,'candidateId'=>$candidate->id]) }}" class="candidate-card__cross">
            <svg width="30" height="20" viewBox="0 0 30 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M29.8094 8.97694C29.5414 8.61032 23.1556 0 14.9999 0C6.84412 0 0.458087 8.61032 0.190372 8.97659C-0.0634572 9.3244 -0.0634572 9.79614 0.190372 10.144C0.458087 10.5106 6.84412 19.1209 14.9999 19.1209C23.1556 19.1209 29.5414 10.5105 29.8094 10.1442C30.0635 9.79649 30.0635 9.3244 29.8094 8.97694ZM14.9999 17.1429C8.99229 17.1429 3.78909 11.428 2.24883 9.55977C3.7871 7.68987 8.9794 1.97801 14.9999 1.97801C21.0072 1.97801 26.21 7.69186 27.7509 9.56112C26.2126 11.431 21.0203 17.1429 14.9999 17.1429Z" fill="#6B6B6B"/>
                <path d="M15.0005 3.625C11.7285 3.625 9.06641 6.2871 9.06641 9.5591C9.06641 12.8311 11.7285 15.4932 15.0005 15.4932C18.2725 15.4932 20.9346 12.8311 20.9346 9.5591C20.9346 6.2871 18.2725 3.625 15.0005 3.625ZM15.0005 13.5151C12.8191 13.5151 11.0445 11.7405 11.0445 9.5591C11.0445 7.37771 12.8191 5.60307 15.0005 5.60307C17.1819 5.60307 18.9565 7.37771 18.9565 9.5591C18.9565 11.7405 17.182 13.5151 15.0005 13.5151Z" fill="#6B6B6B"/>
            </svg>
        </a>
    @elseif($candidate->is_mate == 0 && $candidate->is_watched == 1)
        <a href="{{ route('unwatch',['projectId'=>$project->id,'candidateId'=>$candidate->id]) }}" class="candidate-card__cross">
            <svg width="30" height="20" viewBox="0 0 30 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M29.8094 8.97694C29.5414 8.61032 23.1556 0 14.9999 0C6.84412 0 0.458087 8.61032 0.190372 8.97659C-0.0634572 9.3244 -0.0634572 9.79614 0.190372 10.144C0.458087 10.5106 6.84412 19.1209 14.9999 19.1209C23.1556 19.1209 29.5414 10.5105 29.8094 10.1442C30.0635 9.79649 30.0635 9.3244 29.8094 8.97694ZM14.9999 17.1429C8.99229 17.1429 3.78909 11.428 2.24883 9.55977C3.7871 7.68987 8.9794 1.97801 14.9999 1.97801C21.0072 1.97801 26.21 7.69186 27.7509 9.56112C26.2126 11.431 21.0203 17.1429 14.9999 17.1429Z" fill="#3D3D3D"/>
                <path d="M15 4.55859C12.2431 4.55859 10 6.80164 10 9.55859C10 12.3155 12.2431 14.5586 15 14.5586C17.7569 14.5586 20 12.3155 20 9.55859C20 6.80164 17.7569 4.55859 15 4.55859Z" fill="#3D3D3D"/>
            </svg>
        </a>
    @endif


</div>
