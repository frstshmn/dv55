<div class="row vh-100 p-5">
    <div class="neuro-card text-center p-5">
        <h1 class="display-4">Екзаменаційний тест з модулю "{{$test->module->title}}" </h1>
        <p class="lead">Час на проходження: {{$test->time}} хвилин. 4 варіанти відповідей, серед яких <span class="font-weight-bold color-red">ТІЛЬКИ 1</span> правильний</p>
        <hr class="my-2">
        <p class="font-italic small">Доступ до матеріалів теми буде тимчасово заблокований.</p>
        <p class="color-red font-italic font-weight-bold text-center small">Якщо ви стикнулись з проблемою або маєте технічні неполадки - зверніться до вашого інструктора.</p>
        <p class="lead text-center mt-5">
            <button class="shadow button background-red font-weight-bold" id="start_test" data-id="{{$test->id}}">Почати тест</button>
        </p>
    </div>
</div>

