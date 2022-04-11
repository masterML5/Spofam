<?php   
include_once "index.php";
include "verification/connection.php";

if(isset($_POST['add_comment']))
{


    $msg = $_POST['msg'];
    $user_id1 = $user_id;
    $post_id = $_POST['post_id'];

    $comment_add_query = "INSERT INTO comments (user_id, msg,post_id) VALUES ('$user_id1','$msg','$post_id')";
    $comment_add_query_run = mysqli_query($con, $comment_add_query);

    if($comment_add_query_run)
    {
        echo "succes";
    }
    else{
        echo "x";
    }

}



?>