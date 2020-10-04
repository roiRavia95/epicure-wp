$ = jQuery.noConflict();

$(document).ready(() => {
        //Create scrolling functionality in restaurant menu
        $(".meal-nav ul li a").click(function (event) {
            event.preventDefault();
            let mealTime = event.target.innerHTML;
            mealTime = mealTime.toLowerCase();

            //Scrolling animation
            $('html, body').animate({
                scrollTop: ($(`section#${mealTime}`).offset().top - 150)
            }, 1500);
        });
        //Get section's top Y-axis location
        let sectionArray = $("section.restaurant-menu").get();
        let sectionsY = {};

        sectionArray.forEach((section) => {
            let objKey = $(section).attr("id")
            sectionsY[objKey] = section.getBoundingClientRect().y;
        })
        let breakfast = sectionsY.breakfast;
        let lunch = sectionsY.lunch;
        let dinner = sectionsY.dinner;

        //Get nav location - 680
        let menuNav = $("nav.meal-nav").get(0);
        let menuNavY = menuNav.getBoundingClientRect().y;


        //Add listener for scroll
        window.onscroll = () => {
            let offset = window.scrollY;
            //Use static number because the position of the menuNavY is dynamic
            if (offset > menuNavY) {
                $("nav.meal-nav").addClass("fixed-nav")
            } else {
                $("nav.meal-nav").removeClass("fixed-nav")
            }

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
                console.log(offset, dinner)
                $("a#breakfast").removeClass("current-menu");
                $("a#lunch").removeClass("current-menu")
                $("a#dinner").addClass("current-menu");
            }
        }
        $("li.meal").on("click", function (e) {
            e.preventDefault();
            let mealContent = e.currentTarget.children[0].children;
            //Because of random class p1
            let ingredients = mealContent[2].innerText === "" ? mealContent[3] : mealContent[2];

            mealContent = {
                imageUrl: mealContent[0].currentSrc,
                title: mealContent[1].innerText,
                ingridients: ingredients.innerText,
                price: mealContent[5].innerText,

            }
            console.log(mealContent);
            $("div#dialog").dialog({
                modal: true,
                title: false

            });
        })
    }
)