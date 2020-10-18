$ = jQuery.noConflict();
$(document).ready(() => {
    let clicked = false;
    //Make sure that there are meals in the bag before we checkout;
    if (window.sessionStorage.length) {
        let orderID = window.sessionStorage.getItem('order_id');
        $("a.checkout").on("click", function (e) {
            clicked = true;
            $.ajax({
                type: 'POST',
                url: ajaxURL,
                action: 'checkout',
                data: {
                    action: 'checkout',
                    _ajax_nonce: nonce,
                    clicked: clicked,
                    order_id: orderID
                },
                success: function (response) {
                    console.log("success: ", response)
                },
                error: function (error) {
                    console.log("error: ", error)
                },
            })
        if(isUserLoggedIn){
            window.sessionStorage.clear();
        }
        })
    }
})