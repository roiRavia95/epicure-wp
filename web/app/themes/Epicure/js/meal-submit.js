$ = jQuery.noConflict();
//Create a function to submit the data to the server using ajax and pass it to the showDialog function
//(because it is relevant only when a dialog is opened)
function submitDataToDB(event)
{
    event.preventDefault();
    //Get Data from the form
    let form = $(this).serializeArray();
    let quantity = 1;
    let userID;
    let mealID;
    let changes = {};
    let sides = {};
    console.log(form);

    form.forEach(item => {
        if (item.name === "user_id") {
            userID = item.value;
        }
        if (item.name === "meal_id") {
            mealID = item.value;
        }
        if (item.name === "quantity") {
            quantity = item.value;
        }
        if (item.name.includes('change')) {
            changes[item.name] = item.value
        }
        if (item.name.includes('side')) {
            sides[item.name] = item.value
        }
    })

    $.ajax({
        url: ajaxURL,
        action: 'mealSubmit',
        data: {
            action: 'mealSubmit',
            _ajax_nonce: nonce,
            quantity: quantity,
            user_id: userID,
            meal_id: mealID,
            changes: changes,
            sides: sides,
        },
        type: 'POST',
        success: function (response) {
            console.log("success: ", response)
        },
        error: function (error) {
            console.log("error: ", error)
        },

    })
}