$ = jQuery.noConflict();

$(document).ready(() => {
    //Clicking on the hamburger button - opens menu
    $("a.menu-button").on("click", (e) => {
        $("div.mobile-hamburger-menu").css("display", "block");

        $("body").css("overflow", "hidden");
        $("div.mobile-hamburger-menu img.exit-button").on("click", function (e) {
            e.preventDefault();
            $("body").css("overflow", "")
            $("div.mobile-hamburger-menu").hide()
        })
    })
    //In mobile - click on search icon will open a larger search box.
    if ($(window).width() < 990) {
        //990 is the breakpoint for the header icons
        let isOpen = false;
        $("div.navigation-menu form.search-form button").on("click", (e) => {
            e.preventDefault();
            $("div.mobile-search").slideToggle();

            //Get hold of images location
            let imagesURL = "https://" + window.location.hostname + "/app/themes/Epicure/images";
            let exitIcon = imagesURL + "/exit-icon/x.png";
            let searchIcon = imagesURL + "/search-icon/search-icon.svg";

            isOpen = !isOpen;
            //Change icon according to the status of the mobile search bar
            if (isOpen) {
                $("div.navigation-menu form.search-form button img").attr("src", exitIcon);
            } else {
                $("div.navigation-menu form.search-form button img").attr("src", searchIcon);
            }
        })
    }
})