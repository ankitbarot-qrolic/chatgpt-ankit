jQuery(document).ready(function() {
    jQuery('#chatgpt-generate-button').click(function() {
        var nonce = jQuery('#chatgpt_generate_content_nonce').val();
        var search = jQuery('#search').val();
        jQuery.ajax({
            url: ajaxurl,
            type: 'post',
            data: {
                action: 'generate_chatgpt_content',
                nonce: nonce,
                search: search
            },
            beforeSend: function() {
                jQuery('#chatgpt-generate-button').prop('disabled', true).text('Generating...');
            },
            success: function(response) {
                jQuery('#chatgpt-generate-button').prop('disabled', false).text('Generated Content');
                // jQuery('div').show();
                console.log(response.content);
                // jQuery('#chatgpt-content').val(function() {
                //     return response.content;
                // });
                // jQuery('#data').text(function() {
                //     return response.content;
                // });
                jQuery('#myModal').show();
                jQuery("#model-body").text(function() {
                    return "<p id='chatgpt-text'>" + response.content + "</p>";
                });
                // alert(response.content);
            }
        });
    });
    // jQuery('.popup-close').click(function() {

    //     // Hide the pop-up box
    //     // $(this).parents('.popup-box').fadeOut();

    //     // });
    jQuery("#close-btn1").click(function() {
        jQuery('#myModal').hide();
        // jQuery('#myModal').attr({ "style": "display: none" });
    });
    jQuery("#copy-btn").click(function() {
        // jQuery('#myModal').hide();
        // jQuery('#myModal').attr({ "style": "display: none" });
        var copyText = jQuery("#model-body").select();
        // jQuery(document).execCommand('copy');
        navigator.clipboard.writeText(copyText.text);
    });
    jQuery("#close-btn2").click(function() {
        jQuery('#myModal').hide();
        // jQuery('#myModal').attr({ "style": "display: none" });
    });
    // Hide the popup when the close button is clicked
    // jQuery('#close-popup-button').click(function() {
    //     jQuery('#myModal').hide();
    // });
})