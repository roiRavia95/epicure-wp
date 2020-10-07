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

        //Meal Dialog
        $("li.meal").on("click", function (e) {
            e.preventDefault();
            let id = $("p#meal-id").innerText;
            let mealContent = e.currentTarget.children[0].children;

            $(mealContent).clone().prependTo("div.dialog div.meal-content");
            //Only on desktop show extra info next to the header
            if ($(window).width() > 768) {
                $("div.dialog div.meal-content div.extra-info").prependTo("div.dialog h2");
            }
            $("body").css("overflow", "hidden")
            $("div.overlay").show()

            $("a.exit-button").on("click", function (e) {
                e.preventDefault();
                hideDialog();
            })
        })

        //Manage incrementing and decrementing quantity of meal items
        $("div.quantity button").on("click", (e) => {
            let value = $("div.quantity input#quantity").val()
            if (e.currentTarget.className === "plus") {
                value++;
                $("div.quantity input#quantity").val(value);
            } else if (value > 1) {
                value--;
                $("div.quantity input#quantity").val(value);
            }
        })


    }
)
