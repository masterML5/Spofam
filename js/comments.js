$(document).ready(function () {
    $('.add_comment_btn').click(function (e) { 
        var post_id = $(this).data('id');
    

        e.preventDefault();
        ;
        var msg = $(`#${post_id}`).val();
        if($.trim(msg).length == 0){
            error_msg = "Please type comment";
            $('#error_status' ).text(error_msg);
        }
        else{
            error_msg="";
            $('#error_status' ).text(error_msg);
        }
        if(error_msg !=""){
            return false;
        }
        else
        {
                var data = {
                    'msg': msg,
                    'add_comment': true,
                    'post_id': post_id
             
                }
            $.ajax({
                type: "POST",
                url: "post-com.php",
                data: data,
                
                success: function (response) {
                   $(`#${post_id}`).val("");
                   setTimeout("", 1000);
                }
            });
        }
    });
});