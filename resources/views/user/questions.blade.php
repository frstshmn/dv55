<div class="test-timer-bar">
    <span class="test-timer-label">Залишилось:</span>
    <span class="test-timer-value" id="test_timer">{{ $test->time }}:00</span>
</div>
<form method="POST" action="/answers" id="test_form">
    @csrf
    <input type="hidden" name="test_id" value="{{ $test->id }}">
    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
    <div class="questions-wrapper">
        @php $i = 1; @endphp
        @foreach($test->questions as $question)
        <div class="question-block">
            <div class="question-num">Запитання {{ $i }}</div>
            <div class="question-text">{{ $question->question }}</div>
            <div class="answer-options">
                @foreach([1,2,3,4] as $opt)
                <label class="answer-opt">
                    <input type="radio" name="question_answer_{{ $question->id }}" value="{{ $opt }}" required>
                    <span>{{ $question->{'v_'.$opt} }}</span>
                </label>
                @endforeach
            </div>
        </div>
        @php $i++; @endphp
        @endforeach
        <div class="questions-submit-wrap">
            <p class="questions-hint">Перевірте всі відповіді перед відправкою</p>
            <button type="submit" class="btn-submit-test" id="end_test">Завершити тест</button>
        </div>
    </div>
</form>
