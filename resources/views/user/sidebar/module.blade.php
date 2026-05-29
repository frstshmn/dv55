@foreach ($module->materials as $material)
<div class="s-material{{ $material->isChecked() ? ' done' : '' }} material" data-id="{{ $material->id }}">
    @if($material->isChecked())
    <svg class="s-mat-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color:var(--success);flex-shrink:0"><path d="M20 6L9 17l-5-5"/></svg>
    @else
    <svg class="s-mat-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="opacity:.4;flex-shrink:0"><circle cx="12" cy="12" r="9"/></svg>
    @endif
    <span class="s-mat-title">{{ $material->title }}</span>
</div>
@endforeach

@if ($module->allMaterialsChecked() && $module->tests->isNotEmpty())
@php $test = $module->tests->first(); @endphp
<div class="s-test{{ $test->isAnswered(Auth::user()->id) ? ($test->isCompleted(Auth::user()->id) ? ' pass' : ' fail') : '' }} test" data-id="{{ $test->id }}">
    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
    <span style="flex:1">Тест модуля</span>
    @if($test->isAnswered(Auth::user()->id))
    <span class="s-test-badge">{{ $test->isCompleted(Auth::user()->id) ? '✓' : '✗' }}</span>
    @endif
</div>
@endif
