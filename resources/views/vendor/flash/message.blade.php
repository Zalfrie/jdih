@if (Session::has('flash_notification.message'))
    @if (Session::has('flash_notification.overlay'))
        @include('flash::modal', ['modalClass' => 'flash-modal', 'title' => Session::get('flash_notification.title'), 'body' => Session::get('flash_notification.message')])
    @else
        <div id="flashMessage" style="display: none;" data-type="{{ Session::get('flash_notification.level') }}">{!! Session::get('flash_notification.message') !!}</div>
    @endif
@endif
