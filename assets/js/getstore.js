$(document).ready(function () {
    $.get("auth.php", {action: "get_store_data"})
            .done(function (data) {
               // console.log(data);
            });
});


