var subject = ["In deze opdracht gaan we een functie schrijven die de grootste van twee waarden bepaalt en deze vervolgens returnt."];
var requirements = ["Construeer een functie met twee parameters.", "De parameters zijn beide van type Int.", "De functie moet een Int returnen.", "De grootste van de twee parameters moet teruggegeven worden."];
var goals = ["Leren over het gebruik van parameters.", "Bekend raken met de programmeertaal.", "Een functie maken die je voor de volgende opdrachten nodig zal hebben."];
var difficulty = 3;

function fillListing() {
    fillListingCategory(subject, "listing-subject");
    fillListingCategory(requirements, "listing-requirements");
    fillListingCategory(goals, "listing-goals");
    
    var li = document.createElement("li");
    var listCategory = document.getElementById("listing-difficulty");
    for (var j = 1; j <= 5; j++) {
        if (j <= difficulty)
            li.textContent += " ★ ";
        else {
            li.textContent += " ☆ ";
        }
    }
    li.className = "noUnderline"
    listCategory.parentNode.insertBefore(li, listCategory.nextSibling);
}

function fillListingCategory(array, categoryId) {
    for (var i = array.length - 1; i >= 0; i--) {
        var li = document.createElement("li");
        var listCategory = document.getElementById(categoryId);
        li.textContent = array[i];
        if (false) {//Unused: Use this if you want the sub-items to link somewhere.
            var a = document.createElement("a");
            a.setAttribute('href', "javascript:void(0);");//links to nothing
            a.appendChild(li);
            listCategory.parentNode.insertBefore(a, listCategory.nextSibling);
        } else {
            listCategory.parentNode.insertBefore(li, listCategory.nextSibling);
        }
    }
}