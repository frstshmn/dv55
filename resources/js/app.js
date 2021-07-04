//require('./bootstrap');

//require('alpinejs');

$('.material').on("click", function () {
    $.get("/materials/" + $(this).data("id"), function( data ) {
        $("#material_content").html(data);
    });
});

$('.test').on("click", function () {
    $.get("/tests/" + $(this).data("id"), function( data ) {
        $("#material_content").html(data);
    });
});

$(document).on("click", '#start_test', function () {
    $.get("/tests/questions/" + $(this).data("id"), function( data ) {
        $("#material_content").html(data);
    });
    $('#sidebar').remove();
    $('#sidebar_thumb').removeClass("d-none");
});


$("button[data-target='#editCourseModal']").on('click', function(){
    $.get("/courses/json/" + $(this).data("id"), function( data ) {
        $('#editCourseModal #identifier').val(JSON.parse(data).id);
        $('#editCourseModal #title').val(JSON.parse(data).title);
        $('#editCourseModal #description').val(JSON.parse(data).description);
    });
});
