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

function startTest(timer) {

}
