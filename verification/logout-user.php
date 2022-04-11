
<?php
    session_start();
    if(isset($_SESSION['unique_id'])){
        include_once "connection.php";
            
            $status_chat = "Offline now";
            $sql = mysqli_query($con, "UPDATE usertable SET status_chat = '{$status_chat}' WHERE unique_id='{$_SESSION['unique_id']}'");
            if($sql){
                session_unset();
                session_destroy();
                header("location: login-user.php");
            
        }else{
            header("location: ../chatapp/users.php");
        }
    }else{  
        header("location: login-user.php");
    }
?>