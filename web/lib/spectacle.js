// import {URL_API} from "./constantes.js";
import Handlebars from "handlebars";
const URL_API = 'http://localhost:44010';
const URI_SPECTACLES = '/spectacles';
const TEMPLATE_SPECTACLE = Handlebars.compile(
    document.querySelector("#templateSpectacle").innerHTML);
const TEMPLATE_SOIREE = Handlebars.compile(
    document.querySelector("#templateSoiree").innerHTML);


document.querySelector("#retour-concert").addEventListener("click", function() {
    //console.log("retour concert");

    let insertion = document.querySelector('#template-soiree');

    if (insertion) {
        insertion.setAttribute("id", "liste-concert"); // todo Change l'ID à "liste-concert"
        insertion.innerHTML = ""; // todo Vide le contenu de l'élément
    } else {
        //console.error('Élément #template-soiree non trouvé');
        return; // todo Stoppe le script si l'élément n'est pas trouvé
    }

    fetch(URL_API + URI_SPECTACLES)
        .then((resp) => resp.json())
        .then((data) => {
            data.forEach(function(val) {
                document.querySelector('#liste-concert').innerHTML += TEMPLATE_SPECTACLE(val);
            });
        })
        .then(() => {
            document.querySelectorAll(".footer-concert-button").forEach((e) => {
                e.addEventListener("click", () => {
                    afficheSoiree(e.dataset.id);
                });
            });
        })
        .catch((err) => console.error("Erreur lors de la récupération des spectacles :", err));
});



export function afficheSpectacles() {
    // console.log("affiche spectacle");
    fetch(URL_API + URI_SPECTACLES)
        .then((resp) => resp.json())
        .then((data) => {
            // console.log(data);
            data.forEach(function(val) {
                document.querySelector('#liste-concert').innerHTML += TEMPLATE_SPECTACLE(val);
            });
        }).then(() => {
            document.querySelectorAll(".footer-concert-button").forEach((e) => {
                e.addEventListener("click", () => {
                    afficheSoiree(e.dataset.id);
                });
            });

        });
}

function afficheSoiree(idSpectacles) {
    //console.log('affiche soiree ' + idSpectacles);
    let uri = URL_API + '/spectacles/' + idSpectacles + '/soirees';
    //console.log(uri);
    fetch(uri)
        .then((resp) => resp.json())
        .then((data) => {
            data.forEach((val) => {
                let insertion = document.querySelector('#liste-concert');
                if (insertion) {
                    insertion.setAttribute("id", "template-soiree");
                }
                insertion.innerHTML = "";
                insertion.innerHTML += TEMPLATE_SOIREE(val);
            });
        });
}

document.querySelector("#filtre-style").addEventListener("click", function() {

    //console.log('affiche soiree ' + idSpectacles);
    let uri = URL_API + '/spectacles/' + idSpectacles + '/soirees';
    //console.log(uri);
    fetch(uri)
        .then((resp) => resp.json())
        .then((data) => {
            data.forEach((val) => {
                let insertion = document.querySelector('#liste-concert');
                if (insertion) {
                    insertion.setAttribute("id", "template-soiree");
                }
                insertion.innerHTML = "";
                insertion.innerHTML += TEMPLATE_SOIREE(val);
            });
        });
});