
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
