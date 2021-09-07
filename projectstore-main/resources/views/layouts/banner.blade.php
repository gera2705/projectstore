@if (Auth::user())
    @if(Auth::user()->role == 'admin' && Cookie::has('offDesign'))
    @else
        <div class="banner">
            <div class="container">
                <div class="row">
                    <h3 class="subtitle col-md-5">Найди проект своей мечты</h3>
                    <img class="illustration col-md-5" src="/images/illustration.png">
                </div>
            </div>
        </div>
    @endif
@else
    <div class="banner">
        <div class="container">
            <div class="row">
                <h3 class="subtitle col-md-5">Найди проект своей мечты</h3>
                <img class="illustration col-md-5" src="/images/illustration.png">
            </div>
        </div>
    </div>
@endif
