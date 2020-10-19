$ = jQuery.noConflict();
//Create a function to submit the data to the session storage and pass it to the showDialog function
//(because it is relevant only when a dialog is opened)
function submitDataToSession(event)
{
        //Create order id and add to it to the session storage
    console.log(window.sessionStorage.getItem('order_id'));
    if(!window.sessionStorage.getItem('order_id')){
            let orderID = new Date().getTime();
            window.sessionStorage.setItem('order_id',orderID);
        }


        event.preventDefault()
        //Get hold of the meal's content
        let mealContent = $("div.dialog")[0].children[0].children;

        //Put valuable data inside object
        let meal = {}
        //Because of wp adding randomly <p> tags to ingredients, ingredients will be concatenated rather then being set.
        meal["ingredients"] = "";

        //Validate by tags and make sure to always get the correct data
    for (let element of mealContent) {
        let tag = element.tagName.toLowerCase();
        if (element.className === "meal_id") {
            meal["meal_id"] = element.innerText;
        }
        if (tag === "img") {
            meal["image"] = element.src;
        }
        if (tag === "h2") {
            meal["title"] = element.innerText;
        }
        if (tag === "p") {
            meal["ingredients"] += element.innerText;
        }
        if (tag === "div") {
            meal["price"] = element.innerText;
        }
    }
        //Initial quantity
        let quantity = 1;

        //Get the form data
        let form = $(this).serializeArray();
        form.forEach(item => {
            //Get the quantity for adjusting the number of objects to put into session storage
            if (item["name"] === "quantity") {
                quantity = item["value"];
            } else {
                //Append the form data to the meal object
                meal[item["name"]] = item["value"];
            }
        })
        //turn meal object to string
        let mealString = JSON.stringify(meal);

        //Add meals to session storage
    for (let i = 0; i < quantity; i++) {
        window.sessionStorage.setItem(meal.title + window.sessionStorage.length, mealString);
        console.log("meal has been added to session storage")
    }
        hideDialog(true, meal.title);
}