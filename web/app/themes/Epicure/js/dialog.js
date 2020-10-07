//Show the Meal Dialog and trigger logic inside of it
function showDialog() {
    $("li.meal").on("click", function (e) {
        e.preventDefault();
        let mealContent = e.currentTarget.children[0].children;

        $(mealContent).clone().prependTo("div.dialog div.meal-content");
        //Only on desktop show extra info next to the header
        if ($(window).width() > 768) {
            $("div.dialog div.meal-content div.extra-info").prependTo("div.dialog h2");
        }
        $("body").css("overflow", "hidden")
        $("div.overlay").fadeIn("fast", "linear")

        $("a.exit-button").on("click", function (e) {
            e.preventDefault();
            hideDialog();
        })
    })

    //Manage incrementing and decrementing quantity of meal items
    $("div.quantity button").on("click", (e) => {
        let value = $("input#quantity").val()
        if (e.currentTarget.className === "plus") {
            value++;
            $("input#quantity").val(value);
        } else if (value > 1) {
            value--;
            $("input#quantity").val(value);
        }
    })
}

//Close Dialog
function hideDialog(submitted, name) {

    $("body").css("overflow", "")
    $("div.overlay").fadeOut("fast", "linear", () => {
        $("div.dialog div.meal-content").empty();
        $("div input.checkbox").prop("checked", false);
        $("input#quantity").val(1);
    })
    if (submitted) {
        swal(
            "Yay!",
            `${name} has been added to your bag!`,
            "success",
        )
    }
}