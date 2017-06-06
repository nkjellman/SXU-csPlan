$(function () {
    $("a[href='" + window.location.hash + "']", 'ul.nav.nav-pills').click();
    var forecast_table = '';
    var disabled = false;
    var courses = courses || {};
    var FCcourses = FCcourses || {};
    var currentCourse;
    var approval_arr = [];

    var lookupSelectedRows = [];
    var selectedRows = [];
    var rowClickMulti = function (tr) {
        $(tr).click(function (e) {
            var indexElement;
            if (!e.currentTarget.classList.contains("selected")) {
                e.currentTarget.classList.add("selected");
                lookupSelectedRows.push(e.currentTarget.dataset.id);
                selectedRows.push({ Id: parseInt(e.currentTarget.dataset.cid), Year: parseInt(e.currentTarget.dataset.year), Semester: e.currentTarget.dataset.semester });
                console.log(selectedRows);
            }
            else {
                e.currentTarget.classList.remove("selected");
                indexElement = lookupSelectedRows.indexOf(e.currentTarget.dataset.id);
                lookupSelectedRows.splice(indexElement, 1);
                selectedRows.splice(indexElement, 1);
            }
        });
    };
    var courseModalElements = {
        Add: {
            Form: $("form", "#AddCourse"),
            Number: $("input[name='Course-num']", "#AddCourse form"),
            Name: $("input[name='Course-name']", "#AddCourse form"),
            Description: $("textarea[name='Course-Description']", "#AddCourse form"),
            Department: $("select[name='Department']", "#AddCourse form")

        },
        Number: $("input[name='Course-num']", "#viewCourseModal form"),
        Name: $("input[name='Course-name']", "#viewCourseModal form"),
        Description: $("textarea[name='Course-Description']", "#viewCourseModal form"),
        Department: $("select[name='Department']", "#viewCourseModal form"),
        Offerings: $("#listOfferings", "#viewCourseModal form"),
        Delete: {
            Button: $("button#deleteCourse", "#viewCourseModal form"),
            Form: $("form", "#RemoveCourses")
        },
        AddOffering: {
            Button: $("button#AddOffering", "#viewCourseModal form"),
            Year: $("input[name='coYear']", "#addCourseOffering form"),
            Semester: $("select[name='coSemester']", "#addCourseOffering form"),
            Form: $("form", "#addCourseOffering")
        },
        Submit: $("button#submitSelection", "#viewCourseModal form"),
        Edit: $("button#editCourse", "#viewCourseModal form"),
        Form: $("form", "#viewCourseModal"),
    };
    var accessCourseModal = function (access) {
        courseModalElements.Number.attr("disabled", access);
        courseModalElements.Name.attr("disabled", access);
        courseModalElements.Description.attr("disabled", access);
        courseModalElements.Department.attr("disabled", access);
        courseModalElements.Submit.attr("disabled", access);
        courseModalElements.AddOffering.Button.attr("disabled", access);
    };
    var populateCourseModal = function (course) {
        courseModalElements.Number.val(course.Number);
        courseModalElements.Name.val(course.Name);
        courseModalElements.Description.val(course.Description);
        courseModalElements.Department.val(course.Department.Id);
        return populateCourseModalOfferings(course);

    };
    var populateCourseModalOfferings = function (course) {
        var courseOfferingsBody = '';
        $.each(course.Offering, function (i, element) {
            courseOfferingsBody += '<li>' + element.Year + element.Semester + ' ' + '<b>' + element.Total + '</b></li>'
        });
        courseModalElements.Offerings.html(courseOfferingsBody);
        return course;
    }
    var populateCourseTable = function (courses) {
        var course_table = '';
        $.each(courses, function (i, element) {
            course_table += "<tr data-toggle='modal' data-target='#viewCourseModal' data-courseid='" + element.Id + "'><td>" + element.Department.Abbreviation + '-' + element.Number + "</td><td>" + element.Name + "</td></tr>";
        });
        $("#courses").html(course_table);
        rowClick("#courses > tr");
        $("table#tblAddCourse > tbody").pageMe({ pagerSelector: '#coursePager' });

    };
    var updateCourse = function (dataIn) {
        $.ajax({
            url: "Ajax/advisor_edit_course.php",
            method: "POST",
            dataType: "JSON",
            contentType: "application/json; charset=UTF-8",
            data: JSON.stringify(dataIn),
            success: function (obj) {
                courses[obj.Id].Number = obj.Number;
                courses[obj.Id].Name = obj.Name;
                courses[obj.Id].Description = obj.Description;
                courses[obj.Id].Department = obj.Department;
                populateCourseTable(courses);
            },
            error: function (jqXHR, textStatus, errorThrown) {
            }
        });
    };
    var addCourse = function (dataIn) {
        $.ajax({
            url: "Ajax/advisor_create_course.php",
            method: "POST",
            dataType: "JSON",
            contentType: "application/json; charset=UTF-8",
            data: JSON.stringify(dataIn),
            success: function (obj) {
                displayCourses();
                $("#AddCourse").modal('hide');

            },
            error: function (jqXHR, textStatus, errorThrown) {
            }
        });
    };
    var deleteCourse = function (dataId) {
        $.ajax({
            url: "Ajax/advisor_remove_course.php",
            method: "Post",
            dataType: "JSON",
            contentType: "application/json; charset=UTF-8",
            data: JSON.stringify({ Id: dataId }),
            success: function (obj) {
                delete courses[dataId];
                populateCourseTable(courses);
                $('#RemoveCourses, #viewCourseModal').modal('hide');
            },
            error: function (jqXHR, textStatus, errorThrown) {
            }
        });
    };
    var addCO = function (dataIn) {
        $.ajax({
            url: "Ajax/advisor_add_co.php",
            method: "Post",
            dataType: "JSON",
            contentType: "application/json; charset=UTF-8",
            data: JSON.stringify(dataIn),
            success: function (obj) {
                courses[dataIn.Id].Offering.push({ Year: dataIn.Year, Semester: dataIn.Semester, Total: 0 });
                populateCourseModalOfferings(courses[dataIn.Id]);
                $('#addCourseOffering').modal('hide');
            },
            error: function (jqXHR, textStatus, errorThrown) {
            }
        });
    };
    var rowClick = function (tr) {
        $(tr).click(function (e) {
            if (!e.currentTarget.classList.contains("selected")) {
                $("tr.selected").removeClass('selected');
                e.currentTarget.classList.add("selected");
            }
        });
    };
    var displayCourses = function () {
        $.ajax({
            url: "Ajax/search.php",
            method: "GET",
            dataType: "JSON",
            contentType: "application/json; charset=UTF-8",
            data: null,
            success: function (obj) {
                $.each(obj, function (i, element) {
                    var semester = [];
                    var term_string = element.Year + element.Semester;
                    if (!courses[element.Id])
                        courses[element.Id] = {
                            Id: element.Id,
                            Name: element.Name,
                            Number: element.Number,
                            Department: element.Department,
                            Credits: element.Credits,
                            Description: element.Description,
                            Offering: [{ Year: element.Year, Semester: element.Semester, Total: element.Total, Term: term_string }]
                        };
                    else courses[element.Id].Offering.push({ Year: element.Year, Semester: element.Semester, Total: element.Total, Term: term_string });
                });
                populateCourseTable(courses);
                loadSearch('table#tblAddCourse');
                $("table#tblAddCourse > tbody").pageMe({ pagerSelector: '#coursePager' });
            },
            error: function (jqXHR, textStatus, errorThrown) {
            }
        });
    };
    var displayFCCourses = function () {
        $.ajax({
            url: "Ajax/advisor_predict_courses.php",
            method: "GET",
            dataType: "JSON",
            contentType: "application/json; charset=UTF-8",
            data: null,
            success: function (obj) {
                var options = [];
                $.each(obj, function (i, element) {
                    var semester = [];
                    var term_string = element.Year + element.Semester;
                    if (!FCcourses[element.Id])
                        FCcourses[element.Id] = {
                            Id: element.Id,
                            Name: element.Name,
                            Number: element.Number,
                            Department: element.Department,
                            Offering: [{ Year: element.Year, Semester: element.Semester, Total: element.Total, Term: term_string }]
                    };
                    else FCcourses[element.Id].Offering.push({ Year: element.Year, Semester: element.Semester, Total: element.Total, Term: term_string });
                    if(options.indexOf(term_string) < 0) options.push(term_string);
            });
            options.sort(); 
            $.each(options, function(i,element) {
                $("select[name='Term']","#4a").append("<option value='" + element + "'>" + element + "</option>")
            })
            },
            error: function (jqXHR, textStatus, errorThrown) {
            }
        });
    };
    var approveCourses = function (approve, student) {
        $.ajax({
            url: "Ajax/advisor_approve_courses.php",
            method: "POST",
            dataType: "JSON",
            contentType: "application/json; charset=UTF-8",
            data: JSON.stringify({ Approve: approve, Student: student, Courses: selectedRows }),
            success: function (obj) {
            },
            error: function (jqXHR, textStatus, errorThrown) {
            }
        });
    };
    var populateStudentPendingCoursesTable = function (netId, courses) {
        $("#approval").empty();
        var approve_div = ' <table class="table table-bordered table-inverse" style="color:#FFFFFF;">' +
            ' <thead> <tr>  <th colspan="4">Students</th></tr> </thead> <tbody id="studentCourses" >';
        $.each(courses, function (i, ele) {
            approve_div += "<tr data-cid='" + ele.course_id + "'data-year='" + ele.year + "'data-semester='" + ele.semester + "'><td>" + ele.abbreviation + "-" + ele.course_num + "</td><td>" + ele.name + "</td><td>" + ele.year + ele.semester + "</td></tr> ";
        });
        approve_div += '</tbody></table></br><span class="pull-right"><button id="submitUnapprove" type="button" class="btn btn-primary">Unapprove</button></span><button id="submitApprove" type="button" class="btn btn-primary">Approve</button></span>'
        $("#approval").html(approve_div);
        $("button#submitApprove").click(function (e) {
            approveCourses(true, netId);
            getUnapprovedStudents();
        });
        $("button#submitUnapprove").click(function (e) {
            approveCourses(false, netId);
            getUnapprovedStudents();
        });
    };
    var getUnapprovedStudents = function (netId) {
        $.ajax({
            method: "POST",
            url: "Ajax/advisor_get_unapproved_selections.php",
            data: JSON.stringify({ net_id: netId }),
            success: function (obj) {
                populateStudentPendingCoursesTable(netId, obj);

                selectedRows = [];
                lookupSelectedRows = [];
                rowClickMulti("tbody#studentCourses > tr");
            }
        });
    };
    var getStudents = function (typeIn) {
        $.ajax({
            url: "Ajax/getAllStudentsUnderAdvisor.php",
            method: "GET",
            datatype: "JSON",
            data: { type: typeIn },
            contentType: "application/json; charset=UTF-8",
            success: function (obj) {
                var tblBody = '';
                $.each(obj, function (i, ele) {
                    tblBody += '<tr data-NetId = "' + ele.Id + '"> <td> <img src="' + ele.Image + '" height="42" width="42"><br/>' +
                        ele.Name.First + " " + ele.Name.Last + " <br/> " +
                        ele.Email + "<br/>"
                        + ele.Id + '</td> </tr>';
                });
                $("#approval").empty();
                $("#students").html(tblBody);
                rowClick("tbody#students >  tr");
                $("tbody#students > tr").click(function (e) {
                    getUnapprovedStudents(e.currentTarget.dataset.netid);
                });
            }
        });
    };
    var thold = 5,
        term = '';
            
    $('[name="Term"], [name="thold"]').bind('input', function () {
        forecast_table = '';
        thold = parseInt($('[name="thold"]').val()) || thold;
        term = $('[name="Term"]').val();
        forecastCourses(term, thold);
    });

    $("#viewCourseModal").on('show.bs.modal', function (e) {
        disabled = true;
        accessCourseModal(disabled);
        currentCourse = populateCourseModal(courses[e.relatedTarget.dataset.courseid]);
    });
    $("#AddCourse").on('show.bs.modal', function (e) {
        $("form", e.currentTarget)[0].reset();
    });
    courseModalElements.Add.Form.submit(function (e) {
        e.preventDefault();
        addCourse({
            Number: parseInt(courseModalElements.Add.Number.val()),
            Name: courseModalElements.Add.Name.val(),
            Description: courseModalElements.Add.Description.val(),
            Department: parseInt(courseModalElements.Add.Department.val())
        });
    });
    courseModalElements.Form.submit(function (e) {
        e.preventDefault();
        var newCourse = {
            Id: currentCourse.Id,
            Number: parseInt(courseModalElements.Number.val()),
            Name: courseModalElements.Name.val(),
            Description: courseModalElements.Description.val(),
            Department: parseInt(courseModalElements.Department.val()),
        }
        var isEquivalent = true;
        isEquivalent &= newCourse.Number == currentCourse.Number
            && newCourse.Name == currentCourse.Name
            && newCourse.Description == currentCourse.Description
            && newCourse.Department == currentCourse.Department.Id;
        if (!isEquivalent) {
            updateCourse(newCourse);
            populateCourseTable(courses);
        }
        $('#viewCourseModal').modal('hide');
    });
    courseModalElements.Edit.click(function (e) {
        disabled = !disabled;
        accessCourseModal(disabled);
    });
    courseModalElements.AddOffering.Button.click(function (e) {
        courseModalElements.AddOffering.Form[0].reset();
        $('#addCourseOffering').modal();
    });
    courseModalElements.AddOffering.Form.submit(function (e) {
        e.preventDefault();
        addCO({
            Id: currentCourse.Id,
            Year: parseInt(courseModalElements.AddOffering.Year.val()),
            Semester: courseModalElements.AddOffering.Semester.val()
        });
    });
    courseModalElements.Delete.Button.click(function (e) {
        $('#RemoveCourses').modal();
    });
    courseModalElements.Delete.Form.submit(function (e) {
        e.preventDefault();
        deleteCourse(currentCourse.Id);
    });
    $("#viewCourseModal").on('hide.bs.modal', function (e) { $('form', e.currentTarget)[0].reset() });
    $("li > a", 'ul.nav.nav-pills').click(function (e) {
        window.location.hash = $(e.currentTarget).attr('href');
    });

    window.onhashchange = function () {
        selectedRows = [];
        lookupSelectedRows = [];
        $("tr").removeClass('selected');
        $("a[href='" + window.location.hash + "']", 'ul.nav.nav-pills').click();
    };
    $("button#allStudents").click(function () { getStudents("All"); });
    $("button#pendingStudents").click(function () { getStudents("Pending"); });
    getStudents('All');
    displayCourses();
    displayFCCourses();
    function forecastCourses(term, threshold) {
        var count = 0;

        $.each(FCcourses, function (i, ele) {
            $.each(ele.Offering, function (i, element) {
                if (element.Term == term) {
                    forecast_table += "<tr><td>" + ele.Department.Abbreviation + "-"
                        + ele.Number + "</td><td>" + ele.Name + '</td><td><p>' + element.Total + '</p></td><td><div class="form-inline"><div class="col-md-3" id="sections"><p>' + Math.ceil(element.Total / threshold) + '</p></div><div class="col-md-1" ><form class="tholding"><input type="number" class="form-control" style="width: 90px;" name="thresholds" ></form></div></div></td></tr>';
                }
            });
        });
        $("#courses_forecasting").html(forecast_table);
        $("[name='thresholds']").val(threshold);
        $('[name="thresholds"]').bind('input', function (e) {
            var total = $(e.target).closest(":has(td p )").find('td p').html();
            var thresholds = e.target.value;
            $(e.target).closest(":has(div p)").find('div p').html(Math.ceil(total / thresholds));
        });
        loadSearch('table#forecast');
        $("table#forecast > tbody").pageMe({ pagerSelector: '#forecastingPager' });
    }
});
// var getUsers = function () {
//     $.ajax({
//         url: "Ajax/admin_get_all_accounts.php",
//         method: "GET",
//         datatype: "JSON",
//         contentType: "application/json; charset=UTF-8",
//         success: function (obj) {
//             var tblBody = '';
//             $.each(obj, function (i, ele) {
//                 tblBody += '<tr data-NetId = "' + ele.Id + '" data-toggle="modal" data-target="#UserEdit"> <td> <img src="' + ele.Image + '" height="42" width="42"> </td>' +
//                     "<td data-fname>" + ele.Name.First + "</td>" + "<td data-lname>" + ele.Name.Last + " </td>" +
//                     "<td>" + (ele.Email || "")  + "</td>"
//                     + "<td data-netid>" + ele.Id + "</td>" + "<td data-role>" + mapRole(ele.Type) + "</td></tr>";

//             });
//             $('table#users > tbody').html(tblBody);
//             loadSearch('table#users');
//             $("table#users > tbody").pageMe({ pagerSelector: '#userPager'});
//         }
//     });
// };
// function mapRole(roleId) {
//     switch (parseInt(roleId)) {
//         case 1:
//             return "Student";
//         case 2:
//             return "Advisor";
//         case 3:
//             return "Administrator";
//     }
// }

// function reverseRole(role) {
//     switch (role) {
//         case "Student":
//             return 1;
//         case "Advisor":
//             return 2;
//         case "Administrator":
//             return 3;
//     }
// }

// function updateRole() { //updates role, then updates proper row in table
//     $.ajax({
//         url: "Ajax/admin_update_role.php",
//         method: "POST",
//         datatype: "JSON",
//         contentType: "application/json; charset=UTF-8",
//         data: JSON.stringify({
//             netid : $("[name='netid']").attr("value"),
//             role : $("[name='role']").val()
//         }),
//         success: function() {
//              $('table#users > tbody').html("");
//              getUsers();
//         }
//     });
// }

// getUsers();

$( "#users tbody" ).on( "click", "tr", function() {
 // console.log( $( this ).find("[data-fname]").text() );
 $("[name='name']").attr("value", $(this).find("[data-fname]").text() + " " + $(this).find("[data-lname]").text());
 $("[name='netid']").attr("value", $(this).find("[data-netid]").text());
 $("[name='role']").val(reverseRole($(this).find("[data-role]").text()));
});


$("#update").click(function() {
    updateRole();
})

function myFunction() {
    location.reload();
}

// var weather = require('weather-js');
 
// // Options: 
// // search:     location name or zipcode 
// // degreeType: F or C 
 
// weather.find({search: 'Chicago , IL', degreeType: 'F'}, function(err, result) {
//   if(err) console.log(err);
 
//   console.log(JSON.stringify(result, null, 2));
// });

