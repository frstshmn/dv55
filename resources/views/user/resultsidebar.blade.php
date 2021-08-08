
    <div class="vh-100 d-flex flex-row justify-content-center align-items-center">
        <div class="row"></div>
        <div class="row ">
            <div class="neuro-card p-5 color-navy text-center align-self-center">
                @if ($result < 70)
                    <div class="font-weight-bold display-2 text-danger">{{$result}}%</div>
                    <p class="font-weight-bold">На жаль, ви не склали екзамен</p>
                    <p class="mb-5">Радимо повторити матеріал лекцій та звернутись до інструктора за повторним тестом</p>
                @else
                    <div class="font-weight-bold display-2 text-success">{{$result}}%</div>
                    <p class="font-weight-bold">Вітаємо, ви успішно склали екзамен</p>
                    <p class="mb-5">Тепер можете переходити до наступної теми</p>
                @endif
            </div>
        </div>
        <div class="row"></div>
    </div>
    <div class="container pb-5 mb-5">
        <div class="row">
            <div class="col-12">
                <table class="mx-auto">
                    <tr>
                        <th class="py-md-3 px-md-5 p-3 text-center">Запитання</th>
                        <th class="py-md-3 px-md-5 p-3 text-center">Відповідь користувача</th>
                        <th class="py-md-3 px-md-5 p-3 text-center">Правильна відповідь</th>
                    </tr>
                        @foreach ($test->questions as $question)
                        <tr @if ($question->userAnswer($user->id) == $question->correctAnswer())
                            class="bg-success text-white"
                            @else
                            class="bg-danger text-white"
                        @endif>
                            <td class="py-md-3 px-md-5 p-3 text-center">{{$question->question}}</td>
                            <td class="py-md-3 px-md-5 p-3 text-center">{{$question->userAnswer($user->id)}}</td>
                            <td class="py-md-3 px-md-5 p-3 text-center">{{$question->correctAnswer()}}</td>
                        </tr>
                        @endforeach
                </table>
            </div>
        </div>
    </div>
