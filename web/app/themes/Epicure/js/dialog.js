//Show the Meal Dialog and trigger logic inside of it
function showDialog() {
    $("li.meal").on("click", function (e) {
        e.preventDefault();
        let mealContent = e.currentTarget.children[0].children;
        $(mealContent).clone().prependTo("div.dialog div.meal-content");
        //Show the form inside the dialog
        $("div.dialog div.meal-content form").css("display","block");

        //Add meal id to each meal when the dialog is opened
        // let mealID = $('div.meal-content span.meal_id')[0].innerText;
        // $('input.meal_id').val(mealID);

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
        //Manage incrementing and decrementing quantity of meal items
        let quantity = 1;
        $("div.dialog div.meal-content div.quantity button").on("click", (e) => {
            quantity = $("input.quantity").val()
            if (e.currentTarget.className === "plus") {
                quantity++;
                $("input.quantity").val(quantity);
            } else if (quantity > 1) {
                quantity--;
                $("input.quantity").val(quantity);
            }
        })

        //Handle the form Submit
        $("div.dialog div.meal-content form").submit(function (event) {
            //Must bind the "this" to the function
            boundSubmitToSession = submitDataToSession.bind(this);
            boundSubmitToDB = submitDataToDB.bind(this);

            //Invoke the functions with "this" pointing to the dialog form
            boundSubmitToSession(event);
            boundSubmitToDB(event)

            //Update badge
            console.log($("a.item-bag div.item-badge"))
            let currentQuantity = $("a.item-bag div.item-badge")[0].innerText;
            let updatedQuantity = parseInt(currentQuantity) + parseInt(quantity);
            $("a.item-bag div.item-badge").text(updatedQuantity)
            //In case there are no meals in the bag before -
            $("a.item-bag div.item-badge").show();
        })
    })
}

//Close Dialog
function hideDialog(submitted, name) {

    $("body").css("overflow", "")
    $("div.overlay").fadeOut("fast", "linear", () => {
        $("div.dialog div.meal-content").empty();
        $("div input.checkbox").prop("checked", false);
        $("input.quantity").val(1);
    })
    if (submitted) {
        swal(
            "Yay!",
            `${name} has been added to your bag!`,
            "success",
        )
    }
}