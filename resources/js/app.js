//require('./bootstrap');

//require('alpinejs');

$('.material').on("click", function () {
    $('#material_content').attr({'style': 'display: none!important'});
    $('#material_content_loader').attr({'style': 'display: flex!important'});
    $.get("/materials/" + $(this).data("id"), function( data ) {
        $('#material_content').attr({'style': 'display: block!important'});
        $('#material_content_loader').attr({'style': 'display: none!important'});
        $("#material_content").html(data);
    });

});

$(document).on("click", ".next-material", function () {
    $('#material_content').attr({'style': 'display: none!important'});
    $('#material_content_loader').attr({'style': 'display: flex!important'});
    let next = $(this).data("next");
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '/usercomplection',
        type: 'POST',
        data: {
            user_id: $(this).data("user"),
            material_id: $(this).data("current")
        },
        success: function(result) {
            $.get("/materials/" + next, function (data) {
                $('#material_content').attr({'style': 'display: block!important'});
                $('#material_content_loader').attr({'style': 'display: none!important'});
                $("#material_content").html(data);
            });
        }
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
        let timeMinut = parseInt($('#test_timer').text()) * 60;
        let timer = setInterval(function () {
            seconds = timeMinut%60;
            minutes = timeMinut/60%60;
            if (timeMinut <= 0) {
                clearInterval(timer);
                $('#test').submit();
            } else {
                let strTimer = `${Math.trunc(minutes)}:${seconds}`;
                $('#test_timer').text(strTimer);
            }
            --timeMinut;
            console.log(strTimer);
        }, 1000)
    });

    $('#sidebar').remove();
    $('#sidebar_thumb').removeClass("d-none").addClass("d-flex");
});





