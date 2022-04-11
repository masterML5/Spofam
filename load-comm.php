<?php
require_once "verification/controllerUserData.php"; 
include_once "verification/connection.php";
include "index.php";
$commentNewCount = $_POST['commentNewCount'];
function getComments($post_id)
{
  global $con;
  global $commentNewCount ;
  $i=0;
  $result_com = "SELECT * FROM comments AS ri INNER JOIN usertable AS ut ON ut.id = ri.user_id WHERE ri.post_id = '$post_id' ORDER BY ri.created_at + ri.commented_on DESC";
  $result_com1 = mysqli_query($con, $result_com);
  if(mysqli_num_rows($result_com1)>0){
    while($result_com2 = mysqli_fetch_assoc($result_com1)){
        ?>
        <div class="comment"> <b><?php echo $result_com2['name']; echo " "; echo $result_com2['surname']; ?></b> <?php echo $result_com2['msg']; ?> </div>
        <?php
        $i++;
        if($i == $commentNewCount) break;
    }
}
}
?>