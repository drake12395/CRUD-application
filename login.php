<?php 
	
	session_start();
	
	# include connection data and functions
	require 'database.php';
	
	# if there was data passed, then verify password, 
	# otherwise do nothing (that is, just display html for login)
	if ( !empty($_POST)) {
		// keep track validation errors
		$nameError = null;
		$passwordError = null;
		
		// keep track post values
		$name = $_POST['name'];
		$pword = $_POST['pword'];
		
		
		
		// validate input
		$valid = true;
		if (empty($name)) {
			$nameError = 'Please enter user name';
			$valid = false;
		}
		
		if (empty($pword)) {
			$passwordError = 'Please enter password';
			$valid = false;
		} 
		
		// verify that password is correct for user name
		if ($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT * FROM newUsers WHERE name = ? LIMIT 1";
			$q = $pdo->prepare($sql);
			$q->execute(array($name));
			$results = $q->fetch(PDO::FETCH_ASSOC);
			if($results['pword']==$pword) {
				$_SESSION['name'] = $name;
				Database::disconnect();
				header("Location: success.php"); // redirect
			}
			else {
				$passwordError = 'login information is not valid';
				Database::disconnect();
			}
		}
	} # end if ( !empty($_POST))
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    
    			<div class="span10 offset1">
    				<div class="row">
		    			<h3>Login</h3>
		    		</div>
    		
	    			<form class="form-horizontal" action="login.php" method="post">
					
					  <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
					    <label class="control-label">User Name</label>
					    <div class="controls">
					      	<input name="name" type="text"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
					      	<?php if (!empty($nameError)): ?>
					      		<span class="help-inline"><?php echo $nameError;?></span>
					      	<?php endif; ?>
					    </div>
					  </div>
					  
					  <div class="control-group <?php echo !empty($passwordError)?'error':'';?>">
					    <label class="control-label">Password</label>
					    <div class="controls">
					      	<input name="password" type="password" placeholder="password Address" value="<?php echo !empty($pword)?$pword:'';?>">
					      	<?php if (!empty($passwordError)): ?>
					      		<span class="help-inline"><?php echo $passwordError;?></span>
					      	<?php endif;?>
					    </div>
					  </div>
					  
					  <div class="form-actions">
						  <button type="submit" class="btn btn-success">login</button>
						  <a class="btn" href="index.php">Back</a>
						  <a href="logout.php"> Log out </a>
						</div>
						
					</form>
					
				</div>
				
    </div> <!-- /container -->
	<br></br>
	
	Click <a href="register.php">here</a> to register.

  </body>
</html>