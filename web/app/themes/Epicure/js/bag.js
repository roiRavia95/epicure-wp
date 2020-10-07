$ = jQuery.noConflict();
$(document).ready(() => {

    console.log("bag")
    let keys;
    keys = Object.keys(window.sessionStorage);
    let meals = {};
    keys.forEach(key => {
        meals[key] = JSON.parse(window.sessionStorage.getItem(key))
        //Create a html string with the data from the session storage
        //NOTICE - <li> is still open! (to add additional data later on)
        let mealHTML = `
            <li class='meal'>
            <img src='${meals[key].image}' alt=''>
            <h2>${meals[key].title}</h2>
            <p>${meals[key].ingredients}</p>
            <p>${meals[key].price}</p>
        `;
        //Check if has any extra inputs
        meals[key]["change-1"] ? mealHTML += `<p>${meals[key]["change-1"]}</p>` : null
        meals[key]["change-2"] ? mealHTML += `<p>${meals[key]["change-2"]}</p>` : null
        meals[key]["side-1"] ? mealHTML += `<p>${meals[key]["side-1"]}</p>` : null
        meals[key]["side-2"] ? mealHTML += `<p>${meals[key]["side-2"]}</p>` : null

        //Close the mealHTML li
        mealHTML += "</li>"

        $("ul.my-meals").append(mealHTML);
        console.log(meals)
    })

})