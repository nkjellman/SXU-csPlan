$(function () {
$("#logout").click(function(e){	
e.preventDefault();	   
$.ajax({
    type: 'GET',
    url: "Ajax/authentication.php",
    success: function() {
        window.location.href="index.php";
    }
});
});
});

