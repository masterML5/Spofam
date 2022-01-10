<?php require_once "controllerUserData.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Signup Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form">
                <form action="signup-user.php" method="POST" autocomplete="">
                    <h2 class="text-center">Signup Form</h2>
                    <p class="text-center">It's quick and easy.</p>
                    <?php
                    if(count($errors) == 1){
                        ?>
                        <div class="alert alert-danger text-center">
                            <?php
                            foreach($errors as $showerror){
                                echo $showerror;
                            }
                            ?>
                        </div>
                        <?php
                    }elseif(count($errors) > 1){
                        ?>
                        <div class="alert alert-danger">
                            <?php
                            foreach($errors as $showerror){
                                ?>
                                <li><?php echo $showerror; ?></li>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="form-group">
                        <input class="form-control" type="text" name="username" placeholder="Username" required value="<?php echo $username ?>">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="email" name="email" placeholder="Email Address" required value="<?php echo $email ?>">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="text" name="name" placeholder="Name" required value="<?php echo $name ?>">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="text" name="surname" placeholder="Surname" required value="<?php echo $surname ?>">
                    </div>
                    <div class="form-group">
                        
                        <input class="form-control" type="password" id="password" name="password" placeholder="Password" required>
                               
                    </div>
                    <div id="showpass">
                    <input type="checkbox" id="showPassword" />
					<label for="showPassword">Show password</label>
                    </div>
                    <div class="form-group">
                        <input class="form-control pwd" type="password" id="cpassword" name="cpassword" placeholder="Confirm password" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control button" type="submit" name="signup" value="Signup">
                    </div>
                    <div class="link login-link text-center">Already a member? <a href="login-user.php">Login here</a></div>
                </form>
            </div>
        </div>
    </div>
	<script>
document.getElementById('showPassword').onclick = function() {
    if ( this.checked ) {
       document.getElementById('password').type = "text";
	   document.getElementById('cpassword').type = "text";
    } else {
       document.getElementById('password').type = "password";
	   document.getElementById('cpassword').type = "password";
    }
};
</script>
</body>
</html>