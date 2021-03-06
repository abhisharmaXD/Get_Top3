<!DOCTYPE html>
<html>
  <head>
    
    <?php
        session_start();
        include 'head.php';
    ?>
    
  </head>
  <body>
    <div style="width:100vw; height:100vh;" class="d-flex justify-content-center align-items-center">
        <div class="card p-4">
    <form action="" method="POST">
    
    <div class="mb-4 text-center text-danger" >
        
    </div>

    <div class=" input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text bg-secondary"><i class="fa fa-lock fa-lg mr-2" aria-hidden="true" style="color:white"></i></span>
        </div> 
        <input type="text" name="oldpassword" class="form-control"  placeholder="Old password" required />
    </div>

    <div class=" input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text bg-secondary"><i class="fa fa-key fa-md mr-2" aria-hidden="true" style="color:white"></i></span>
        </div> 
        <input type="text" name="newpassword" class="form-control" pattern="^.*(?=.{8,})(?=.*[a-zA-Z])(?=.*\d).*$" oninvalid="setCustomValidity('Password must contain a digit and a special character')" onkeyup="setCustomValidity('')" placeholder="New password" required />
    </div>
    
    <div class=" input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text bg-secondary"><i class="fa fa-key fa-md mr-2" aria-hidden="true" style="color:white"></i></span>
        </div> 
        <input type="password" name="confirmpassword" class="form-control" pattern="^.*(?=.{8,})(?=.*[a-zA-Z])(?=.*\d).*$" oninvalid="setCustomValidity('Password must contain a digit and a special character')" onkeyup="setCustomValidity('')" placeholder="Confirm password" required />
    </div>
    
    
    <div> 
        <input name="submit" type="submit" value="CHANGE" style="border-radius: 16px;" class="btn btn-outline-info btn-block my-4">           
    </div>

</form>
        </div>
    </div>
  </body>
</html>

<?php
    if(isset($_POST['submit']))
    {
        $old_password = $_POST['oldpassword'];
        $new_password = $_POST['newpassword'];
        $confirm_password = $_POST['confirmpassword'];;

        require "dbconfig.php";

        $email = $_SESSION["email"];

        $stmt = $connect->prepare("SELECT * FROM registration WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_object();
        if($new_password==$confirm_password && $old_password==($user->password))
        {
            $sql= "UPDATE registration SET password='$new_password' WHERE email='$email'";
            if ($connect->query($sql) === TRUE) {
                echo "Password updated successfully.";
            } else {
                echo "Error: " . $sql . "<br>" . $connect->error;
            }
        }
        else if($new_password!=$confirm_password)
            echo "Please check your password";
        else
            echo "Your old password is incorrect!";
        
    }

?>