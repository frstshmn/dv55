<a href="/cabinet" class="small font-weight-bold color-light-grey "><span class="iconify" data-icon="eva:arrow-left-fill" data-inline="false"></span>Back to courses</a>
<div class=" mx-auto mt-4 text-white text-left">
    <div class="font-weight-bold text-center">{{$course->title}}</div>
    <div class="small mt-4">{{ $course->totalScore(Auth::user()->id) }}%</div>
    <div class="progress-wrapper">
        <div class="progress-bar" style="width: {{ $course->totalScore(Auth::user()->id) }}%"></div>
    </div>
</div>
