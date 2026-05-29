<div class="material-body">
    {!! $material->code !!}
</div>

@if($test !== null || !empty($next_material))
<div class="material-nav">
    @if(!empty($next_material))
    <button class="btn-material-next btn-next-material"
        data-next="{{ $next_material->id }}"
        data-current="{{ $material->id }}"
        data-module="{{ $material->module->id }}">
        {{ $next_material->title }}
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
    </button>
    @elseif($test !== null)
    <button class="btn-material-next btn-next-test"
        data-next="{{ $test->id }}"
        data-current="{{ $material->id }}"
        data-module="{{ $material->module->id }}">
        Перейти до тесту
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
    </button>
    @endif
</div>
@else
<p class="material-end-note">Кінець модуля</p>
@endif
