$(document).ready(function () {
    // set variables for elements, create filereader
    var container = $("#ImageInputContainer"),
        fileForm = $("form", container),
        formImage = $("img", container),
        profileImage = $("#profileImage"),
        reader = new FileReader(),
        result;
    reader.addEventListener("load", function () {
        formImage[0].src = result = reader.result;
    }, false);
    //Get profile data
    $.ajax({
        method: "GET",
        url: "AJAX/profile.php",
        dataType: "JSON",
        success: function (obj) {
            $('#profileTextDiv').append('<p style="color:white;">' + obj.Name.First + ' ' + obj.Name.Last + '</p>' +
                "<a href='mailto:" + obj.Email || '' + "'>" + obj.Email || ''+ "</a>");
            profileImage.css('background-image', "url('" + obj.Image + "')");
        }
    });
    // On open of dialog, clear form data.
    $("button#openDialog").click(function () {
        formImage[0].src = '';
        fileForm[0].reset();
    });
    // On file input change, update preview, and load base64 data jnto variable
    $(fileForm[0].children[0]).on("change", function (e) {
        var file = fileForm[0].children[0].files[0];
        file && reader.readAsDataURL(file);
    });
    // post on submit to server.
    $("#profileImageForm").submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: "AJAX/profile.php",
            method: "POST",
            dataType: "JSON",
            contentType: "application/json; charset=UTF-8",
            data: JSON.stringify({ Image: result }),
            success: function (obj) {
                obj.Valid && profileImage.css('background-image', "url('" + result + "')");
            }
        });
    });
});