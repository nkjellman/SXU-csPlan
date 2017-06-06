<?php
session_start();
if (isset($_SESSION['id']) ? $_SESSION['id'] == session_id() : false) {
    header('location: dash.php');
}
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Login Page</title>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="css/sxu.css" rel="stylesheet"/>
      <link href="css/bootstrap.css" rel="stylesheet"/>
      <script src="js/lib/jquery-3.1.1.js"></script>
      <script src="js/lib/bootstrap.js"></script>
      <script src="js/login.js"></script>
   </head>
   <body>
     <div class="container">
	<div id="login-box">
		<form>			
			<h1 class="login_caption">Login</h1>
            <p class="error"></p>
		<div class="controls">
		
            <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
            <input type="password"  name="password" class="form-control" placeholder="Password" required>
            <button class="btn btn-default btn-block btn-custom" type="submit">
            Sign In
            </button>
		</div><!-- /.controls -->
    </form>
	</div><!-- /#login-box -->
</div><!-- /.container -->
<div id="particles-js"></div>

   </body>
</html>
        <script src="js/lib/particles.js"></script>
        <script src="js/lib/particle_config.js"></script>
        