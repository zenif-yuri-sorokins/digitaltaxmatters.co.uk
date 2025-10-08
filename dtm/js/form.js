jQuery(document).ready(function(){
    jQuery('.action-box-form form').submit(function(){
        var response_html = jQuery(this).children('.form-repsonse');

        response_html.html('');

        var formData = jQuery(this).serialize();

        jQuery.ajax({
            type: "POST",
            url: "/wp-content/themes/grapefruit-2/inc/process/form-submit.php",
            dataType: "json",
            data: formData,
            success: function(data){
                if(data.valid == 'yes'){
                    response_html.html('<div class="success">You have successfully signed up, please wait 24hrs for a response.</div>');
                }
                else{
                    response_html.html('<div class="error">'+ data.response +'</div>');   
                }
            },
            error: function(){
                response_html.html('<div class="error">Sorry, something went wrong while proccessing the form. Please try again later.</div>');
            }
        });

        return false;
    });
});