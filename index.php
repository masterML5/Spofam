
<?php 
require_once "verification/controllerUserData.php"; 
include_once "verification/connection.php";
?>

<?php 

$img1 = "";
$name = "";
$username = "";
$email = $_SESSION['email'];
$password = $_SESSION['password'];
if($email != false && $password != false){
    $sql = "SELECT * FROM usertable WHERE email = '$email'";
    $run_Sql = mysqli_query($con, $sql);
    if($run_Sql){
        $fetch_info = mysqli_fetch_assoc($run_Sql);
        $img1 = $fetch_info['img'];
        $user_id = $fetch_info['id'];
        $name = $fetch_info['name'];
        $username = $fetch_info['username'];
        $status = $fetch_info['status'];
        $code = $fetch_info['code'];
        if($status == "verified"){
            
            if($code != 0){
                header('Location: verification/reset-code.php');
            }
        }else{
            header('Location: verification/user-otp.php');
        }
    }
}else{
    header('Location: verification/login-user.php');
}
?>
<?php

if (isset($_POST['action'])) {
    $post_id = $_POST['post_id'];
    $action = $_POST['action'];
    switch ($action) {
        case 'like':
           $sql="INSERT INTO rating_info (user_id, post_id,  rating_action) 
                  VALUES ($user_id, $post_id, 'like') 
                  ON DUPLICATE KEY UPDATE rating_action='like'";
           break;
        case 'unlike':
            $sql="DELETE FROM rating_info WHERE user_id=$user_id AND post_id=$post_id";
            break;
       
        default:
            break;
    }
 
    
    // execute query to effect changes in the database ...
    mysqli_query($con, $sql);
    echo getRating($post_id);
  
    exit(0);
  }

if (isset($_POST['commentNewCount'])){
    $commentNewCount = $_POST['commentNewCount'];
}
 
  function getLikes($id)
  {
    global $con;
    $sql = "SELECT COUNT(*) FROM rating_info 
              WHERE post_id = $id AND rating_action='like'";
    $rs = mysqli_query($con, $sql);
    $result = mysqli_fetch_array($rs);
    return $result[0];
  }


function getRating($id)
{
  global $con;
  $rating = array();
  $likes_query = "SELECT COUNT(*) FROM rating_info WHERE post_id = $id AND rating_action='like'";
  $likes_rs = mysqli_query($con, $likes_query);
  
  $likes = mysqli_fetch_array($likes_rs);
 
  $rating = [
  	'likes' => $likes[0]
   ];
  return json_encode($rating);
  
}



function pictureLiked($post_id)
{
  global $con;
  $i=0;
  $result_q = "SELECT * FROM usertable AS ut INNER JOIN rating_info AS ri ON ri.user_id = ut.id WHERE ri.post_id = '$post_id' AND ri.rating_action='like'";
  $result_s = mysqli_query($con, $result_q);
  if(mysqli_num_rows($result_s)>0){
    while($result_p = mysqli_fetch_assoc($result_s)){
        ?>
        <span><img src="chatapp/php/images/<?php echo $result_p['img']; ?>" alt=""></span>
    <?php
    $i++;
    if($i == 3) break;
    }
}
}

function getComments($post_id)
{
  global $con;
  global $commentNewCount;
  $j=2;
  $i=0;
  $result_com = "SELECT * FROM comments AS ri INNER JOIN usertable AS ut ON ut.id = ri.user_id WHERE ri.post_id = '$post_id' ORDER BY ri.created_at + ri.commented_on DESC";
  $result_com1 = mysqli_query($con, $result_com);
  if(mysqli_num_rows($result_com1)>0){
    while($result_com2 = mysqli_fetch_assoc($result_com1)){
        ?>
        <div class="comment"> <b><?php echo $result_com2['name']; echo " "; echo $result_com2['surname']; ?></b> <?php echo $result_com2['msg']; ?> </div>
        <?php
        $i++;
        if($i == $j) break;
    }
}
}




function userLiked($post_id)
{
  global $con;
  global $user_id;
  $sql = "SELECT * FROM rating_info WHERE user_id=$user_id 
  		  AND post_id=$post_id AND rating_action='like'";
  $result = mysqli_query($con, $sql);
  if (mysqli_num_rows($result) > 0) {
  	return true;
  }else{
  	return false;
  }
}
$sqlpost = "SELECT * FROM posts";
$resultpost = mysqli_query($con, $sqlpost);
$posts = mysqli_fetch_all($resultpost, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spofam - Find your sport buddy</title>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.6/css/unicons.css">
    <link rel="stylesheet" href="style2.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
  
    

    
</head>

<body>
     <!-----------------NAV---------------------->
     
    <nav>
    <div class="container">
        <h2 class="log">
            Spofam
        </h2> 
        
        <div class="search-bar">
            <i class="uil uil-search"></i>
            <input type="search" placeholder="Pronađi svog prijatelja">

        </div>
         <div class="create">
             <label class="btn btn-primary" for="create-post">Create</label>
        
       
             <a href="verification/logout-user.php">Logout</a>
         </div>
    </div>

    </nav>
    <!-----------------MAIN--------------------->
<main>
    <div class="container">
        <div class="left">
            <a href="profile.php?user=<?php echo $username ?>" class="profile">
                <div class="profile-picture">
                 <?php if ( $img1 === "" ) : ?> 
                 <img src="chatapp/php/images/profile.png ?>" alt="">
          
        
                  <?php else :  ?>
                 <img src="chatapp/php/images/<?php echo $img1; ?>" alt="">
                 <?php endif; ?> 
                </div>
                <div class="handle">
                <?php echo $fetch_info['name'] . " ". $fetch_info['surname'] ?>
                    <p class="text-muted">
                        @<?php echo $fetch_info['username'] ?>
                    </p>

                </div>
            </a>
            <!-- sidebar -->
                <div class="sidebar">
                
                    <a href="#" class="menu-item active">
                        <spam><i class="uil uil-home"></i></spam><h3>Home</h3>
                    </a>
                    <a href="#" class="menu-item">
                        <spam><i class="uil uil-compass"></i></spam><h3>Explore</h3>
                    </a>
                    <a href="#" class="menu-item" id="notifications">
                        <spam><i class="uil uil-bell"><small class="notifications-count">9+</small></i></spam><h3>Notifications</h3>
                        <!-- POP-UP -->
                        <div class="notifications-popup">
                            <div>
                                <div class="profile-picture">
                                    <img src="images/profile2.png" alt="profile-notification">
                                </div>
                                <div class="notification-body">
                                    <b>Ime Prezime za not</b> tekst koji ide o obavesti
                                    <small class="text-muted">vreme</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-picture">
                                    <img src="images/profile2.png" alt="profile-notification">
                                </div>
                                <div class="notification-body">
                                    <b>Ime Prezime za not</b> tekst koji ide o obavesti
                                    <small class="text-muted">vreme</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-picture">
                                    <img src="images/profile2.png" alt="profile-notification">
                                </div>
                                <div class="notification-body">
                                    <b>Ime Prezime za not</b> tekst koji ide o obavesti
                                    <small class="text-muted">vreme</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-picture">
                                    <img src="images/profile2.png" alt="profile-notification">
                                </div>
                                <div class="notification-body">
                                    <b>Ime Prezime za not</b> tekst koji ide o obavesti
                                    <small class="text-muted">vreme</small>
                                </div>
                            </div>
                            <div>
                                <div class="profile-picture">
                                    <img src="images/profile2.png" alt="profile-notification">
                                </div>
                                <div class="notification-body">
                                    <b>Ime Prezime za not</b> tekst koji ide o obavesti
                                    <small class="text-muted">vreme</small>
                                </div>
                            </div>
                        </div>
                            </a>
                            <a href="#" class="menu-item"  id="messeages-notifications">
                            <spam><i class="uil uil-envelope-alt"><small class="notifications-count">5</small></i></spam><h3>Messages</h3>
                             </a>
                             <a href="#" id="theme" class="menu-item">
                             <spam><i class="uil uil-palette"></i></spam><h3>Theme</h3>
                             </a> 
                             <a href="#" class="menu-item">
                            <spam><i class="uil uil-user"></i></spam><h3>Profile</h3>
                                </a>
                                <a href="#" class="menu-item">
                                 <spam><i class="uil uil-setting"></i></spam><h3>Settings</h3>
                                </a>
                    </div>
                <!-- sidebar end -->
            <label  id="create-post-hover" for="create-post" class="btn btn-primary">Create Post</label>
        </div>
        
    <div class="middle">
            <!-- STORIES -->
        
        <div class="stories">
        <img src="images/story-1.jpg" alt="">
            <!-- <div class="story">

                <div class="profile-picture">
                    <img src="images/profile.png">
                </div>
                <p class="name">Your Story</p>
                </div>
            <div class="story">

                <div class="profile-picture">
                    <img src="images/profile2.png" alt="">
                </div>
                <p class="name">Second Story</p>
            </div>
            <div class="story">

                <div class="profile-picture">
                    <img src="images/profile3.png" alt="">
                </div>
                <p class="name">Third Story</p>
            </div>
            <div class="story">

                <div class="profile-picture">
                    <img src="images/profile4.png" alt="">
                </div>
                <p class="name">Fourth Story</p>
            </div>
            <div class="story">

                <div class="profile-picture">
                    <img src="images/profile5.png" alt="">
                </div>
                <p class="name">Fifth Story</p>
            </div> -->

        </div>
        <!-- story end -->

        <form id="form-hover" action="#" class="create-post">
            <div class="profile-picture">
                <?php if ( $img1 === "" ) : ?> 
                 <img src="chatapp/php/images/profile.png ?>" alt="">
          
        
                  <?php else :  ?>
                 <img src="chatapp/php/images/<?php echo $img1; ?>" alt="">
                 <?php endif; ?> 
            </div>
                <input type="text" placeholder="What's on your mind, <?php echo $name ?>?" id="create-post">
                <input type="submit" value="post" class="btn btn-primary">
        </form>
        
        <!-- feed -->
        <div class="feeds">
            <!-- feed-1 -->
            <?php foreach ($posts as $post): ?>
            <div class="feed">
                <div class="head">
                    <div class="user">
                        <div class="profile-picture">
                            <img src="images/profile.png" alt="profilna">
                        </div>
                        <div class="info">
                            <h3>Ime Prezime</h3>
                            <small>Location, time</small>
                        </div>
                        
                    </div>
                    <span class="edit"><i class="uil uil-ellipsis-h"></i></span>
                </div>
                <div class="photo">
                    <img src="images/feed-1.jpg" alt="feed">
                </div>
                <div class="action-button">
                <div class="interaction-buttons">
                        <span>
                            
                            <i  <?php if (userLiked($post['id'])): ?>
      		                 class="bi bi-heart-fill like-btn"
                             <?php else: ?>
      		                 class="bi bi-heart like-btn"
      	                     <?php endif ?>
                                 data-id="<?php echo $post['id'] ?>"></i>
                        </span>
                        <span>
                            <i class="bi bi-chat comment-btn" data-id="<?php echo $post['id'] ?>"></i>
                        </span>
                        <span>
                            <i class="bi bi-share"></i>
                        </span>
                        
                        
                        
                    </div>
                    <div class="bookmark">
                        <span><i class="uil uil-bookmark-full"></i></span>
                    </div>
                </div>
                    <div class="liked-by">
                    <?php
            
                     pictureLiked($post['id']);
                        ?>

                  
                       
                        <p>Liked by <b class="likes"><?php echo getLikes($post['id']); ?></b> users</p>
                    </div>
                    <div class="caption">
                        <p><b>Ime Prezime</b> <?php echo $post['text'] ?> <span class="hash-tag">#hashtag</span>  </p>
                    </div>
                    <div id="komentari">
                    <?php
                            
                         getComments($post['id']);
                         
                    ?>
                    
                    </div>
                    <div class="comments" >
                                    <?php $user_id = $fetch_info['id'];
                                   
                                    $post_id = $post['id']; 
                                    ?>
                                <form target="frame" class="create-post com-post" data="<?php echo $post['id'] ?>" id="com-post" method="POST" autocomplete="">
                                <input  type="text" class="comment-textbox" id="<?php echo $post['id'] ?>" name="comment" placeholder="Unesite komentar" required>
                                <input class="btn btn-primary add_comment_btn"  data-id="<?php echo $post['id']?>" type="submit" name="post-com" value="Post">
                
                             </form>

                                <div id="error_status"  data-id="<?php echo $post['id']?>"></div>
                    </div>
                    <div class="comments text-muted view-comm" id="view-all-comm">See more comments</div>
                    
                    
            </div>
            
   
            <!-- feed-2 -->
            <!-- <div class="feed">
                <div class="head">
                    <div class="user">
                        <div class="profile-picture">
                            <img src="images/profile.png" alt="profilna">
                        </div>
                        <div class="info">
                            <h3>Ime Prezime</h3>
                            <small>Location, time</small>
                        </div>
                        
                    </div>
                    <span class="edit"><i class="uil uil-ellipsis-h"></i></span>
                </div>
                <div class="photo">
                    <img src="images/feed-2.jpg" alt="feed">
                </div>
                <div class="action-button">
                    <div class="interaction-buttons">
                        <span>
                            <i class="uil uil-heart"></i>
                        </span>
                        <span>
                            <i class="uil uil-comment"></i>
                        </span>
                        <span>
                            <i class="uil uil-share"></i>
                        </span>
                        
                        
                        
                    </div>
                    <div class="bookmark">
                        <span><i class="uil uil-bookmark-full"></i></span>
                    </div>
                </div>
                    <div class="liked-by">
                        <span><img src="images/profile2.png" alt=""></span>
                        <span><img src="images/profile4.png" alt=""></span>
                        <span><img src="images/profile3.png" alt=""></span>
                        <p>Liked by <b>Ime Prezime</b> and <b>broj other</b></p>
                    </div>
                    <div class="caption">
                        <p><b>Ime Prezime</b> ovde ce biti opis <span class="hash-tag">#hashtag</span>  </p>
                    </div>
                    <div class="comments text-muted">View all broj komentara</div>
            </div>
           // feed-3 
            <div class="feed">
                <div class="head">
                    <div class="user">
                        <div class="profile-picture">
                            <img src="images/profile.png" alt="profilna">
                        </div>
                        <div class="info">
                            <h3>Ime Prezime</h3>
                            <small>Location, time</small>
                        </div>
                        
                    </div>
                    <span class="edit"><i class="uil uil-ellipsis-h"></i></span>
                </div>
                <div class="photo">
                    <img src="images/feed-4.jfif" alt="feed">
                </div>
                <div class="action-button">
                    <div class="interaction-buttons">
                        <span>
                            <i class="uil uil-heart"></i>
                        </span>
                        <span>
                            <i class="uil uil-comment"></i>
                        </span>
                        <span>
                            <i class="uil uil-share"></i>
                        </span>
                        
                        
                        
                    </div>
                    <div class="bookmark">
                        <span><i class="uil uil-bookmark-full"></i></span>
                    </div>
                </div>
                    <div class="liked-by">
                        <span><img src="images/profile2.png" alt=""></span>
                        <span><img src="images/profile4.png" alt=""></span>
                        <span><img src="images/profile3.png" alt=""></span>
                        <p>Liked by <b>Ime Prezime</b> and <b>broj other</b></p>
                    </div>
                    <div class="caption">
                        <p><b>Ime Prezime</b> ovde ce biti opis <span class="hash-tag">#hashtag</span>  </p>
                    </div>
                    <div class="comments text-muted">View all broj komentara</div>
            </div>
            //feed-4 
            <div class="feed">
                <div class="head">
                    <div class="user">
                        <div class="profile-picture">
                            <img src="images/profile.png" alt="profilna">
                        </div>
                        <div class="info">
                            <h3>Ime Prezime</h3>
                            <small>Location, time</small>
                        </div>
                        
                    </div>
                    <span class="edit"><i class="uil uil-ellipsis-h"></i></span>
                </div>
                <div class="photo">
                    <img src="images/feed-5.jpg" alt="feed">
                </div>
                <div class="action-button">
                    <div class="interaction-buttons">
                        <span>
                            <i class="uil uil-heart"></i>
                        </span>
                        <span>
                            <i class="uil uil-comment"></i>
                        </span>
                        <span>
                            <i class="uil uil-share"></i>
                        </span>
                        
                        
                        
                    </div>
                    <div class="bookmark">
                        <span><i class="uil uil-bookmark-full"></i></span>
                    </div>
                </div>
                    <div class="liked-by">
                        <span><img src="images/profile2.png" alt=""></span>
                        <span><img src="images/profile4.png" alt=""></span>
                        <span><img src="images/profile3.png" alt=""></span>
                        <p>Liked by <b>Ime Prezime</b> and <b>broj other</b></p>
                    </div>
                    <div class="caption">
                        <p><b>Ime Prezime</b> ovde ce biti opis <span class="hash-tag">#hashtag</span>  </p>
                    </div>
                    <div class="comments text-muted">View all broj komentara</div>
            </div>
            -->
            <?php endforeach ?>
        </div>
         
    </div>


        <div class="right">
            
                <!-- <div class="heading">
                    <h4>Messages</h4><i class="uil uil-edit"></i>
                </div>
                <div class="search-bar">
                    <i class="uil uil-search"></i>
                    <input type="search" placeholder="Search messages" id="message-search">
                </div>
                <div class="category">
                    <h6 class="active">Primary</h6>
                    <h6>General</h6>
                    <h6 class="message-requests">Requests</h6>
                </div>
                <div class="message">
                    <div class="profile-picture">
                        <img src="images/profile3.png" alt="profilna">
                    </div>
                    <div class="message-body">
                        <h5>Ime Prezime</h5>
                        <p class="text-muted">Sadrzaj poruke</p>
                    </div>
                </div>
                <div class="message">
                    <div class="profile-picture">
                        <img src="images/profile3.png" alt="profilna">
                        <div class="active"></div>
                    </div>
                    <div class="message-body">
                        <h5>Ime Prezime</h5>
                        <p class="text-bold">2 new messages</p>
                    </div> -->
                    <iframe  id="chat" src="chatapp/users.php" frameborder="0" height="600" width="420" title="Chat"></iframe>
                
         
            <!-- </div>
            <div class="friend-requests">
                <h4>Requests</h4>
                <div class="request">
                    <div class="info">
                        <div class="profile-picture">
                            <img src="images/profile3.png" alt="">
                        </div>
                        <div>
                            <h5>Ime Prezime</h5>
                            <p class="text-muted">X mutual friends</p>
                            
                            </div>
                        </div>
                        <div class="action">

                            <button class="btn btn-primary">
                                Accept
                            </button>
                            <button class="btn ">
                                Decline
                            </button>
                    </div>
                </div>
            </div> -->



        </div>
        
    </div>
</main>

 <div class="customize-theme" onload="loadsite()">
    <div class="card">
        <h2>Customize your view</h2>
        <p class="text-muted">Manage your font size, color and backgroup.</p>
        <div class="font-size">
            <h4>Font Size</h4>
        <div>
        <h6>Aa</h6>
        <div class="choose-size">
            <span class="font-size-1"></span>
            <span class="font-size-2 active"></span>
            <span class="font-size-3"></span>
            <span class="font-size-4"></span>
            <span class="font-size-5"></span>
        </div>
        <h3>Aa</h3>
    </div>
</div>
<div class="color">
    <h4>Color</h4>
    <div class="choose-color">
        <span class="color-1 active"></span>
        <span class="color-2"></span>
        <span class="color-3"></span>
        <span class="color-4"></span>
        <span class="color-5"></span>
    </div>
</div>
<div class="background">
    <h4>Background</h4>
    <div class="choose-bg">
        <div class="bg-1">
            <span></span>
            <h5 for="bg-1">Light</h5>
        </div>
        <div class="bg-2">
            <span></span>
            <h5 for="bg-2">Dim</h5>
        </div>
        <div class="bg-3">
            <span></span>
            <h5 for="bg-3">Lights Out</h5>
        </div>
     </div>
    </div>
    </div>
</div> 



<iframe class="com-frame" name="frame"></iframe>
<script src="js/posts.js"></script>
<script src="js/comments.js"></script>
<script src="js/index.js"></script>  

</body>
</html>
