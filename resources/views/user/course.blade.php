@extends('layouts.student_new')
@section('title', $course->title)

@section('header-center')
<a href="/cabinet">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5"/><path d="M12 19l-7-7 7-7"/></svg>
    Мої курси
</a>
<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
<span style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $course->title }}</span>
@endsection

@section('content')
<div class="course-layout">
    {{-- Sidebar --}}
    <aside class="course-sidebar" id="courseSidebar">
        <div class="cs-top">
            <a href="/cabinet" class="cs-back">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5"/><path d="M12 19l-7-7 7-7"/></svg>
                Мої курси
            </a>
            <div class="cs-course-title">{{ $course->title }}</div>
            <div class="cs-progress-row">
                <div class="cs-progress-bar">
                    <div class="cs-progress-fill" id="cs-progress-fill" style="width:{{ $course->totalScore(Auth::user()->id) }}%"></div>
                </div>
                <span class="cs-progress-label" id="cs-progress-label">{{ $course->totalScore(Auth::user()->id) }}%</span>
            </div>
        </div>

        <div class="cs-modules">
            @foreach($course->modules as $module)
            <div class="s-module">
                <div class="s-module-header" id="mh_{{ $module->id }}" onclick="toggleModule({{ $module->id }})">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;opacity:.6"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
                    <span style="flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ $module->title }}</span>
                    <svg class="s-chevron" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
                </div>
                <div class="s-module-items" id="mi_{{ $module->id }}">
                    @foreach($module->materials as $material)
                    <div class="s-material{{ $material->isChecked() ? ' done' : '' }} material" data-id="{{ $material->id }}">
                        @if($material->isChecked())
                        <svg class="s-mat-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="color:var(--success);flex-shrink:0"><path d="M20 6L9 17l-5-5"/></svg>
                        @else
                        <svg class="s-mat-icon" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="opacity:.4;flex-shrink:0"><circle cx="12" cy="12" r="9"/></svg>
                        @endif
                        <span class="s-mat-title">{{ $material->title }}</span>
                    </div>
                    @endforeach

                    @if($module->allMaterialsChecked() && $module->tests->isNotEmpty())
                    @php $test = $module->tests->first(); @endphp
                    <div class="s-test{{ $test->isAnswered(Auth::user()->id) ? ($test->isCompleted(Auth::user()->id) ? ' pass' : ' fail') : '' }} test" data-id="{{ $test->id }}">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
                        <span style="flex:1">Тест модуля</span>
                        @if($test->isAnswered(Auth::user()->id))
                        <span class="s-test-badge">{{ $test->isCompleted(Auth::user()->id) ? '✓' : '✗' }}</span>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </aside>

    {{-- Content area --}}
    <main class="course-content-main" id="courseContentMain">
        <div id="content-empty" class="content-empty-state">
            <div class="content-empty-icon">👈</div>
            <div class="content-empty-text">Оберіть матеріал для перегляду</div>
        </div>
        <div id="content-loader" class="content-loader" style="display:none">
            <div class="content-spinner"></div>
        </div>
        <div id="content-area" style="display:none"></div>
    </main>

    {{-- Mobile toggle --}}
    <button class="cs-mobile-toggle" id="sidebarToggle" onclick="document.getElementById('courseSidebar').classList.toggle('mobile-open')">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
    </button>
</div>
@endsection

@section('scripts')
<script>
const COURSE_ID = {{ $course->id }};
const USER_ID = {{ Auth::user()->id }};
let timerInterval = null;

// ===== Module accordion =====
function toggleModule(id) {
    const header = document.getElementById('mh_' + id);
    const items = document.getElementById('mi_' + id);
    header.classList.toggle('open');
    items.classList.toggle('open');
}

// Open first module by default
document.addEventListener('DOMContentLoaded', function() {
    const firstHeader = document.querySelector('.s-module-header');
    const firstItems = document.querySelector('.s-module-items');
    if(firstHeader) firstHeader.classList.add('open');
    if(firstItems) firstItems.classList.add('open');
});

// ===== Content area helpers =====
function showLoader() {
    document.getElementById('content-empty').style.display = 'none';
    document.getElementById('content-area').style.display = 'none';
    document.getElementById('content-loader').style.display = 'flex';
    document.getElementById('courseContentMain').scrollTop = 0;
}
function showContent(html) {
    document.getElementById('content-loader').style.display = 'none';
    document.getElementById('content-empty').style.display = 'none';
    const area = document.getElementById('content-area');
    area.innerHTML = html;
    area.style.display = 'block';
    document.getElementById('courseContentMain').scrollTop = 0;
    // Close mobile sidebar
    document.getElementById('courseSidebar').classList.remove('mobile-open');
}

// ===== Material click =====
$(document).on('click', '.s-material', function() {
    document.querySelectorAll('.s-material, .s-test').forEach(el => el.classList.remove('active'));
    this.classList.add('active');
    showLoader();
    $.get('/materials/' + $(this).data('id'), showContent);
});

// ===== Test click =====
$(document).on('click', '.s-test', function() {
    document.querySelectorAll('.s-material, .s-test').forEach(el => el.classList.remove('active'));
    this.classList.add('active');
    showLoader();
    $.get('/tests/' + $(this).data('id'), showContent);
});

// ===== Next material button =====
$(document).on('click', '.btn-next-material', function() {
    const nextId = $(this).data('next');
    const currentId = $(this).data('current');
    const moduleId = $(this).data('module');
    showLoader();
    $.post('/usercomplection', { user_id: USER_ID, material_id: currentId }, function() {
        refreshSidebarModule(moduleId);
        refreshProgress();
        $.get('/materials/' + nextId, function(data) {
            showContent(data);
            document.querySelectorAll('.s-material, .s-test').forEach(el => el.classList.remove('active'));
            const el = document.querySelector('.s-material[data-id="' + nextId + '"]');
            if(el) el.classList.add('active');
        });
    });
});

// ===== Next test button =====
$(document).on('click', '.btn-next-test', function() {
    const testId = $(this).data('next');
    const currentId = $(this).data('current');
    const moduleId = $(this).data('module');
    showLoader();
    $.post('/usercomplection', { user_id: USER_ID, material_id: currentId }, function() {
        refreshSidebarModule(moduleId);
        refreshProgress();
        $.get('/tests/' + testId, showContent);
    });
});

// ===== Start test button =====
$(document).on('click', '#start_test', function() {
    const testId = $(this).data('id');
    const timeMin = parseInt($(this).data('time'));
    $.get('/tests/questions/' + testId, function(data) {
        showContent(data);
        startTimer(timeMin);
    });
});

// ===== Timer =====
function startTimer(minutes) {
    clearInterval(timerInterval);
    let total = minutes * 60;
    const el = document.getElementById('test_timer');
    if(!el) return;
    function tick() {
        if(total <= 0) {
            clearInterval(timerInterval);
            const f = document.getElementById('test_form');
            if(f) f.submit();
            return;
        }
        const m = Math.floor(total / 60);
        const s = total % 60;
        el.textContent = m + ':' + (s < 10 ? '0' : '') + s;
        total--;
    }
    tick();
    timerInterval = setInterval(tick, 1000);
}

// ===== Sidebar refresh =====
function refreshSidebarModule(moduleId) {
    $.post('/courses/sidebar/module', { id: moduleId }, function(html) {
        document.getElementById('mi_' + moduleId).innerHTML = html;
    });
}

function refreshProgress() {
    $.post('/courses/sidebar/total', { id: COURSE_ID }, function(html) {
        const tmp = document.createElement('div');
        tmp.innerHTML = html;
        const scoreEl = tmp.querySelector('[data-score]');
        if(scoreEl) {
            const score = scoreEl.getAttribute('data-score');
            document.getElementById('cs-progress-fill').style.width = score + '%';
            document.getElementById('cs-progress-label').textContent = score + '%';
        }
    });
}
</script>
@endsection
