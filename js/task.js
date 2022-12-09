var id = 0;
function ajouterInput_text() 
{
id++;
var container = document.getElementById("container");
var input = document.createElement("input");
input.setAttribute("type", "text");
input.setAttribute("class", "input2");
input.setAttribute("id", id);
input.setAttribute("placeholder", "tâche numéro " + id);
input.setAttribute("name", "tache" );
container.appendChild(input);
container.innerHTML += "<br>";
}