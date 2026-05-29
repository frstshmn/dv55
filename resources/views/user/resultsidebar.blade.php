<div class="test-result-card">
    @if($result < 70)
    <div class="results-score fail">{{ $result }}%</div>
    <p class="results-msg">На жаль, ви не склали тест</p>
    <p class="results-sub">Зверніться до інструктора для повторного тестування</p>
    @else
    <div class="results-score pass">{{ $result }}%</div>
    <p class="results-msg">Тест успішно складено!</p>
    <p class="results-sub">Ви можете переходити до наступного модуля</p>
    @endif
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
