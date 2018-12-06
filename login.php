<!doctype html>
<?php 
    require_once 'app/connection.php';
    $db_con = new connection();
    if(isset($_POST['submit'])){
    	$username = trim($_POST['username']);
    	$password =trim($_POST['password']);
	    $stmt = $db_con->db->prepare("SELECT * FROM user WHERE username ='".$username."' AND password ='".sha1($password)."'");
	    $stmt->execute();
	    if($stmt->rowCount() > 0){
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
			if($row['status']=="Inactive"){
				$message = "This account is no longer active. It has been deactivated by admin.";	
			}
			else {
				$_SESSION['user_id'] = $row['id'];
				$_SESSION['role'] = $row['role'];
				Header("Location:index.php");	
			} 
		}
		else{
			$message = "Wrong username or password combination";
		}
	}
?>
<html lang="en">
  <head>
    <title>Login</title>
    <!-- Required meta tags -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    
    <link rel="icon" type="image/png" href="img/favicon.png" />
    <!-- Bootstrap CSS -->
    <!--<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/b5bdd619d8.css"> 
    <link rel="stylesheet" type="text/css" href="css/styles.css" />
  </head>
  <body>
    <div class="container-fluid">
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
        <form id="formBox" action="login.php" method="post">
	      	<p class="p-3 mb-2 bg-dark text-white">Login</p>			
			<div class="form-group">
				<input type="text" placeholder="Username" id="username" name="username" class="form-control" required>
			</div>
			<div class="form-group">
				<input type="password" placeholder="Password" id="password" name="password" class="form-control" required>
			</div>
	        <input type="submit" name="submit" value="Login" class="btn btn-primary btn-block">
	        <div id="report" style="margin-top: 10px"><?php if(isset($message)) echo '<div class="p-3 mb-2 bg-danger text-white text-center">'.$message.'</div>'; ?></div>
  		</form>
        </div>
        <div class="col-sm-4"></div>
    </div>
    <div class="row">
          <div class="col-sm-4"></div>
          <footer class="col-sm-4">
              <p class="text-center">&copy;2018 Contact Manager | All Rights Reserved  </p>
          </footer>
          <div class="col-sm-4"></div>
    </div>
    </div>
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="js/jquery.js"></script>
    <!-- <script src="bootstrap/js/bootstrap.min.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
  </html>