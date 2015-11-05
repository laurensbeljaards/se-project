SE-Project, C-Sharper
=====================
Let's try to use Github for this project to see if it makes making changes more simple. In theory, it should.

About the project
-----------------
This project is for a class called 'Software Engineering'. For this assignment we (a team of 6 students from the Leiden University) need to create software for use in a programming class. Students using this software can complete several programming assignments in the language C#. The assignments are given by the teacher. The students should be able to write code in our program, maybe test it, save it, edit it and when they are finally done, they should be able to mark the assignment as 'Ready to check' and the lecturer should be able to check the students' solutions and give them feedback.
Some additional features will be mentioned later.

We use the 'Scrum'-method for this software and we use the Scrumwise software to maintain a digital copy of the Scrumboard.

To my Team
----------
Ik heb even een test account gemaakt om te kijken hoe het voor jullie zou moeten werken. Dus wat je doet:

* Fork de branch naar je eigen account. Dan kan je lekker wijzigingen maken en doen wat je wilt.
* Dan ga je naar het project op onze Team-pagina.
* Open een pull-request en 'compare across forks'.
* Dan kan je je request maken en vul je even kort in wat het fixt of toevoegt enzo.
* Dan kunnen anderen op je request reageren of wat dan ook.
* Uiteindelijk kunnen we dan de wijziging opnemen in het project.

Succes!

Coding standards
----------------
Aangezien het project nu toch wel een beetje een zooitje begint te worden zonder echte standaarden, zal ik er aantal opstellen wat het coderen tussen bepaalde features e.d. makkelijker maakt en de code overzichtelijker maakt.

### Algemeen
* Als je variabelen gebruikt (of dat nu 'ids' in HTML zijn of PHP variabelen) maak gebruik van camelCaseMetDeEersteLetterEenKleineLetter. Dat is overzichtelijk.
* Ookal is de front-end in het Nederlands, probeer de backend (dus variabelen, database kolommen etc.) in het Engels te schrijven. Over het algemeen wordt code geschreven in het Engels plus alle keywords zijn in het Engels, wel zo makkelijk dus.
* Zorg voor een beetje commentaar bij je code (in het Engels) zodat ook iemand anders weet waar er iets aangepast moet worden etc.
* Maak geen gebruik van fixed URL's! In de config.php file (later meer) heb ik een php variabele '$BASEDIR' en een variabele '$RELPATH' aangemaakt. De BASEDIR is het pad naar de root van de website zoals deze gebruikt kan worden door PHP (dus voor includen etc.) en RELPATH is de root van de website voor URL's in HTML bijvoorbeeld. Als je dus zorgt dat je elke HTML URL opbouwt hiermee, dan zal je, ongeacht op welke pagina en in welke map je je dan bevind, een werkende link hebben.

### HTML
* Probeer je code HTML5 compatible te maken. Het is de laatste standaard, dus dat hoort. Gewoon.
* Maak dus geen gebruik van HTML code die in HTML5 niet meer ondersteund wordt.
* De HTML is voor structuur van het document, de opmaak is voor de CSS. Dus liever geen 'style=' achtige dingen.

### PHP
* Om dat gedoe met wachtwoorden te verhelpen, heb ik een config.php file geplaatst, waar jij in je eigen testenviroment het wachtwoord kan invullen. Sync deze file alleen NOOIT naar je eigen fork of naar het project aangezien het wachtwoord dan nog steeds zichtbaar is.
* In de config.php staat verder alle database informatie klaar om een connectie te maken. Als we deze file dus op elke pagina 1 keer includen (met PHP 'requireonce' bijvoorbeeld) dan heb je altijd de database informatie bij de hand en hoeven we dat niet in elke pagina te plaatsen en bij te werken etc. In deze config.php file kan je ook variabelen/code plaatsen die je denkt op meerdere pagina's nodig te hebben. Zo hoef je dat bij wijzigingen maar 1 keer aan te passen en wordt het op de andere pagina's automatisch gerequired.

### MySQL
* Nu we toch bezig zijn, laten we vanaf nu alle input 'veilig' meegeven aan MySQL query's zodat er geen injecties mogelijk zijn.