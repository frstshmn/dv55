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

$(".show-materials").on('click', function(){
    $('#module_materials').empty();
    let id = $(this).data("id");
    $.get("/modules/" + id , function( data ) {
        $('#module_materials').append('<p class="font-weight-bold text-center" id="module_name">Materials of '+ JSON.parse(data).title +'</p>');
        $.get("modules/"+ id +"/materials/", function( data ) {
            $.each(JSON.parse(data), function(index, element){
                $('#module_materials').append('<div class="neuro-card py-3 my-3 px-4 d-flex flex-row justify-content-between align-items-center">'+element.title+'<button data-toggle="modal" data-target="#editMaterialModal" data-id="'+element.id+'" class="card-link button py-2 px-4 shadow text-white align-middle"><span class="iconify align-middle mb-1" data-icon="fa-regular:edit" data-inline="false"></span></button></div>');
            })
            $('#module_materials').append('<button data-toggle="modal" data-target="#addMaterialModal" data-id="'+ id +'" class="card-link button py-2 shadow mx-auto text-white align-middle">Create new material <span class="iconify align-middle" data-icon="fa-solid:plus" data-inline="false"></span></button>');
        });
    });
});

$(document).on('click', "button[data-target='#addMaterialModal']", function(){
    $('#addMaterialModal #module_id').val($(this).data("id"));
});

$(document).on('click', "button[data-target='#editMaterialModal']", function(){
    $.get("/materials/json/" + $(this).data("id"), function( data ) {
        $('#edit_material #identifier').val(JSON.parse(data).id);
        $('#edit_material #title').val(JSON.parse(data).title);
        $('#edit_material #code').val(JSON.parse(data).code);
        $('#delete_material #identifier').val(JSON.parse(data).id);
    });
});
