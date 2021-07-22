$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

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
    $.get("/modules/json/" + $(this).data("id"), function( data ) {
        $('#editModuleModal #identifier').val(JSON.parse(data).id);
        $('#editModuleModal #title').val(JSON.parse(data).title);
        $('#editModuleModal #course_id').val(JSON.parse(data).course_id);
    });
});

$(".show-materials").on('click', function(){
    $('#module_materials').empty().append('<span class="iconify display-1 material-loading" data-icon="eos-icons:three-dots-loading" data-inline="false"></span>');
    let id = $(this).data("id");
    $.get("/modules/json/" + id , function( data ) {
        $('.material-loading').remove();
        $('#module_materials').append('<p class="font-weight-bold text-center" id="module_name">Materials of '+ JSON.parse(data).title +'</p>').append('<span class="iconify display-1 material-loading" data-icon="eos-icons:three-dots-loading" data-inline="false"></span>');
        $.get("modules/"+ id +"/materials/", function( data ) {
            $('.material-loading').remove();
            $.each(JSON.parse(data), function(index, element){
                $('.material-loading').remove();
                $('#module_materials').append('<div class="neuro-card py-3 my-3 px-4 d-flex flex-row justify-content-between align-items-center"><div class="small text-overflow-ellipsis">'+element.title+'</div><button data-toggle="modal" data-target="#editMaterialModal" data-id="'+element.id+'" class="card-link button py-2 px-4 shadow text-white align-middle"><span class="iconify align-middle mb-1" data-icon="fa-regular:edit" data-inline="false"></span></button></div>').append('<span class="iconify display-1 material-loading" data-icon="eos-icons:three-dots-loading" data-inline="false"></span>');
            })
            $('.material-loading').remove();
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

$(document).on('click', "button[data-target='#editUserModal']", function(){
    let user_id = $(this).data("id");
    $.get("/users/json/" + user_id, function( data ) {
        $('#editUserModal #identifier').val(JSON.parse(data).id);
        $('#editUserModal #user_id').val(JSON.parse(data).id);
        $('#editUserModal #name').val(JSON.parse(data).name);
        $('#editUserModal #email').val(JSON.parse(data).email);
        $('#editUserModal #is_admin').val(JSON.parse(data).is_admin);
    });

    $.get("/users/json/" + user_id + "/courses", function( data ) {
        $('#user_courses').empty();
        $.each(JSON.parse(data), function(index, element){
            $('#editUserModal #user_courses').append('<div class="neuro-card py-3 my-3 px-4 d-flex flex-row w-100 justify-content-between align-items-center" data-delete="'+ element.id +'"><div class="text-left" >'+ element.title +'</div><button class="card-link button py-2 px-4 shadow text-white align-middle delete-course" data-course="'+ element.id +'" data-user="'+ user_id +'"><span class="iconify align-middle mb-1" data-icon="fa-regular:trash-alt" data-inline="false"></span></button></div>');
        })
    });
});

$(document).on('click', ".delete-course", function(){
    $.ajax({
        url: '/usercourses',
        type: 'DELETE',
        data: {
            user_id: $(this).data("user"),
            course_id: $(this).data("course")
        },
        success: function(result) {
            location.href = location.href;
        }
    });
});

