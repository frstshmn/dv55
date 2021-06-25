//require('./bootstrap');

//require('alpinejs');

$('.material').on("click", function () {
    alert("material " + $(this).data("id") + " got");
});

$('.test').on("click", function () {
    alert("test " + $(this).data("id") + " got");
});
