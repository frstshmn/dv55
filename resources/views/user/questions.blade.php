<div class="row background-light-grey w-100 m-0 justify-content-center text-center flex-column">
    <nav class="navbar fixed-top">
        <h5 class="ml-auto neuro-card py-2 px-3 mt-3 mr-3" id="test_timer">{{$test->time}}</h5>
    </nav>
    <form method="POST" action="/answers" id="test">
        @csrf
        <input value="{{$test->id}}" name="test_id" hidden required>
        <input value="{{Auth::user()->id}}" name="user_id" hidden required>
        @php $i = 1; @endphp
        @foreach ($test->questions as $question)
            <div class="offset-2 col-8 my-5">
                <div class="neuro-card p-5">
                    <h5 class="text-center mb-4">{{$i}} {{$question->question}}</h5>
                    <div class="d-flex flex-column justify-content-center neuro-radio-group">
                        <input type="radio" id="answer_1_{{$question->id}}" value="1" name="question_answer_{{$question->id}}" >
                        <label class="my-3" for="answer_1_{{$question->id}}">a) {{$question->v_1}}</label>

                        <input type="radio" id="answer_2_{{$question->id}}" value="2" name="question_answer_{{$question->id}}" >
                        <label class="my-3" for="answer_2_{{$question->id}}">b) {{$question->v_2}}</label>

                        <input type="radio" id="answer_3_{{$question->id}}" value="3" name="question_answer_{{$question->id}}" >
                        <label class="my-3" for="answer_3_{{$question->id}}">c) {{$question->v_3}}</label>

                        <input type="radio" id="answer_4_{{$question->id}}" value="4" name="question_answer_{{$question->id}}" >
                        <label class="my-3" for="answer_4_{{$question->id}}">d) {{$question->v_4}}</label>

                    </div>
                </div>
            </div>
            @php $i++; @endphp
        @endforeach
        <p class="font-italic small color-grey">Перевірте всі відповіді перед тим, як натискати наступну кнопку</p>
        <button class="shadow button background-red font-weight-bold mb-5" id="end_test">Завершити тест</button>
    </form>
</div>
