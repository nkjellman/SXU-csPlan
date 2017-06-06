<?php include 'nav.php';?>
 <body><div id="particles-js"></div>
    <div class="container">
        <h1>Dashboard</h1>
    </div>
    <div id="tab" class="container">
        <?php
            require_once 'project.properties.php';
            require_once PROJECT_ROOT . 'PHP/Models/Enums/AccountType.enum.php';
            $pdo = $DI->Resolve("PDO");
            switch($DI->Resolve("IUserService")->GetUser($_SESSION['net_id'],  $pdo)->getType()) {
                case AccountType::Advisor:  
                    include 'dash_advisor.php';
                    break;
                case AccountType::Student:
                    include 'dash_student.php';
                    break;
                case AccountType::Admin:
                    include 'dash_admin.php';
                    break;
                    default: break;
            }
        ?>
        </div>
       
    </body>
</html>
        <script src="js/lib/particles.js"></script>
        <script src="js/lib/particle_config.js"></script>