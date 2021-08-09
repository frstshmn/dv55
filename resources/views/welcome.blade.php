@extends('layouts.layout')

@section('title', 'Головна')

@section('content')

    {{-- <div class="background-grey vh-100 d-flex align-items-center" id="hero">
        <div class="row"></div>
        <div class="row justify-content-center m-auto w-100">
            <div class="col-md-12">
                <div class="p-5 color-navy">

                    <p class="mt-4 text-center font-weight-bold">Sorry, we are reviewing our database. Page is under reconstruction. Thank you for your understanding.</p>
                </div>
                <div class="row w-100">
                    @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="color-grey">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="color-grey">Log in</a>
                            @endauth
                    @endif
                </div>
            </div>
        </div>
        <div class="row"></div>
    </div> --}}

    <nav class="navbar navbar-expand-lg w-100 fixed-top py-3 px-5 font-montserrat navbar-dark">
        <img src="{{ URL::asset('public/images/logo_small.svg') }}" width="100em">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item mx-2">
                    <a class="nav-link" href="#hero">Головна</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link" href="#about">Про нас</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link" href="#courses">Курси</a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link" href="#contacts">Контакти</a>
                </li>
            </ul>
            <ul class="navbar-nav">

                @if (Route::has('login'))
                    @auth
                        <li class="nav-item ml-md-auto mx-auto">
                            <a href="{{ url('/dashboard') }}" class="nav-link button py-1 px-3 text-white ml-auto">Кабінет</a>
                        </li>
                    @else
                        <li class="nav-item ml-md-auto mx-auto">
                            <a href="{{ route('login') }}" class="nav-link button py-1 px-3 text-white ml-auto">Увійти</a>
                        </li>
                    @endauth
                @endif
            </ul>
        </div>
    </nav>

    <div class="background-grey vh-100 d-md-flex d-none align-items-center font-montserrat overflow-hidden" id="hero">
        <div class="p-5 position-absolute level-1 vh-100 vw-100 d-flex align-items-center">
            <div class="d-flex justify-content-center flex-row w-100">
                <div class="text-white mr-5">
                    <h1 class="h2 font-weight-bold">Сертифіковані курси<br>для отримання свідоцтва<br>охоронника та охоронця</h1>
                </div>

                <div class="pl-5 border border-light border-top-0 border-bottom-0 border-right-0">
                    <img src="{{ URL::asset('public/images/logo_small.svg') }}" class="w-75">
                </div>
            </div>
        </div>
        <div id="carouselExampleIndicators" class="carousel slide level-2" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
              <div class="carousel-item active" data-interval="3000">
                <img class="d-block mx-0 vw-100" src="{{ URL::asset('public/images/hero_1.png') }}" alt="Security man">
              </div>
              <div class="carousel-item" data-interval="3000">
                <img class="d-block mx-0 vw-100" src="{{ URL::asset('public/images/hero_2.png') }}" alt="Video monitors">
              </div>
              <div class="carousel-item" data-interval="3000">
                <img class="d-block mx-0 vw-100" src="{{ URL::asset('public/images/hero_3.png') }}" alt="Security woman">
              </div>
              <div class="carousel-item" data-interval="3000">
                <img class="d-block mx-0 vw-100" src="{{ URL::asset('public/images/hero_4.png') }}" alt="Security post">
              </div>
            </div>
        </div>
    </div>

    <div class="background-grey vh-100 d-flex d-md-none align-items-center font-montserrat overflow-hidden" id="hero">
        <div class="p-5 position-absolute level-1 vh-100 vw-100 d-flex align-items-center">
            <div class="d-flex justify-content-center align-items-center flex-column w-100">
                <div class="text-center mb-5">
                    <img src="{{ URL::asset('public/images/logo_small.svg') }}" class="w-75">
                </div>

                <div class="text-white text-center">
                    <h1 class="h3 font-weight-bold">Сертифіковані курси<br>для отримання свідоцтва<br>охоронника та охоронця</h1>
                </div>
            </div>
        </div>
        <div id="carouselExampleIndicators" class="carousel slide level-2" data-ride="carousel">
            <div class="carousel-inner" role="listbox">
              <div class="carousel-item active" data-interval="3000">
                <img class="d-block mx-auto vh-100" src="{{ URL::asset('public/images/hero_1.png') }}" alt="Security man">
              </div>
              <div class="carousel-item" data-interval="3000">
                <img class="d-block mx-auto vh-100" src="{{ URL::asset('public/images/hero_2.png') }}" alt="Video monitors">
              </div>
              <div class="carousel-item" data-interval="3000">
                <img class="d-block mx-auto vh-100" src="{{ URL::asset('public/images/hero_3.png') }}" alt="Security woman">
              </div>
              <div class="carousel-item" data-interval="3000">
                <img class="d-block mx-auto vh-100" src="{{ URL::asset('public/images/hero_4.png') }}" alt="Security post">
              </div>
            </div>
        </div>
    </div>

    <div class="background-rope">
        <div class="row w-100 m-0 p-5 font-montserrat" id="about">
            <div class="col-md-6 col-xs-12 p-5 text-center my-auto">
                <img src="{{ URL::asset('public/images/logo_big.svg') }}" alt="DV55" width="90%">
            </div>
            <div class="col-md-6 col-xs-12 p-md-5 p-0 my-auto">
                <h4 class="h3 font-weight-bold font-pt-serif mb-3 text-shadow">Про нас</h4>
                <p class="mb-3 text-justify">Група компаній DV55 на підставі Ліцензії Міністерства освіти і науки України проводить комплексне професійно-технічне навчання та підвищення кваліфікації у таких напрямках:</p>
                <ul class="pl-5">
                    <li class="mb-2">Охоронник (1-4 розряд)</li>
                    <li class="mb-2">Охоронець (тілоохоронець)</li>
                    <li class="mb-2">Підготовка професійних кадрів для роботи у торгівельних центрах</li>
                    <li class="mb-2">Підготовка професійних кадрів для роботи у навчальних закладах</li>
                    <li class="mb-2">Супровід вантажоперевезень</li>
                    <li class="mb-2">Підготовка професійних безпекових кадрів для роботи в галузі судноплавства та морського/ річкового транспорту</li>
                    <li class="mb-2">Забезпечення інформаційної безпеки</li>
                </ul>
            </div>


            <div class="container mb-5">
                <div class="row">
                    <div class="offset-md-1 col-md-10 col-xs-12 h6 mt-5 p-md-5 text-justify">Навчальні матеріали курсів DV55 – це узагальнення практичного досвіду висококваліфікованих спеціалістів у сфері наземної, особистої та морської охорони, серед якого: </div>

                    <div class="d-md-block d-none">
                        <div class="d-flex mb-4">
                            <div class="neuro-card p-5 mx-4 d-flex flex-column">
                                <span class="color-navy iconify h1 mx-auto mb-3" data-icon="fa-solid:award" data-inline="false"></span>
                                <div class="text-justify">
                                    Понад 30 років у сфері наземної охорони, безпеки і транспортній галузі
                                </div>
                            </div>
                            <div class="neuro-card p-5 mx-4 d-flex flex-column">
                                <span class="color-navy iconify h1 mx-auto mb-3" data-icon="fa-solid:truck" data-inline="false"></span>
                                <div class="text-justify">
                                    Близько 1100 рейсів охоронного супроводу вантажоперевезень по території України
                                </div>
                            </div>
                            <div class="neuro-card p-5 mx-4 d-flex flex-column">
                                <span class="color-navy iconify h1 mx-auto mb-3" data-icon="icon-park-outline:castle" data-inline="false"></span>
                                <div class="text-justify">
                                    30 охоронюваних об’єктів станом на 2021 рік
                                </div>
                            </div>
                        </div>

                        <div class="d-flex mt-4">
                            <div class="neuro-card p-5 mx-4 d-flex flex-column">
                                <span class="color-navy iconify h1 mx-auto mb-3" data-icon="uil:ship" data-inline="false"></span>
                                <div class="text-justify">
                                    Більш ніж 150 реалізованих контрактів із забезпечення морської охорони в Зоні Високого Ризику
                                </div>
                            </div>
                            <div class="neuro-card p-5 mx-4 d-flex flex-column">
                                <span class="color-navy iconify h1 mx-auto mb-3" data-icon="fa-solid:user-shield" data-inline="false"></span>
                                <div class="text-justify">
                                    7 операцій ескортування нелегалів із території України до країн Північної та Центральної Африки
                                </div>
                            </div>
                            <div class="neuro-card p-5 mx-4 d-flex flex-column">
                                <span class="color-navy iconify h1 mx-auto mb-3" data-icon="mdi:bullseye-arrow" data-inline="false"></span>
                                <div class="text-justify">
                                    В інфраструктурі – спортивно-стрілецький клуб та тренувальний центр для удосконалення практичних навичок штату
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-md-none d-block row mt-3">
                        <div class="col-12 neuro-card p-5 my-4 d-flex flex-column">
                            <span class="color-navy iconify h1 mx-auto mb-3" data-icon="fa-solid:award" data-inline="false"></span>
                            <div class="text-justify">
                                Понад 30 років у сфері наземної охорони, безпеки і транспортній галузі
                            </div>
                        </div>
                        <div class="col-12 neuro-card p-5 my-4 d-flex flex-column">
                            <span class="color-navy iconify h1 mx-auto mb-3" data-icon="fa-solid:truck" data-inline="false"></span>
                            <div class="text-justify">
                                Близько 1100 рейсів охоронного супроводу вантажоперевезень по території України
                            </div>
                        </div>
                        <div class="col-12 neuro-card p-5 my-4 d-flex flex-column">
                            <span class="color-navy iconify h1 mx-auto mb-3" data-icon="icon-park-outline:castle" data-inline="false"></span>
                            <div class="text-justify">
                                30 охоронюваних об’єктів станом на 2021 рік
                            </div>
                        </div>
                        <div class="col-12 neuro-card p-5 my-4 d-flex flex-column">
                            <span class="color-navy iconify h1 mx-auto mb-3" data-icon="uil:ship" data-inline="false"></span>
                            <div class="text-justify">
                                Більш ніж 150 реалізованих контрактів із забезпечення морської охорони в Зоні Високого Ризику
                            </div>
                        </div>
                        <div class="col-12 neuro-card p-5 my-4 d-flex flex-column">
                            <span class="color-navy iconify h1 mx-auto mb-3" data-icon="fa-solid:user-shield" data-inline="false"></span>
                            <div class="text-justify">
                                7 операцій ескортування нелегалів із території України до країн Північної та Центральної Африки
                            </div>
                        </div>
                        <div class="col-12 neuro-card p-5 my-4 d-flex flex-column">
                            <span class="color-navy iconify h1 mx-auto mb-3" data-icon="mdi:bullseye-arrow" data-inline="false"></span>
                            <div class="text-justify">
                                В інфраструктурі – спортивно-стрілецький клуб та тренувальний центр для удосконалення практичних навичок штату
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row w-100 m-0 vh-100 background-people font-montserrat px-5 flex-column align-items-center justify-content-center">
            <div class="col-xs-12 col-md-6 text-center my-auto">
                <h4 class="h3 mx-auto font-weight-bold font-pt-serif text-white mb-5 text-center">Наша місія</h4>
                <div class="d-flex flex-row color-blue mb-3 justify-content-around">
                    <span class="iconify h1" data-icon="ph:users-three-bold" data-inline="false"></span>
                    <span class="iconify h1" data-icon="fluent:star-12-regular" data-inline="false"></span>
                    <span class="iconify h1" data-icon="fluent:hat-graduation-12-regular" data-inline="false"></span>
                </div>
                <p class="font-italic text-white px-md-5 px-3 text-justify">Впровадження охоронних послуг нового рівня, де превалює <span class="color-blue font-weight-bold text-shadow">командна робота, професіоналізм та освіченість</span> персоналу</p>
            </div>
        </div>

        <div class="row w-100 m-0 px-5 font-montserrat" id="courses">
            <h4 class="h3 mt-5 mx-auto font-weight-bold font-pt-serif">Курси</h4>
            <p class="my-5 text-justify px-md-5 px-3 color-dark-grey">
                Відповідно до законодавства України, охоронна діяльність здійснюється персоналом який відповідає встановленим кваліфікаційним вимогам. Якщо ви маєте намір працювати в охоронній компанії, ви повинні закінчити навчання та отримати <b>Свідоцтво охоронника</b>. Особам, які успішно завершили навчання, видається <b>Свідоцтво встановленого державного зразка про присвоєння (підвищення) відповідної кваліфікації</b>.
            </p>
            <div class="container">
                <div class="row">@foreach ($courses as $course)
                    <div class="col-md-4 col-sm-6 col-xs-12 my-5">
                        <div class="neuro-card text-center p-5">
                            <img src="{{ URL::asset('public/images/logo_big.svg') }}" class="w-75 text-center d-flex justify-content-center mx-auto">
                            <h5 class="card-title font-weight-bold my-4">{{$course->title}}</h5>
                            <button type="button" class="card-link button py-2 shadow mx-auto text-white" data-toggle="modal" data-target="#course_{{$course->id}}">Детальніше про курс</button>
                        </div>
                    </div>
                    <div class="modal fade" id="course_{{$course->id}}" tabindex="-1" role="dialog" aria-labelledby="course_{{$course->id}}Label" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content border-0 neuro-card shadow p-5">
                                <div class="modal-header">
                                    <h5 class="modal-title mx-auto" id="course_{{$course->id}}Label">{{$course->title}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-center">
                                    <img src="{{ URL::asset('public/images/logo_big.svg') }}" class="w-75 text-center d-flex justify-content-center mx-auto">
                                    <h5 class="card-title font-weight-bold my-4">{{$course->title}}</h5>
                                    <p>{{$course->description}}</p>
                                </div>
                                <div class="modal-footer">
                                    <a href="/courses/{{$course->id}}" class="button py-2 mx-auto px-5">Розпочати</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach</div>
            </div>

        </div>

        <div class="row w-100 m-0 inner-shadow px-md-5 px-3 font-montserrat" id="feedback">
            <h4 class="col-12 h3 my-5 text-center font-weight-bold font-pt-serif text-shadow">Зв'яжіться з нами</h4>
            <div class="col-md-4 offset-md-1 col-xs-12 mb-5 pb-5">
                <div class="neuro-card p-5">
                    <form method="POST" autocomplete="off" action="/sendmail">
                        <h6 class="font-weight-bold text-center pt-3">Є питання - напишіть нам</h6>
                        @csrf
                        <div class="mb-3">
                            <input type="text" placeholder="Ваше ім'я" name="name" class="glassmorphism-input-dark small w-100" required>
                        </div>

                        <div class="mb-4">
                            <input type="text" placeholder="Ваша електронна пошта" name="email" class="glassmorphism-input-dark small w-100" required>
                        </div>

                        <div class="mb-5">
                            <textarea name="message" class="small background-light-grey color-dark-grey shadow rounded-corner p-3 border-0 w-100" placeholder="Ваше повідомлення" rows="5" required></textarea>
                        </div>

                        <div class="mx-auto">
                            <button type="submit" class="shadow button background-red btn-block font-weight-bold">Надіслати</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-4 offset-md-2 col-xs-12 mb-5 pb-5 my-auto">
                <div class="neuro-card p-md-5 p-4 d-flex flex-column">
                    <a href="#" class="social-link color-navy my-4 px-3 py-2 rounded-corner"><span class="iconify" data-icon="bi:telegram" data-inline="false"></span> Зв'язатись у Telegram</a>
                    <a href="#" class="social-link color-green my-4 px-3 py-2 rounded-corner"><span class="iconify" data-icon="bi:whatsapp" data-inline="false"></span> Зв'язатись у WhatsApp</a>
                    <a href="mailto:dv55.sports@gmail.com" class="social-link color-blue my-4 px-3 py-2 rounded-corner"><span class="iconify" data-icon="uil:envelope" data-inline="false"></span> Написати email</a>
                </div>
            </div>
        </div>

        <div class="row w-100 m-0 background-people font-montserrat p-5 flex-column align-items-center justify-content-center" id="contacts">
            <h4 class="col-12 h3 mb-5 mx-auto font-weight-bold text-white text-center font-pt-serif">Ми у соцмережах</h4>
            <div class="col-xs-12 col-md-6 text-center my-auto my-5">
                <div class="d-flex flex-md-row flex-column color-blue mb-3 justify-content-around">
                    <a href="https://www.linkedin.com/company/75043983/admin/" targer="_blank" class="bg-white rounded-corner p-5 m-4 d-flex flex-column social-link color-blue">
                        <span class="iconify mx-auto h1" data-icon="brandico:linkedin-rect" data-inline="false"></span>
                        <div class="text-center">
                            LinkedIn
                        </div>
                    </a>
                    <a href="https://www.instagram.com/dv55.center" targer="_blank" class="bg-white rounded-corner p-5 m-4 d-flex flex-column social-link color-red">
                        <span class="iconify mx-auto h1" data-icon="grommet-icons:instagram" data-inline="false"></span>
                        <div class="text-center">
                            Instagram
                        </div>
                    </a>
                    <a href="https://www.facebook.com/%D0%A2%D1%80%D0%B5%D0%BD%D1%83%D0%B2%D0%B0%D0%BB%D1%8C%D0%BD%D0%B8%D0%B9-%D1%86%D0%B5%D0%BD%D1%82%D1%80-DV55-125913529670812" targer="_blank" class="bg-white rounded-corner p-5 m-4 d-flex flex-column social-link color-navy">
                        <span class="iconify mx-auto h1" data-icon="brandico:facebook-rect" data-inline="false"></span>
                        <div class="text-center">
                            Facebook
                        </div>
                    </a>
                    <a href="https://t.me/Division55" targer="_blank" class="bg-white rounded-corner p-5 m-4 d-flex flex-column social-link color-blue">
                        <span class="iconify mx-auto h1" data-icon="bi:telegram" data-inline="false"></span>
                        <div class="text-center">
                            Telegram
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="row w-100 m-0 background-dark-grey p-5 text-white font-montserrat" id="footer">
            <div class="col-xs-12 col-md-4 text-center my-auto">
                <img src="{{ URL::asset('public/images/logo_small.svg') }}" width="50%">
            </div>
            <div class="col-xs-12 col-md-4 mt-md-0 mt-5">
                <div class="d-flex justify-content-center flex-column">
                    <p class="font-weight-bold font-pt-serif h5">Навігація</p>
                    <a href="#hero" class="text-white my-2 small">Головна</a>
                    <a href="#about" class="text-white my-2 small">Про нас</a>
                    <a href="#courses" class="text-white my-2 small">Курси</a>
                    <a href="#feedback" class="text-white my-2 small">Контакти</a>
                </div>
            </div>
            <div class="col-xs-12 col-md-4 mt-md-0 mt-5">
                <div class="d-flex justify-content-center flex-column">
                    <p class="font-weight-bold font-pt-serif h5">Корисні посилання</p>
                    <a href="#" class="text-white my-2 small">Умови використання</a>
                    <a href="#" class="text-white my-2 small">Конфіденційність</a>
                    <a href="#" class="text-white my-2 small">Авторські права</a>
                    <a href="#" class="text-white my-2 small">Ліцензія</a>
                </div>
            </div>
            <div class="col-12 text-center mt-5">
                <p>Copyright 2021. DV55 Training Center. All rights reserved</p>
            </div>
        </div>
    </div>
            {{--
            </div> --}}
@endsection

@section('additional_scripts')
    <script>
        $(document).ready(function() {
            $(window).scroll(function() {
                if($(this).scrollTop() > 10) {
                    $('.navbar').addClass('background-light-grey').removeClass('navbar-dark').addClass('navbar-light').addClass('shadow');
                } else {
                    $('.navbar').removeClass('background-light-grey').removeClass('navbar-light').removeClass('shadow').addClass('navbar-dark');
                }
            });
        });
        $('.navbar-toggler').on('click', function () {
            if($('.navbar').hasClass('navbar-dark')) {
                $('.navbar').addClass('background-light-grey').removeClass('navbar-dark').addClass('navbar-light').addClass('shadow');
            } else {
                $('.navbar').removeClass('background-light-grey').removeClass('navbar-light').removeClass('shadow').addClass('navbar-dark');
            }
        });
    </script>
@endsection
