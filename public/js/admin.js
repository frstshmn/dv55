$("button[data-target='#editCourseModal']").on('click', function(){
    $.get("/courses/json/" + $(this).data("id"), function( data ) {
        $('#editCourseModal #identifier').val(JSON.parse(data).id);
        $('#editCourseModal #title').val(JSON.parse(data).title);
        $('#editCourseModal #description').val(JSON.parse(data).description);

        $('#addModuleModal #course_id').val(JSON.parse(data).id);
    });
});

$("button[data-target='#addModuleModal']").on('click', function(){
    $('#addModuleModal #course_id').val($(this).data("id"));
});

$("button[data-target='#editModuleModal']").on('click', function(){
    $.get("/modules/" + $(this).data("id"), function( data ) {
        $('#editModuleModal #identifier').val(JSON.parse(data).id);
        $('#editModuleModal #title').val(JSON.parse(data).title);
        $('#editModuleModal #course_id').val(JSON.parse(data).course_id);
    });
});
