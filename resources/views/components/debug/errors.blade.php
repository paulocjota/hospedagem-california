@if(config('app.debug'))
    @if($errors->any())
        @dump($errors)
    @endif
@endif