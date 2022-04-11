<?php
include "verification/connection.php";

$post_id = 1;
$result_q = "SELECT * FROM usertable AS ut INNER JOIN rating_info AS ri ON ri.user_id = ut.id WHERE ri.post_id = '$post_id' AND ri.rating_action='like'";
$result_s = mysqli_query($con, $result_q);
if(mysqli_num_rows($result_s)>0){
    while($result_p = mysqli_fetch_assoc($result_s)){
        ?>
        <img src="chatapp/php/images/<?php echo $result_p['img']; ?>" alt="">
    <?php
    }
}



?>  