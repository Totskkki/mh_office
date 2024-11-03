$(document).ready(function() {
    $('.alphaonly').bind('keyup blur', function() {
        var node = $(this);
        setTimeout(function() {
            node.val(node.val().replace(/[^a-zA-Z ]/g, ''));
        }, 1000); // Adjust the delay (in milliseconds) as needed
    });

    $('.integeronly').keypress(function(e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });
});
