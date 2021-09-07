@if(session()->has('error'))
    <div class="success error-block closeable">
        <div class="cross"></div>
        <span>{{ session()->get('error') }}</span>
    </div>
@endif
