<div class="inside">
    <span onclick="myFunction()" class= "pull-right"><span class="glyphicon glyphicon-repeat"></span></span>
    <ul class="nav nav-pills">
        <li class="active">
            <a href="#1a" data-toggle="tab">Profile</a>
        </li>
        <li><a href="#2a" data-toggle="tab">Course Offerings</a>
        </li>
        <li><a href="#3a" data-toggle="tab">My Selections</a>
        </li>
    </ul>
    <div id="CourseManager" class="tab-content clearfix">
        <div class="tab-pane active" id="1a">
            <h2> Profile</h2>
            <div class="container profileDiv">
                <div id="profileImage" class="img-thumbnail " alt="Profile Image">
                    <div class="btn-group-xs">
                        <button id="openDialog" class="btn btn-hypot" data-toggle="modal" data-target="#changeProfileModal">Change</button>
                    </div>
                </div>
                <div id="profileTextDiv">
                </div>
            </div>
            <h2>Dashboard</h2>
            <div class="col-md-offset-2">  <div class="col-md-4">
                    <div class="alert dboard">
                        <div class="panel-body">
                            <p id="dhead1">Credit Hours Taken</p>
                            <h2 id="credits_taken"> </h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="alert dboard">
                        <div class="panel-body">
                            <p id="dhead1">Credit Hours Remaining</p>
                            <h2 id="credits_remaining"></h2>
                        </div>
                    </div>
                </div></div>
            <!--<h2>Courses Taken</h2>
            <p>See the courses you were previously or currently enrolled in by semester.</p>
            <p>Click on a semester in the menu below to show avalible courses for that semester.</p>
    
            <table class="table table-bordered table-inverse" style="color:#FFFFFF;">
                <thead>
                    <tr>
                        <th>Course ID</th>
                        <th>Course Name</th>
                        <th>Semeseter Taken</th>
                        <th>Credits</th>
                    </tr>
                </thead>
                <tbody id="my_classes">
    
    
                </tbody>
            </table>-->
        </div>
        <div class="tab-pane" id="2a">
            <h2>Course Offerings</h2>
            <div class= "row">
                <span class= "pull-right">
                    <input type="text" class="form-control search" name="q" placeholder="Search for">
                    <span class="input-group input-group-sm">
                    </span>
                </span>
            </div>
            <div id="alerts2a"></div>
            <span class="pull-right"><p><h4><b>Select your preference of day or night by clicking the sun or moon</b></h4></p></span>
            <div class="dropdown">
                <button id="ChooseSemester" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Select Semester
                    <span class="caret"></span> 
                </button>
                <ul id="SemesterOptions" class="dropdown-menu">
                    <li><a data-value="F" data-target="ChooseSemester" data-toggle="collapse" href="#">Fall</a>
                    </li>
                    <li><a data-value="S" data-target="ChooseSemester" data-toggle="collapse" href="#">Spring</a>
                    </li>
                </ul>
                <span id="AddCourses" class="btn btn-primary"> Add </span>
            </div>

            <table id="select" class="searchTbl table table-bordered table-inverse" style="color:#FFFFFF;">
                <thead>
                    <tr>
                        <th>Number</th>
                        <th>Name</th>
                        <th>Year</th>
                        <th>Preference </th>
                    </tr>
                </thead>
                <tbody id="offered_courses">
                </tbody>
            </table>
            <div class="col-md-12 text-center">
                <ul class="pagination pagination-lg" id="selectPager"></ul>
            </div>
        </div>
        <div class="tab-pane" id="3a">
            <h3>Course Selections</h3>
            <div id="alerts3a"></div>
            <div class="dropdown">
                <span id="RemoveCourses" class="btn btn-primary"> Remove </span>
            </div>
            <table id="selected" class="table table-bordered table-inverse" style="color:#FFFFFF;">
                <thead>
                    <tr>
                        <th>Number</th>
                        <th>Name</th>
                        <th>Year</th>
                        <th>Approved</th>
                    </tr>
                </thead>
                <tbody id="selected_courses">
                </tbody>
            </table>
            <div class="col-md-12 text-center">
                <ul class="pagination pagination-lg" id="selectedPager"></ul>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="StudentInit" tabindex="-1" role="dialog" aria-labelledby="Student Init" aria-hidden="true" dismissable>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <b> First Time Use</b>
            </div>
            <form>
                <div class="form-group">
                    <select class="form-control uneditable-input" name="Adviser" required>
                        <option disabled selected value>Choose Adviser</option>
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control uneditable-input" name="FMajor" required>
                        <option disabled selected value>Choose Major</option>
                        <option value="1">Computer Studies</option>
                        <option value="2">Computer Science</option>
                    </select>
                </div> 
                <div class="form-group">
                    <input placeholder="Enrollment Year" type="number" class="form-control" name="FYear" required>
                </div>
                <div class="form-group">
                    <label>
                        <input name="FTransfer" type="checkbox"/> Transfer
                    </label>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- The user will be able to change their profile image by clicking this button that opens a modal. -->
<!-- This modal opens up, providing a form for the user to enter the url of the image they want. -->
<div class="modal fade" id="changeProfileModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Header for the modal. -->
            <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
                <p class="modal-title">Browse Image</p>
            </div>
            <!-- Body content for the modal. -->
            <div id="ImageInputContainer" class="modal-body">
                <img />
                <form id="profileImageForm">
                    <input type="file" accept="image/*" required>
                    <button class="btn btn-primary"> Upload </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="js/course_manager_student.js" type="text/javascript" language="javascript"></script>


