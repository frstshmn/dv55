@if (Auth::user()->is_admin == 1)
    @php
        header("Location: " . URL::to('/admin'), true, 302);
        exit();
    @endphp
@else
    @php
        header("Location: " . URL::to('/cabinet'), true, 302);
        exit();
    @endphp
@endif
