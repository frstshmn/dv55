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
    if(confirm('Do you really want to delete?')){
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
    }
});


let question_count = 1;
$(".add-question").on('click', function(e){
    e.preventDefault();
    $('#question_list').append('<div class="neuro-card mb-3 p-5" id="q'+ question_count +'"><div class="d-flex flex-row justify-content-between"><label class="font-weight-bold">Question '+ question_count +'</label><button type="button" class="close" ><span aria-hidden="true" class="delete-question" data-question="#q'+ question_count +'">&times;</span></button></div><input type="text" placeholder="Type here your question" name="question_'+ question_count +'" class="glassmorphism-input-dark small w-100" required><div class="row"><div class="col-6 d-flex flex-row align-items-center"><input type="radio" name="correct_answer_'+ question_count +'" value="1" class="mr-2" required><label class="font-weight-bold">1. </label><input type="text" name="variant_1_'+ question_count +'" class="ml-2 glassmorphism-input-dark small w-100" required></div><div class="col-6 d-flex flex-row align-items-center"><input type="radio" name="correct_answer_'+ question_count +'" value="2" class="mr-2" required><label class="font-weight-bold">2. </label><input type="text" name="variant_2_'+ question_count +'" class="ml-2 glassmorphism-input-dark small w-100" required></div><div class="col-6 d-flex flex-row align-items-center"><input type="radio" name="correct_answer_'+ question_count +'" value="3" class="mr-2" required><label class="font-weight-bold">3. </label><input type="text" name="variant_3_'+ question_count +'" class="ml-2 glassmorphism-input-dark small w-100" required></div><div class="col-6 d-flex flex-row align-items-center"><input type="radio" name="correct_answer_'+ question_count +'" value="4" class="mr-2" required><label class="font-weight-bold">4. </label><input type="text" name="variant_4_'+ question_count +'" class="ml-2 glassmorphism-input-dark small w-100" required></div></div></div>')
    $('#question_count').val($('#question_list .neuro-card').length);
    question_count++;
})

$(document).on('click', ".delete-question", function(e){
    e.preventDefault();
    $($(this).data("question")).remove();
})

$(document).on('click', "button[data-target='#addTestModal']", function(){
    $('#addTestModal #module_id').val($(this).data("module"));
});

$(document).on('click', "button[data-target='#editTestModal']", function(){
    $.get("/tests/json/" + $(this).data("test"), function( data ) {
        $('#editTestModal #time').val(JSON.parse(data).time);
        $('#editTestModal #module_id').val(JSON.parse(data).module_id);
        $('#editTestModal #test_id').val(JSON.parse(data).id);
    });
    $.get("/questions/json/" + $(this).data("test"), function( data ) {
        $('#editTestModal #question_list').empty();

        $.each(JSON.parse(data), function(index, element){
            $('#editTestModal #question_list').append('<div class="neuro-card mb-3 p-5" id="q'+ element.id +'"><div class="d-flex flex-row justify-content-between"><label class="font-weight-bold">Question '+ element.id +'</label><button type="button" class="close" ><span aria-hidden="true" class="delete-question" data-question="#q'+ element.id +'">&times;</span></button></div><input type="text" placeholder="Type here your question" name="question_'+ element.id +'" value="'+ element.question +'" class="glassmorphism-input-dark small w-100" required><div class="row"><div class="col-6 d-flex flex-row align-items-center"><input type="radio" name="correct_answer_'+ element.id +'" value="1" class="mr-2" required><label class="font-weight-bold">1. </label><input type="text" name="variant_1_'+ element.id +'" class="ml-2 glassmorphism-input-dark small w-100" value="'+ element.v_1 +'" required></div><div class="col-6 d-flex flex-row align-items-center"><input type="radio" name="correct_answer_'+ element.id +'" value="2" class="mr-2" required><label class="font-weight-bold">2. </label><input type="text" name="variant_2_'+ element.id +'" value="'+ element.v_2 +'" class="ml-2 glassmorphism-input-dark small w-100" required></div><div class="col-6 d-flex flex-row align-items-center"><input type="radio" name="correct_answer_'+ element.id +'" value="3" class="mr-2" required><label class="font-weight-bold">3. </label><input type="text" name="variant_3_'+ element.id +'" value="'+ element.v_3 +'" class="ml-2 glassmorphism-input-dark small w-100" required></div><div class="col-6 d-flex flex-row align-items-center"><input type="radio" name="correct_answer_'+ element.id +'" value="4" class="mr-2" required><label class="font-weight-bold">4. </label><input type="text" name="variant_4_'+ element.id +'" value="'+ element.v_4 +'" class="ml-2 glassmorphism-input-dark small w-100" required></div></div></div>')
            $("input[name='correct_answer_"+ element.id + "'][value='"+ element.correct_answer +"']").prop("checked", true);
        })

    });
    $('#editTestModal #question_count').val($('#editTestModal #question_list .neuro-card').length);
});

let new_question_count = 1;
$("#editTestModal .add-question").on('click', function(e){
    e.preventDefault();
    $('#editTestModal #question_list').append('<div class="neuro-card mb-3 p-5" id="new_q'+ new_question_count +'"><div class="d-flex flex-row justify-content-between"><label class="font-weight-bold">Question '+ new_question_count +'</label><button type="button" class="close" ><span aria-hidden="true" class="delete-question" data-question="#new_q'+ new_question_count +'">&times;</span></button></div><input type="text" placeholder="Type here your question" name="new_question_'+ new_question_count +'" class="glassmorphism-input-dark small w-100" required><div class="row"><div class="col-6 d-flex flex-row align-items-center"><input type="radio" name="new_correct_answer_'+ new_question_count +'" value="1" class="mr-2" required><label class="font-weight-bold">1. </label><input type="text" name="new_variant_1_'+ new_question_count +'" class="ml-2 glassmorphism-input-dark small w-100" required></div><div class="col-6 d-flex flex-row align-items-center"><input type="radio" name="new_correct_answer_'+ new_question_count +'" value="2" class="mr-2" required><label class="font-weight-bold">2. </label><input type="text" name="new_variant_2_'+ new_question_count +'" class="ml-2 glassmorphism-input-dark small w-100" required></div><div class="col-6 d-flex flex-row align-items-center"><input type="radio" name="new_correct_answer_'+ new_question_count +'" value="3" class="mr-2" required><label class="font-weight-bold">3. </label><input type="text" name="new_variant_3_'+ new_question_count +'" class="ml-2 glassmorphism-input-dark small w-100" required></div><div class="col-6 d-flex flex-row align-items-center"><input type="radio" name="new_correct_answer_'+ new_question_count +'" value="4" class="mr-2" required><label class="font-weight-bold">4. </label><input type="text" name="new_variant_4_'+ new_question_count +'" class="ml-2 glassmorphism-input-dark small w-100" required></div></div></div>')
    $('#editTestModal #question_count').val($('#editTestModal #question_list .neuro-card').length);
    new_question_count++;
})
