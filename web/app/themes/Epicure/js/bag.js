$ = jQuery.noConflict();
$(document).ready(() => {

    console.log("bag")
    let keys;
    keys = Object.keys(window.sessionStorage);
    let meals = {};
    //Get total price
    let total = 0;
    keys.forEach(key => {
        meals[key] = JSON.parse(window.sessionStorage.getItem(key))
        //Create a html string with the data from the session storage
        //NOTICE - <li> and <div> are still open! (to add additional data later on)
        let mealHTML = `
            <li class='meal'>
            <img src='${meals[key].image}' alt=''>
            <div class="meal-content">
            <div class="main-content">
            <h2>${meals[key].title}</h2>
            <p class="ingredients">${meals[key].ingredients}</p>
            </div>
            <div class="extra-info-bag">
        `;

        //Check if has any extra inputs - Changes
        if (meals[key]["change-1"] || meals[key]["change-2"]) {
            mealHTML += "<div class='changes'><h3>Changes: </h3>"
            meals[key]["change-1"] ? mealHTML += `<p>${meals[key]["change-1"]}</p>` : null
            meals[key]["change-2"] ? mealHTML += `<p>${meals[key]["change-2"]}</p>` : null
            mealHTML += "</div>"
        }
        //Check if has any extra inputs - Sides
        if (meals[key]["side-1"] || meals[key]["side-2"]) {
            mealHTML += "<div class='sides'><h3>Sides: </h3>"
            meals[key]["side-1"] ? mealHTML += `<p>${meals[key]["side-1"]}</p>` : null
            meals[key]["side-2"] ? mealHTML += `<p>${meals[key]["side-2"]}</p>` : null
            mealHTML += "</div>"
        }
        //Close extra-info-bag div
        mealHTML += "</div>"

        //Add price in the end of the container
        mealHTML += `<p class="price">${meals[key].price}</p>`
        //Close the meal-content div and meal li
        mealHTML += "</div></li>"

        $("ul.my-meals").append(mealHTML);
        total += parseInt(meals[key].price);
    })

    //Total price HTML
    let totalHTML = `<p class='total price'>${total}</p>`;

    $("main.bag div.total").append(totalHTML);

})