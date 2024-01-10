@if (Route::is('admin.*'))
{{-- Toastr Message --}}
    @foreach (session('flash_notification', collect())->toArray() as $message)
        @if ($message['overlay'])
            @include('flash::modal', [
                'modalClass' => 'flash-modal',
                'title'      => $message['title'],
                'body'       => $message['message']
            ])
        @else
            @push('extra-js')
                <script type="text/javascript">
                     $(function(){
                        showMessage("{{$message['level']}}", "{!! $message['message'] !!}");
                    });
                </script>
            @endpush
        @endif
    @endforeach
    {{ session()->forget('flash_notification') }}
@else
    @foreach (session('flash_notification', collect())->toArray() as $message)
        @if ($message['overlay'])
            @include('flash::modal', [
                'modalClass' => 'flash-modal',
                'title'      => $message['title'],
                'body'       => $message['message']
            ])
        @else
            <div class="alert front-flash
                        alert-{{ $message['level'] }}
                        {{ $message['important'] ? 'alert-important' : '' }}"
                        role="alert"
            >
                @if ($message['important'])
                    <button type="button"
                            class="close"
                            data-dismiss="alert"
                            aria-hidden="true"
                    >&times;</button>
                @endif

                <b>{!! $message['message'] !!}</b>
            </div>
        @endif
    @endforeach
    {{ session()->forget('flash_notification') }}
@endif
