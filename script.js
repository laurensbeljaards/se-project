/*Student Assignment Bar*/
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
/*End Student Assignment Bar*/




/*Badgebar*/
var badgesArray = ["Time", "Up", "Okay"];

function fillBadgeBar() {
    for (var i = 0; i < 20; i++) {
        var li = document.createElement("li");
        li.className = "badge";
        var badgeBar = document.getElementById("badgeBar");
        if (i < badgesArray.length) {
            li.style.backgroundImage = 'url(css/Badges/'+badgesArray[i]+'_Icon.jpg)';
        } else {
            li.style.backgroundImage = 'url(css/Badges/Locked_Icon.jpg)';
        }
        badgeBar.appendChild(li);
    }
}
/*End Badgebar*/






/*Teacher: Add Assignment*/

function setupCriteriaBar() {
    addInitialCriteraInput("listing-title", false)
    addInitialCriteraInput("listing-subject", false)
    addInitialCriteraInput("listing-requirements", true)
    addInitialCriteraInput("listing-goals", true)

    var li = document.createElement("li");
    li.id = "criteriaBox";
    var listCategory = document.getElementById("listing-difficulty");

    for (var i = 1; i <= 5; i++) {//Creates all 5 stars.
            var newBox = document.createElement("box");
            newBox.id = "difficulty_"+i;

            newBox.addEventListener('mouseover', function () {//add logic to each star capable of filling/emptying itself and other stars on hovering.
                for (var j = 0; j < 5; j++) {
                  if (j < parseInt(this.id[11])) {//fill previous stars.
                    document.getElementById("criteriaBox").childNodes[j].textContent = " ★ ";
                  } else {//empty further stars.
                    document.getElementById("criteriaBox").childNodes[j].textContent = " ☆ ";

                  }
                }
            });

            li.appendChild(newBox);
            if (i == 1) {//fill the first star (a starting difficulty of 1)
                newBox.textContent = " ★ ";
            } else {
                newBox.textContent = " ☆ ";
            }
    }

    li.className = "noUnderline"
    listCategory.parentNode.insertBefore(li, listCategory.nextSibling);
}

function addInitialCriteraInput(categoryId, multipleCriteria) {//adds the criteria fields that are present from the start

    var li = document.createElement("li");
    var textArea = document.createElement("textarea");
    textArea.className = "addCriteria";
    textArea.placeholder = "Add a criterium here!";
    li.appendChild(textArea);
    var appendAfter = document.getElementById(categoryId).nextSibling;
    while (appendAfter.nextSibling.id == "") {
        appendAfter = appendAfter.nextSibling;
    }
    appendAfter.parentNode.insertBefore(li, appendAfter.nextSibling);
    
    
    if (multipleCriteria) {
        addCriteriaCreationLogic(textArea);
    }
    addResizingLogic(textArea);
    
}

function addCriteriaCreationLogic(textArea) {//adds logic to a field that allows the creation of more criteria fields.
    
    textArea.addEventListener('keypress',function() {
                              if (textArea.parentNode.nextSibling.id != "") {//no next textarea exists
                              var newLi = document.createElement("li");
                              var newTextArea = document.createElement("textarea");
                              newTextArea.className = "addCriteria";
                              newTextArea.placeholder = "Add more criteria here...";
                              newLi.appendChild(newTextArea);
                              textArea.parentNode.nextSibling.parentNode.insertBefore(newLi, textArea.parentNode.nextSibling);
                              addCriteriaCreationLogic(newTextArea);
                              addResizingLogic(textArea);

                              }
                              },false);

}

function addResizingLogic(textArea) {//adds logic to a field that causes it to auto resize
    
    textArea.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow-y:hidden;');
    
    textArea.addEventListener('input', function () {
                              textArea.style.height = 'auto';
                              textArea.style.height = (textArea.scrollHeight) + 'px';
                              });

}

function submitCriteria() {

    var titleSubmission = getSubmitCriterium("listing-title");
    var subjectSubmission = getSubmitCriterium("listing-subject");
    var requirementsSubmission = getSubmitCriterium("listing-requirements");
    var goalsSubmission = getSubmitCriterium("listing-goals");
    var difficulty = getDifficulty();
    if (titleSubmission.length == 0) {
        alert("Please fill in the title for the assignment first...");
        return;
    }
    if (subjectSubmission.length == 0) {
        alert("Please fill in a subject first...");
        return;
    } 
    if (requirementsSubmission.length == 0) {
        alert("The assignment must have at least one requirement.");
        return;
    } 
    if (goalsSubmission.length == 0) {
        alert("The assignment must have at least one learning goal.");
        return;
    }

/*Example of the results (as javascript variables):
    alert(titleSubmission);
    alert(subjectSubmission);
    alert(requirementsSubmission); 
    alert(goalsSubmission); 
    alert(difficulty); 
*/

var submissionForm = document.createElement("form");//Create a form for submission
submissionForm.setAttribute('method',"post");
submissionForm.setAttribute('action',"submitAssignment.php");

   
    
var formTitle = document.createElement("input");//adds the title part of the assingment (This is not the title of the form!)
formTitle.setAttribute('type',"text");
formTitle.setAttribute('name',"title");
formTitle.setAttribute('value',titleSubmission[0]);
submissionForm.appendChild(formTitle);

var formSubject = document.createElement("input");//adds subject part
formSubject.setAttribute('type',"text");
formSubject.setAttribute('name',"subject");
formSubject.setAttribute('value',subjectSubmission[0]);
submissionForm.appendChild(formSubject);

var appendedRequirements = requirementsSubmission[0];//Combineert alle punten tot een doorlopend stuk text (met enters ertussen).
for (var i = 1; i < requirementsSubmission.length; i++) {
    appendedRequirements += " \n"
    appendedRequirements += requirementsSubmission[i]
}
var formRequirements = document.createElement("input");//adds requirements part
formRequirements.setAttribute('type',"text");
formRequirements.setAttribute('name',"requirements");
formRequirements.setAttribute('value',appendedRequirements);
submissionForm.appendChild(formRequirements);

var formGoals = document.createElement("input");//adds goals part
formGoals.setAttribute('type',"text");
formGoals.setAttribute('name',"goals");
formGoals.setAttribute('value',goalsSubmission);
submissionForm.appendChild(formGoals);

var formDifficulty = document.createElement("input");//adds difficulty part
formDifficulty.setAttribute('type',"text");
formDifficulty.setAttribute('name',"difficulty");
formDifficulty.setAttribute('value',difficulty);
submissionForm.appendChild(formDifficulty);

/*Showing the form (might not work on firefox or w/e) might be useful: then comment (// ) the line below*/
submissionForm.style.display="none";
    
document.getElementsByTagName('body')[0].appendChild(submissionForm);//voeg de form toe aan het document
/*
Results in this form 'submissionForm' (To be inserted in TABLE 'opdrachten'):
 
    formTitle (name:"title") >> into column naam
    formSubject (name:"subject") >> into column categorie
    formRequirements (name:"requirements") >> into column requirements
    formGoals (name:"goals") >> into column description (?)
    formDifficulty (name:"difficulty") >> into column moeilijkheidsgraad

Other:
    Note: The column 'templateCode' is not in this assignmentBar (should be written by the teacher in the separate code area)
    column 'Id' & column 'Completed' are also unused by the form.
*/
}

function getSubmitCriterium(categoryId) {

    var submissionArray = [];
    var next = document.getElementById(categoryId);
    while (next.nextSibling.nextSibling.id == "") {
        next = next.nextSibling;
        if (next.nextSibling.childNodes[0] == null) {//keep looping until the next category
            break;
        }
        if (next.nextSibling.childNodes[0].value != "") {//ignore empty fields
           submissionArray.push(next.nextSibling.childNodes[0].value);
        }
    }
    return submissionArray;
}

function getDifficulty() {
    var i;
    for (i = 0; i < 5; i++) {

        if (document.getElementById("criteriaBox").childNodes[i].textContent != " ★ ") {
          break;
        }
}
    return i;
}

/*End Teacher: Add Assignment*/

