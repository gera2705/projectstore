@if(session()->has('success'))
    <div class="success closeable">
        <div class="cross"></div>
        <span>{{ session()->get('success') }}</span>
    </div>
@endif
