$ = jQuery.noConflict();
function submitDataToDB(event)
{
    event.preventDefault();
    //Get Data from the form
    let form = $(this).serializeArray();
    let quantity = 1;
    let userID;
    let mealID;
    console.log(form);

    form.forEach(item=>{
        if (item.name === "user_id") {
            userID = item.value;
        }
        if (item.name === "meal_id") {
            mealID = item.value;
        }
        if (item.name === "quantity") {
            quantity = item.value;
        }
        })

    $.ajax({
        url: ajaxURL,
        action:'mealSubmit',
        data: {
            action: 'mealSubmit',
            _ajax_nonce:nonce,
            quantity:quantity,
            user_id:userID,
            meal_id:mealID
        },
        type: 'POST',
        success: function (response) {
            console.log("success: ",response)
        },
        error: function (error) {
            console.log("error: ", error)
        },

        })
}