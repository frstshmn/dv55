@extends('layouts.student_new')
@section('title', 'Мої курси')

@section('content')
<div class="cabinet-page">
    <div class="cabinet-heading">
        <h1>Мої курси</h1>
        <p>Вітаємо, {{ Auth::user()->name }}! Оберіть курс для навчання.</p>
    </div>

    @if($courses->isEmpty())
    <div class="empty-cabinet">
        <div class="empty-cabinet-icon">🎓</div>
        <div>Вас ще не записано на жодний курс. Зверніться до адміністратора.</div>
    </div>
    @else
    <div class="course-grid-student">
        @foreach($courses as $userCourse)
        @php $course = $userCourse->course; $score = $course->totalScore(Auth::user()->id); @endphp
        <div class="course-card-student" onclick="window.location='/courses/{{ $course->id }}'">
            <div class="ccs-header">
                <div class="ccs-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.8)" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z"/></svg>
                </div>
                <div class="ccs-title">{{ $course->title }}</div>
                <div class="ccs-desc">{{ Str::limit($course->description, 80) }}</div>
            </div>
            <div class="ccs-body">
                <div class="ccs-stats">
                    <div class="ccs-stat">
                        <div class="ccs-stat-val">{{ count($course->modules) }}</div>
                        <div class="ccs-stat-lbl">Модулів</div>
                    </div>
                    <div class="ccs-stat">
                        <div class="ccs-stat-val">{{ $course->modules->sum(fn($m) => count($m->materials)) }}</div>
                        <div class="ccs-stat-lbl">Матеріалів</div>
                    </div>
                </div>
                <div class="ccs-progress-wrap">
                    <div class="ccs-progress-bar"><div class="ccs-progress-fill" style="width:{{ $score }}%"></div></div>
                    <span class="ccs-progress-label">{{ $score }}%</span>
                </div>
            </div>
            <div class="ccs-footer">
                <span style="font-size:0.78rem;color:var(--text-muted)">{{ $score >= 100 ? 'Завершено ✓' : ($score > 0 ? 'Продовжити' : 'Почати') }}</span>
                <button class="ccs-enter-btn">
                    Перейти
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
