$(document).ready(function(){


$('.like-btn').on('click', function(){
    var post_id = $(this).data('id');
    $clicked_btn = $(this);


     if($clicked_btn.hasClass('bi-heart')){
         action = 'like';
     }else if ($clicked_btn.hasClass('bi-heart-fill')){
         action = 'unlike';
     }

     $.ajax({
         url: 'index.php',
         type: 'post',
         data: {
             "action": action,
             "post_id": post_id
         },
    
         success: function(data){
             res = JSON.parse(data);
        
            
            if (action == "like"){
                $clicked_btn.removeClass('bi-heart');
                $clicked_btn.addClass('bi-heart-fill');
            }
            else if (action == "unlike"){
                $clicked_btn.removeClass('bi-heart-fill');
                $clicked_btn.addClass('bi-heart');
            }
            $clicked_btn.siblings('b.likes').text(res.likes);
            
           
         
            }
     })

});
$('.comment-btn').on('click', function(){
    var post_id = $(this).data('id');
    
     $clicked_btn = $(this);
     
   

     if($clicked_btn.hasClass('bi-chat')){
         action = 'com';
     }else if ($clicked_btn.hasClass('bi-chat-dots-fill')){
        action = 'uncom';
     }
   
       
           if (action == "com"){
              $clicked_btn.removeClass('bi-chat');
                $clicked_btn.addClass('bi-chat-dots-fill');
                document.querySelector(`[data="${post_id}"]`).
                style.display = 'flex';
               
               
                
           }
            else if (action == "uncom"){
                $clicked_btn.removeClass('bi-chat-dots-fill');
               $clicked_btn.addClass('bi-chat');
               
               document.querySelector(`[data="${post_id}"]`).
               style.display = 'none';
          
           }
       
           
         
   

 }); 

});



