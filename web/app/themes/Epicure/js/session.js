$ = jQuery.noConflict();
$(document).ready(() => {
    //Get the value as soon as possible (avoid empty div)
    $("div.item-badge").text(window.sessionStorage.length)

    $("div.dialog form").submit(function (e) {
        e.preventDefault()
        //Get hold of the meal's content
        let mealContent = $("div.dialog")[0].children[0].children;

        //Put valuable data inside object
        let meal = {}

        //Because of wp adding randomly <p> tags to ingredients
        meal["ingredients"] = "";
        //Validate by tags and make sure to always get the correct data
        for (let element of mealContent) {
            let tag = element.tagName.toLowerCase();
            if (tag === "img") meal["image"] = element;
            if (tag === "h2") meal["title"] = element;
            if (tag === "p") meal["ingredients"] += element.innerText;
            if (tag === "div") meal["price"] = element;
        }
        //Initial quantity
        let quantity = 1;

        //Get the form data
        let form = $(this).serializeArray();

        form.forEach(item => {
            //Get the quantity for adjusting the number of objects to put into session storage
            if (item["name"] === "quantity") {
                quantity = item["value"];
                console.log(quantity)
            } else {
                //Append the form data to the meal object
                meal[item["name"]] = item["value"];
            }
        })

        //turn meal object to string
        let mealString = JSON.stringify(meal);

        //Add meals to session storage
        for (let i = 0; i < quantity; i++) {
            window.sessionStorage.setItem(meal.title.innerText + window.sessionStorage.length, mealString);
            console.log("meal has been added to session storage")
        }
        //present the number change
        $("div.item-badge").text(window.sessionStorage.length).show()

        hideDialog(true)


    })
    //If there are no meals - hide the badge.
    if (!window.sessionStorage.length) {
        $("a.item-bag div.item-badge").hide();
    } else {
        $("a.item-bag div.item-badge").show();
    }

})

function hideDialog(submitted) {

    $("body").css("overflow", "")
    $("div.overlay").fadeOut("fast", "linear", () => {
        $("div.dialog div.meal-content").empty();
        $("div.quantity input#quantity").val(1)
        console.log($("div.quantity input#quantity").val())
    })
    if (submitted) {
        swal(
            "Yay!",
            "This meal has been added to your bag!",
            "success",
        )
    }
}