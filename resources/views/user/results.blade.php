@extends('layouts.student_new')
@section('title', 'Результати тесту')

@section('header-center')
<a href="/courses/{{ $test->module->course->id }}">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5"/><path d="M12 19l-7-7 7-7"/></svg>
    {{ $test->module->course->title }}
</a>
<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18l6-6-6-6"/></svg>
<span>Результати тесту</span>
@endsection

@section('content')
<div class="results-hero">
    @if($result < 70)
    <div class="results-score fail">{{ $result }}%</div>
    <p class="results-msg">На жаль, ви не склали тест</p>
    <p class="results-sub">Рекомендуємо повторити матеріали та звернутись до інструктора для повторного тестування</p>
    @else
    <div class="results-score pass">{{ $result }}%</div>
    <p class="results-msg">Вітаємо! Тест успішно складено</p>
    <p class="results-sub">Можете переходити до наступного модуля</p>
    @endif
    <a href="/courses/{{ $test->module->course->id }}" class="btn-back-course">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5"/><path d="M12 19l-7-7 7-7"/></svg>
        Повернутись до курсу
    </a>
</div>
<div class="results-detail">
    <table class="results-table">
        <thead>
            <tr>
                <th>Запитання</th>
                <th>Ваша відповідь</th>
                <th>Правильна відповідь</th>
            </tr>
        </thead>
        <tbody>
            @foreach($test->questions as $question)
            @php $correct = ($question->userAnswer($user->id) == $question->correctAnswer()); @endphp
            <tr class="{{ $correct ? 'row-pass' : 'row-fail' }}">
                <td>{{ $question->question }}</td>
                <td class="{{ $correct ? 'result-correct' : 'result-wrong' }}">{{ $question->userAnswer($user->id) }}</td>
                <td class="result-correct">{{ $question->correctAnswer() }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
