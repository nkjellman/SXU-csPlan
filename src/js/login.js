$(function () {
    $("form").submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: "Ajax/authentication.php",
            method: "POST",
            dataType: "JSON",
            contentType: "application/json; charset=UTF-8",
            data: JSON.stringify({ username: $("input[name='username']", "form").val(), password: $("input[name='password']", "form").val() }),
            success: function (obj) {
                window.location.href = obj.URL;
            },
            error: function(jqXHR,textStatus,errorThrown){
                $("p.error").text("Your login was invalid");
            }
        });
    });
});