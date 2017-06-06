$(function () {
    var semester;
    $("#AddCourse > form").submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: "Ajax/advisor_create_course.php",
            method: "POST",
            dataType: "JSON",
            contentType: "application/json; charset=UTF-8",
            data: JSON.stringify({
                name: $("input[name='Course-name']", "#AddCourse > form").val(),
                number: $("input[name='Course-num']", "#AddCourse > form").val()
            }),
            department: $("select[name='Department']", "#AddCourse > form").val(),
            success: function (obj) {
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $("p.error").text("");
            }
        });
    });
    $("li > a", "#SemesterOptions").click(function (e) {
        semester = {
            value: e.currentTarget.dataset.value,
            text: e.currentTarget.text
        }
    });
    $(".dropdown").on("hide.bs.dropdown", function (e) {
        searchCourses({
            Semester: semester.value,
            Year: new Date().getFullYear(),
        });
        $("#ChooseSemester").text(semester.text);

    });
    $("form", "#StudentInit").submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: "Ajax/student_isFirstLogin.php",
            method: "POST",
            dataType: "JSON",
            contentType: "application/json; charset=UTF-8",
            data: JSON.stringify({
                Adviser: InitForm.Adviser.val(),
                Major: parseInt(InitForm.Major.val()),
                Year: parseInt(InitForm.Enrollment.val()),
                Transfer: InitForm.Transfer.is(":checked")
            }),
            success: function (obj) {
                if (obj.Valid) $('#StudentInit').modal('hide');

            },
            error: function (jqXHR, textStatus, errorThrown) {
                $("p.error").text("");
            }
        });
    });
    /* Student course selection */
    var offeringsTbody = $("tbody#offered_courses");
    var selectionsTBody = $("tbody#selected_courses");
    var lookupSelectedRows = [];
    var selectedRows = [];
    var addCourses = $("span#AddCourses");
    var removeCourses = $("span#RemoveCourses");
    var viewCourses = function (obj) {
        $.ajax({
            url: "Ajax/student_view_course.php",
            method: "GET",
            dataType: "JSON",
            contentType: "application/json; charset=UTF-8",
            success: function (obj) {
                clearArrays();

                var htmlText = '';
                if (obj == null) {
                    selectionsTBody.html(htmlText);
                    return;
                }
                $.each(obj, function (i, element) {
                    htmlText += '<tr data-id="' + element.Id + '" data-year="' + element.Year + '" data-semester="' + element.Semester + '" ><td>' +
                        element.Department.Abbreviation + '-' + element.Number + '</td><td>' +
                        element.Name + '</td><td>' +
                        element.Year + element.Semester + '</td><td>' + (element.Approved ? "<span style='color:green' class ='glyphicon glyphicon-ok'></span>" : "<span style='color:red' class ='glyphicon glyphicon-remove'></span>") + '</td></tr>'
                });
                selectionsTBody.html(htmlText);
                rowClick("table#selected > tbody > tr");
                loadSearch('table#selected');
                $("table#selected > tbody").pageMe({ pagerSelector: '#selectedPager' });
            },
            error: function (jqXHR, textStatus, errorThrown) {
            }
        });
    };
    var InitForm = {
        Form: $("form", "#StudentInit"),
        Adviser: $("select[name='Adviser']", "#StudentInit form"),
        Enrollment: $("input[name='FYear']", "#StudentInit form"),
        Major: $("select[name='FMajor']", "#StudentInit form"),
        Transfer: $("input[name='FTransfer']", "#StudentInit form"),
    };

    var isFirstStudent = function () {
        $.ajax({
            url: "Ajax/student_isFirstLogin.php",
            method: "GET",
            dataType: "JSON",
            contentType: "application/json; charset=UTF-8",
            success: function (obj) {
                if (obj.First) {
                    $('#StudentInit').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $.each(obj.Advisers, function (ind, obj) {
                        InitForm.Adviser.append("<option value='" + obj.Id + "'>" + obj.Name.First + " " + obj.Name.Last + "</option>");
                    });
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
            }

        });

    };
    addCourses.click(function (e) {
        if (selectedRows.length < 1) {
            document.getElementById("alerts2a").innerHTML = "<div class='alert alert-danger alert-dismissable'> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> No course(s) selected!</div>";
            return;
        }
        $.ajax({
            url: "Ajax/student_add_course.php",
            method: "POST",
            dataType: "JSON",
            contentType: "application/json; charset=UTF-8",
            data: JSON.stringify(selectedRows),
            success: function (obj) {
                displayOutput(obj, "alerts2a", "added");
            },
            error: function (jqXHR, textStatus, errorThrown) {
            }
        });
    });
    removeCourses.click(function (e) {
        if (selectedRows.length < 1) { document.getElementById("alerts3a").innerHTML = "<div class='alert alert-danger alert-dismissable'> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> No courses selected!</div>"; return };
        $.ajax({
            url: "Ajax/student_remove_course.php",
            method: "POST",
            dataType: "JSON",
            contentType: "application/json; charset=UTF-8",
            data: JSON.stringify(selectedRows),
            success: function (obj) {
                displayOutput(obj, "alerts3a", "removed ");
                viewCourses();

            },
            error: function (jqXHR, textStatus, errorThrown) {
            }
        });
    });
    var rowClick = function (tr) {
        $(tr).click(function (e) {
            var indexElement;
            if (!e.currentTarget.classList.contains("selected")) {
                e.currentTarget.classList.add("selected");
                lookupSelectedRows.push(e.currentTarget.dataset.id);
                selectedRows.push({ Id: e.currentTarget.dataset.id, Year: e.currentTarget.dataset.year, Semester: e.currentTarget.dataset.semester });
            }
            else {
                e.currentTarget.classList.remove("selected");
                indexElement = lookupSelectedRows.indexOf(e.currentTarget.dataset.id);
                lookupSelectedRows.splice(indexElement, 1);
                selectedRows.splice(indexElement, 1);
            }
        });
    };
    var searchCourses = function (obj) {
        var request = request || {};
        if (obj.Year) request.Year = parseInt(obj.Year);
        if (obj.Semester) request.Semester = obj.Semester;
        $.ajax({
            url: "Ajax/search.php",
            method: "GET",
            dataType: "JSON",
            contentType: "application/json; charset=UTF-8",
            data: request,
            success: function (obj) {
                var htmlText = '';
                $.each(obj, function (i, element) {
                    htmlText += '<tr data-id="' + element.Id + '" data-year="' + element.Year + '" data-semester="' + element.Semester + '" ><td>' +
                        element.Department.Abbreviation + '-' + element.Number + '</td><td>' +
                        element.Name + '</td><td>' +
                        element.Year + element.Semester + '</td><td><span class="btn btn-secondary icon icon-moon"></span><span class="btn btn-secondary icon icon-sun"></span></td></tr>'
                });
                offeringsTbody.html(htmlText);
                selectedRows = [];
                lookupSelectedRows = [];
                rowClickBtn("table#select > tbody > tr span.btn.icon-sun", "table#select > tbody > tr span.btn.icon-moon");
                loadSearch('table#select');
                $("table#select > tbody").pageMe({ pagerSelector: '#selectPager' });
            },
            error: function (jqXHR, textStatus, errorThrown) {
            }
        });
    };
    var rowClickBtn = function (selectorSun, selectorMoon) {
        $(selectorSun).click(function (e) {
            var tr = e.currentTarget.parentNode.parentNode;
            var indexElement;
            if (!tr.classList.contains("selected")) {
                if (!e.currentTarget.classList.contains("yellow")) {
                    e.currentTarget.classList.add('yellow');
                    tr.classList.add("selected");
                    lookupSelectedRows.push(tr.dataset.id);
                    selectedRows.push({ Id: tr.dataset.id, Year: tr.dataset.year, Semester: tr.dataset.semester, Preference: false });
                }
            }
            else {
                indexElement = lookupSelectedRows.indexOf(tr.dataset.id);
                if (!e.currentTarget.classList.contains("yellow")) {
                    e.currentTarget.previousSibling.classList.remove('black');
                    selectedRows[indexElement].Preference = false;
                    console.log(selectedRows[indexElement]);
                    e.currentTarget.classList.add('yellow');

                }
                else {
                    e.currentTarget.classList.remove('yellow');
                    tr.classList.remove("selected");
                    lookupSelectedRows.splice(indexElement, 1);
                    selectedRows.splice(indexElement, 1);
                }

            }
        });
        $(selectorMoon).click(function (e) {
            var tr = e.currentTarget.parentNode.parentNode;
            var indexElement;
            if (!tr.classList.contains("selected")) {
                if (!e.currentTarget.classList.contains("black")) {
                    e.currentTarget.classList.add('black');
                    tr.classList.add("selected");
                    lookupSelectedRows.push(tr.dataset.id);
                    selectedRows.push({ Id: tr.dataset.id, Year: tr.dataset.year, Semester: tr.dataset.semester, Preference: true  });
                }
            }
            else {
                indexElement = lookupSelectedRows.indexOf(tr.dataset.id);
                if (!e.currentTarget.classList.contains("black")) {
                    console.log(e.currentTarget.nextSibling);
                    e.currentTarget.nextSibling.classList.remove('yellow');
                    selectedRows[indexElement].Preference = true;
                    e.currentTarget.classList.add('black');

                }
                else {
                    e.currentTarget.classList.remove('black');
                    tr.classList.remove("selected");
                    lookupSelectedRows.splice(indexElement, 1);
                    selectedRows.splice(indexElement, 1);
                }

            }

        });
    };
    var displayOutput = function (rtnArray, element, message) {
        var success = 0;
        var fail = 0;
        $.each(rtnArray, function (ind, ele) {
            if (ele) success++;
            else fail++;
        });
        document.getElementById(element).innerHTML = "<div class='alert alert-success alert-success'> <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>" + success + " course(s) " + message + " successfully. " + fail + " failed.</div>";
    };

    $("a[href='" + window.location.hash + "']", 'ul.nav.nav-pills').click();
    $("li > a", 'ul.nav.nav-pills').click(function (e) {
        window.location.hash = $(e.currentTarget).attr('href');
    });
    var clearArrays = function () {
        selectedRows = [];
        lookupSelectedRows = [];
    };
    var loadAction = function (hash) {
        switch (hash) {
            case "#3a":
                viewCourses();
                break;
        }
    };
    window.onhashchange = function () {
        clearArrays();
        loadAction(window.location.hash);
        $("tr").removeClass('selected');
        $("span.icon-moon").removeClass('black');
        $("span.icon-sun").removeClass('yellow');
        $("a[href='" + window.location.hash + "']", 'ul.nav.nav-pills').click();
    };
    loadAction(window.location.hash);

    $.get("Ajax/credits.php", function (data) {
        $("#credits_taken").append(data)
        $("#credits_remaining").append(120 - data)

    }, "json");
    isFirstStudent();
});
function myFunction() {
    location.reload();
}