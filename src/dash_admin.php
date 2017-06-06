<div class="inside">
    <span onclick="myFunction()" class= "pull-right"><span class="glyphicon glyphicon-repeat"></span></span>
    <ul class="nav nav-pills">
        <li class="active">
            <a href="#1a" data-toggle="tab">Dashboard</a>
        </li>
        <li><a href="#2a" data-toggle="tab">Courses</a>
        </li>
        <li><a href="#3a" data-toggle="tab">Users</a>
        </li>
        <li><a href="#4a" data-toggle="tab">Forecasting</a>
        </li>
    </ul>
    <div class="tab-content clearfix">
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
        </div>
        <div class="tab-pane" id="2a">
            <h2>Course Offerings</h2>
            <div class= "row">

                <span class="pull-right"><input type="text" class="form-control search" name="q" placeholder="Search for">
                </span>
            </div>

            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#AddCourse">Add Course</button>
            <table id="tblAddCourse" class="searchTbl table table-bordered table-inverse" style="color:#FFFFFF;">
                <thead>
                    <tr>
                        <th>Number</th>
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody id="courses">

                </tbody>
            </table>
            <div class="col-md-12 text-center">
                <ul class="pagination pagination-lg" id="coursePager"></ul>
            </div>
        </div>
                <div class="tab-pane" id="3a">
            <h2>Users</h2>
            <div class= "row">
                <div class="pull-right">
                    <form action="#" method="get">
                        <div class="input-group">
                            <input type="text" class="form-control search" name="q" placeholder="Search for">
                            <span class="input-group input-group-sm">
                            </span>
                        </div>
                    </form>
                </div>
            </div>
            <table id="users" class="table table-bordered table-inverse" style="color:#FFFFFF;">
                <thead>
                    <tr>
                        <th></th>
                        <th>First</th>
                        <th>Last</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Role</th>
                    </tr></thead><tbody> 
                </tbody>
            </table>
            <div class="col-md-12 text-center">
                <ul class="pagination pagination-lg" id="userPager"></ul>
            </div>
        </div>
        <div class="tab-pane" id="4a">
            <h2> Forecasting</h2>

            <span class="pull-right" >
                <form action="#" method="get">
                    <div class="form-inline">

                        <select class="form-control" name="Term" required >
                            <option disabled selected value>Term</option>
                            <option value="2017S">2017S</option>
                            <option value="2017F">2017F</option>
                            <option value="2018S">2018S</option>
                            <option value="2018F">2018F</option>
                        </select>
                        <input type="number" class="form-control" name="thold" placeholder="Threshold">
                        <input type="text" class="form-control search" name="q" placeholder="Search for">
                        <span class="input-group input-group-sm">
                        </span>
                    </div>
                </form>
            </span>



            <table class="table table-bordered table-inverse" id="forecast" style="color:#FFFFFF;">
                <thead>
                    <tr>
                        <th width="20%">Course</th>
                        <th width="40%">Name</th>
                        <th width="20%">Possible Students</th>
                        <th width="30%">Predicted Sections</th>
                    </tr>
                </thead>
                <tbody id="courses_forecasting">
                </tbody>
            </table>

        </div></div> <div class="col-md-12 text-center">
        <ul class="pagination pagination-lg" id="forecastingPager"></ul>
    </div>
</div>
</div>

<div class="modal fade" id="changeProfileModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
                <p class="modal-title">Browse Image</p>
            </div>
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

<div class="modal fade" id="viewCourseModal" tabindex="-1" role="dialog" aria-labelledby="AddCourse" aria-hidden="true" dismissable>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Course Info</h2>
            </div>
            <form>
                <div class="form-group">
                    <label for="Course-num" class="form-control-label">Course Number:</label>
                    <input type="number" class="form-control" name="Course-num" required>
                </div>
                <div class="form-group">
                    <label for="Course-name" class="form-control-label">Course Name:</label>
                    <input type="text" class="form-control" name="Course-name" required>
                </div>
                <div class="form-group">
                    <label for="Course-Description" class="form-control-label">Course Description:</label>
                    <textarea  type="text" class="form-control uneditable-input" name="Course-Description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="Department" class="form-control-label">Department:</label>
                    <select  class="form-control uneditable-input" name="Department" required>
                        <option disabled selected value>Choose Department</option>
                        <option value="1">Computer Studies</option>
                        <option value="1">Computer Science</option>
                        <option value="2">Mathematics</option>
                        <option value="0">Elective</option>
                    </select>
                </div>
                <b>Course Offerings</b>
                <br/>
                <ul id="listOfferings" class='list-inline'>
                </ul>
                <div id="submit_courses" class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss='modal'>Cancel</button>
                    <button id="deleteCourse" type="button" class="btn btn-primary">Delete</button>
                    <button id="editCourse" type="button" class="btn btn-primary">Edit</button>
                    <button id="AddOffering" type="button" class="btn btn-primary">Add Offering</button>
                    <button id="submitSelection" class="btn btn-primary">Update</button>
                </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="addCourseOffering" tabindex="-1" role="dialog" aria-labelledby="addCourseOffering" aria-hidden="true" dismissable>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Course Offering</h2>
            </div>
            <form>
                <div class="form-group">
                    <label for="offeringYear" class="form-control-label">Year:</label>
                    <input type="number" class="form-control" name="coYear" required>
                </div>

                <div class="form-group">
                    <label for="offeringSemester" class="form-control-label">Semester:</label>
                    <select  class="form-control uneditable-input" name="coSemester" required>
                        <option disabled selected value>Semester</option>
                        <option value="S">Spring</option>
                        <option value="F">Fall</option>

                    </select>
                    <div id="submit_offering" class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>                        
                        <button id="submitOffering" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="RemoveCourses" tabindex="-1" role="dialog" aria-labelledby="AddCourse" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            </div>
            <form>
                Are you sure you want to delete this Course?
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button class="btn btn-primary">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Course button -->
<div class="modal fade" id="AddCourse" tabindex="-1" role="dialog" aria-labelledby="AddCourse" aria-hidden="true" dismissable>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add Course</h2>
            </div>
            <form>
                <div class="form-group">
                    <input placeholder="Course Number" type="number" class="form-control" name="Course-num" required>
                </div>
                <div class="form-group">
                    <input  placeholder="Course Name" type="text" class="form-control" name="Course-name" required>
                </div>
                <div class="form-group">
                    <textarea placeholder="Course Description"  type="text" class="form-control uneditable-input" name="Course-Description" required></textarea>
                </div>
                <div class="form-group">
                    <select class="form-control uneditable-input" name="Department" required>
                        <option disabled selected value>Choose Department</option>
                        <option value="1">Computer Studies</option>
                        <option value="1">Computer Science</option>
                        <option value="2">Mathematics</option>
                        <option value="0">Elective</option>
                    </select>
                </div> 
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="UserEdit" tabindex="-1" role="dialog" aria-labelledby="UserEdit" aria-hidden="true" dismissable>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Modify User</h2>
            </div>
            <form>
                <div class="form-group">
                    <input placeholder="Full Name" type="text" class="form-control" name="name" disabled>
                </div>
                <div class="form-group">
                    <input  placeholder="NetID" type="text" class="form-control" name="netid" disabled>
                </div>
                <div class="form-group">
                    <select class="form-control uneditable-input" name="role" required>
                        <option disabled value>Choose Role</option>
                        <option value="1">Student</option>
                        <option value="2">Advisor</option>
                        <option value="3">Admin</option>
                    </select>
                </div> 
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button id="update" class="btn btn-primary" data-dismiss="modal">Update</button>
                    <button id="userdelete" class="btn btn-primary" data-dismiss="modal">Delete User</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="js/course_manager_advisor.js" type="text/javascript" language="javascript"></script>
<script src="js/user_manager_admin.js" type="text/javascript" language="javascript"></script>
