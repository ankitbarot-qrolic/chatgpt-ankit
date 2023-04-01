// Wait for the DOM to be ready
jQuery(document).ready(function($) {

    // When the user clicks on a link with the class "popup-link"
    $('.chatgpt-generate-button').click(function(e) {

        // Prevent the link from opening normally
        e.preventDefault();

        // Get the href attribute of the link
        var popupBox = $(this).attr('href');

        // Show the pop-up box
        $(popupBox).fadeIn();

    });

    // When the user clicks on the close button
    $('.popup-close').click(function() {

        // Hide the pop-up box
        $(this).parents('.popup-box').fadeOut();

    });

});