<div class="row vh-100 p-5">
    <div class="neuro-card text-center p-5">
        <h1 class="display-4">Test examination on "{{$test->module->title}}" module</h1>
        <p class="lead">Test time: {{$test->time}} minutes. There are 4 answer variants, where <span class="font-weight-bold color-red">ONLY 1</span> is correct</p>
        <hr class="my-2">
        <p class="font-italic small">Access to materials of module will be restricted during test. Also be sure not to switch to other browser tabs, this information can be recorded and used to calculate final score. If you try to reload the page, you fail the test.</p>
        <p class="color-red font-italic font-weight-bold text-center small">If you stuck or have any technical problem - please contact your instructor!</p>
        <p class="lead text-center mt-5">
            <button class="shadow button background-red font-weight-bold" id="start_test" data-id="{{$test->id}}">Begin test</button>
        </p>
    </div>
</div>

