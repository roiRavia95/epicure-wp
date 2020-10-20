//Create scrolling functionality in restaurant menu
window.scrollOnClick = function() {
    $(".meal-nav ul li a").click(function (event) {
        event.preventDefault();
        let mealTime = event.target.innerHTML;
        mealTime = mealTime.toLowerCase();

        //Scrolling animation
        $('html, body').animate({
            scrollTop: ($(`section#${mealTime}`).offset().top - 150)
        }, 1500);
    });
}

//Show which meal time menu is currently being watched by the user
window.changeCurrentMenu = function () {
    //Get section's top Y-axis location
    let sectionArray = $("section.restaurant-menu").get();
    let sectionsY = {};

    sectionArray.forEach((section) => {
        let objKey = $(section).attr("id")
        sectionsY[objKey] = section.getBoundingClientRect().y;
    })

    let offset = window.scrollY;
    //Give the sections the right offset for the current menu to change accurately
    let breakfast = sectionsY.breakfast + offset - 160;
    let lunch = sectionsY.lunch + offset - 160;
    let dinner = sectionsY.dinner + offset - 160;


    //Add listener for scroll
    window.onscroll = () => {
        offset = window.scrollY;

        //Add logic to change nav underline accordingly
        if (offset >= breakfast && offset <= lunch) {
            $("a#breakfast").addClass("current-menu")
            $("a#lunch").removeClass("current-menu");
            $("a#dinner").removeClass("current-menu");
        } else if (offset >= breakfast && offset >= lunch) {
            $("a#breakfast").removeClass("current-menu");
            $("a#lunch").addClass("current-menu")
            $("a#dinner").removeClass("current-menu");
        }
        if (offset >= dinner) {
            $("a#breakfast").removeClass("current-menu");
            $("a#lunch").removeClass("current-menu")
            $("a#dinner").addClass("current-menu");
        }
    }
}