<html>
    <head>
        <script src="js/lib/jquery-3.1.1.js"></script>
        <script src="js/lib/bootstrap.js"></script>
        <script src="js/lib/particles.js"></script>
        <script src="js/lib/particle_config.js"></script>
        <script src="js/pagination.js" type="text/javascript" language="javascript"></script>
        <script src="js/search.js" type="text/javascript" language="javascript"></script>
        <script src="js/profile.js" type="text/javascript" language="javascript"></script>
        <script src="js/logout.js" type="text/javascript" language="javascript"></script><link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">


        <link href="css/bootstrap.css" rel="stylesheet"/>
        <link href="css/sxu.css" rel="stylesheet"/>
        <title>SXU ISE</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
  

    <nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">SXU I.S.E</a>
    </div>
    <ul class="nav navbar-nav">
        <?php
            require_once 'project.properties.php';
            require_once PROJECT_ROOT . 'PHP/Models/Enums/AccountType.enum.php';
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            if (isset($_SESSION['id']) ? $_SESSION['id'] != session_id() : true) {
                header('location:index.php');
            }
            $pdo = $DI->Resolve("PDO");
            switch ($DI->Resolve("IUserService")->GetUser($_SESSION['net_id'], $pdo)->getType()) {
                case AccountType::Advisor:
                    include 'nav_advisor.php';
                break;
                case AccountType::Student:
                    include 'nav_student.php';
                break;
                default:
                break;
            }
        ?>     
     
    </ul>
    <span class="pull-right" ><div class="logout"><a id="logout" href="#" class="btn btn-primary">Logout</a></div></span>
  </div>
  
</nav>
