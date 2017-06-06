<?php
include 'nav.php'; ?>
<div class="container profileDiv">
    <div id="profileImage" class="img-thumbnail " alt="Profile Image">
        <div class="btn-group-xs">
            <button id="openDialog" class="btn btn-hypot" data-toggle="modal" data-target="#changeProfileModal">Change</button>
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
    <div id="profileTextDiv">
    </div>
</div>
</body>
<script src="js/profile.js" type="text/javascript" language="javascript"></script>

</html>