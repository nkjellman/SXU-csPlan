var getUsers = function () {
    $.ajax({
        url: "Ajax/admin_get_all_accounts.php",
        method: "GET",
        datatype: "JSON",
        contentType: "application/json; charset=UTF-8",
        success: function (obj) {
            var tblBody = '';
            $.each(obj, function (i, ele) {
                tblBody += '<tr data-NetId = "' + ele.Id + '" data-toggle="modal" data-target="#UserEdit"> <td> <img src="' + (ele.Image || 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAADICAMAAACahl6sAAABrVBMVEWNiIiOiIiOiYmOioqPiYmPioqPi4uQioqQi4uRi4uRjIySjY2Sjo6Tjo6Tj4+Uj4+UkJCVkJCWkJCWkZGWkpKXkpKXk5OYlJSZlJSZlZWalZWalpablpabl5ecl5ecmJidmJidmpqemZmempqfm5ugm5ugnJyhnJyhnZ2inZ2inp6jn5+joKCkn5+koKCloKCmoaGmoqKnoqKnpKSoo6OppaWqpqaqp6erp6esp6etqqquqqquq6uvrKywq6uwrKywra2xra2xrq6yrq6yr6+zr6+zsLC0sbG1srK2srK2s7O2tLS4tLS4tbW5tbW6tra6t7e7uLi8ubm9ubm9urq+u7u/u7u/vLzAvLzAvb3Bvb3Bvr7Bv7/Cv7/CwMDDwMDEwMDEwcHEwsLFw8PGwsLGw8PGxMTHxMTHxcXIxcXIxsbJxsbJx8fJyMjKx8fLyMjLycnMycnMysrMy8vNysrNy8vOy8vOzMzPzMzPzc3Pzs7Qzc3Qzs7Qz8/Rzc3Rzs7Rz8/R0NDSzs7Sz8/S0NDS0dHT0NDT0dHT0tLU0dHU0tLU09PV0tLV09PW1NTbaf3kAAADxklEQVR4AezPgQmEMBAF0X8LywVD+m/XIkQi+qaCeTleEggICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICMiHICAgICAgICAgICAgIHPH37wBsnZA1gMgICAgoyvJr/rK6r8qSfXYBulaJzH23tTUEcZxfHrK0z5saNM0TZtQSCikFGiBplxKoSp3BQEBRdQoIagkBJSLQogH2ZVds3CivmadYXRIPOvs4Y/l+w4+85ud2Xlq438mOluiP4JFzplVFYj+0flPx+91fqvqQiAI4X/nMzv8TXF/PTkaJ+daBbBxMLlecN7J/Npifz2geQiE+jMFWaTUtimXfHuqCZB4DCF6bUuUpGCMCVliG0NhqDYMsRoWbU7tT3Ge60P06PimOyulYB8TUiy3ARqFQNta0S6PHozUeJP4Bl5IVp6z02UUAi0b3K6M0mFPm8AAlawyuZuwzEGg7nHlHqeb9HqAwN8FwT5PbsfBFAR90+zQdpNkY6DtiKxI5pZcCIAhCPy1S23X+HVSTfTCESFcIeKgxxAEfXNFWwHZbLKIVlYk6zD3nGQAzEAatqgCcsiuANEKel8JBUQUWg1B+qit6uS2H4lG6LvxlqlyRtAMZFIN4ZnaKq2PYjAtlRBxy2cGclcNoXu/WUQjCO8INSTznRnIqhpii2Y9yK+cKRPPDUFyX4CctHylBamTTF3ebwaSUkOoHddbJFIQ6kWeGlpkTg3hm1G9xx7KSTXkgaHHPqSGFJdDQDRC/x1HCXGmiBlIu61MzhDUguBYSQmRvWgGEkxxheMon9D9ojQ/kypHrhYM/X4vCQWkuPTTt0Qr9C8o/1oTBM1A4Je0YpL9LotoZrXvCfdBNmIWMQMh2JM/ch1k1k+0801IV4j4nxBjEDLuNglPh4Foh8Hksdsgsz40BiH4/SSvpFD5qPFr4iGoT5VE5RzOfBBMLXIqGc2XSzhLxoB4CiILQpY5jtl0EM3etaC6K3XmrkWLm+Mhi3gMAoNPjs/etVb/qwHTl0bE0MD9fU75h+hBbrKJAPEcYOxqlonXUkohXq4MhxEv4IgN8EPr5Zl7D1M3x7rDCEjOEQL+nBibT2eWZoc6gmjy9lu+CoBlWQDv27VDGwBAGIqCkiasjGB0BsAVUQL3BiA5hehvCcX2SIRDDwgICAgICMjHkJLxWTcFBAEBAQEBAQEBAQGpCQRk5LoPMnOBgICAgIC89SEeBgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgKyACvNcY7Xgf+NAAAAAElFTkSuQmCC')
 + '" height="42" width="42"> </td>' +
                    "<td data-fname>" + ele.Name.First + "</td>" + "<td data-lname>" + ele.Name.Last + " </td>" +
                    "<td>" + (ele.Email || "")  + "</td>"
                    + "<td data-netid>" + ele.Id + "</td>" + "<td data-role>" + mapRole(ele.Type) + "</td></tr>";

            });
            $('table#users > tbody').html(tblBody);
            loadSearch('table#users');
            $("table#users > tbody").pageMe({ pagerSelector: '#userPager'});
        }
    });
};
function mapRole(roleId) {
    switch (parseInt(roleId)) {
        case 1:
            return "Student";
        case 2:
            return "Advisor";
        case 3:
            return "Administrator";
    }
}

function reverseRole(role) {
    switch (role) {
        case "Student":
            return 1;
        case "Advisor":
            return 2;
        case "Administrator":
            return 3;
    }
}

function updateRole() { //updates role, then updates proper row in table
    $.ajax({
        url: "Ajax/admin_update_role.php",
        method: "POST",
        datatype: "JSON",
        contentType: "application/json; charset=UTF-8",
        data: JSON.stringify({
            netid : $("[name='netid']").attr("value"),
            role : $("[name='role']").val()
        }),
        success: function() {
             $('table#users > tbody').html("");
             getUsers();
        }
    });
}

function deleteUser(netid) {
    $.ajax({
        url: "Ajax/admin_delete_account.php",
        method: "POST",
        datatype: "JSON",
        contentType: "application/json; charset=UTF-8",
        data: JSON.stringify({
            deleted_net_id : netid
        }),
        success: function() {
             $('table#users > tbody').html("");
             getUsers();
        }
    });
}

getUsers();

$( "#users tbody" ).on( "click", "tr", function() {
 // console.log( $( this ).find("[data-fname]").text() );
 $("[name='name']").attr("value", $(this).find("[data-fname]").text() + " " + $(this).find("[data-lname]").text());
 $("[name='netid']").attr("value", $(this).find("[data-netid]").text());
 $("[name='role']").val(reverseRole($(this).find("[data-role]").text()));
});


$("#update").click(function() {
    updateRole();
});

$("#userdelete").click(function() {
    deleteUser($("[name='netid']").attr("value"));
});
function myFunction() {
    location.reload();
}