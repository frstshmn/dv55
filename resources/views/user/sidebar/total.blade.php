    <a href="/cabinet" class="small font-weight-bold color-light-grey d-md-block d-none pt-3"><span class="iconify" data-icon="eva:arrow-left-fill" data-inline="false"></span>Back to courses</a>
    <div class="d-flex flex-row justify-content-between d-md-none pt-3">
        <a href="/cabinet" class="small font-weight-bold color-light-grey "><span class="iconify" data-icon="eva:arrow-left-fill" data-inline="false"></span>Back</a>
        <a class="small font-weight-bold color-light-grey" onclick="$('#sidebar').toggleClass('active');">Hide<span class="iconify ml-1" data-icon="ci:hide" data-inline="false"></span></a>
    </div>
    <div class=" mx-auto mt-4 text-white text-left">
        <div class="font-weight-bold text-center">{{$course->title}}</div>
        <div class="small mt-4">{{ $course->totalScore(Auth::user()->id) }}%</div>
        <div class="progress-wrapper rounded-corner">
            <div class="progress-bar" style="width: {{ $course->totalScore(Auth::user()->id) }}%"></div>
        </div>
    </div>
