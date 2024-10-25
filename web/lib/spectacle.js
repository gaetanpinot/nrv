// import {URL_API} from "./constantes.js";
import Handlebars from "handlebars";
const URL_API = 'http://localhost:44010';
const URI_SPECTACLES = '/spectacles?page=0&nombre=12';
const TEMPLATE_SPECTACLE = Handlebars.compile(
    document.querySelector("#templateSpectacle").innerHTML);
const TEMPLATE_SOIREE = Handlebars.compile(
    document.querySelector("#templateSoiree").innerHTML);

let pagination = 0;

function pagi(aa) {
    pagination += aa;
    pagination = pagination < 0 ? 0 : pagination;
    //console.log(pagination);

    const NEW_URI_SPECTACLES = '/spectacles?page=' + pagination + '&nombre=12';
    //console.log(NEW_URI_SPECTACLES);
    document.querySelector('#actuelle').innerHTML = "";
    document.querySelector('#actuelle').innerHTML = pagination;


    // todo Vide le contenu de la liste des spectacles
    document.querySelector('#liste-concert').innerHTML = "";
    // TODO récupérer les données à partir de la nouvelle page

    fetch(URL_API + NEW_URI_SPECTACLES)
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
}

// todo pagination

document.querySelector("#Pre").addEventListener("click", function() {
    //console.log("Pre");
    pagi(-1);
});
document.querySelector("#Suiv").addEventListener("click", function() {
    //console.log("Suiv");
    pagi(+1);
});

document.querySelector("#retour-concert").addEventListener("click", function() {
    //console.log("retour concert");

    let insertion = document.querySelector('#template-soiree');
    pagination = 0;

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
                //console.log(insertion);
                insertion.innerHTML = "";
                insertion.innerHTML += TEMPLATE_SOIREE(val);
                if (insertion) {
                    insertion.setAttribute("id", "template-soiree");
                }
            });
        });
}

const billetElement = document.querySelector("#billet");
if (billetElement) {
    billetElement.addEventListener("click", function() {
        const token = localStorage.getItem('token');
        console.log(token);
        //URL_API = 'http://localhost:44010';
        if (token) {
            fetch(URL_API + '/billet?token=' + token + '&soiree=' + dataset.id);
            console.log(URL_API + '/billet?token=' + token + '&soiree=' + dataset.id);
        }
    });
}


function filter() {
    // todo fetch all soirées and sort distinct dates, place, style

    // todo insert this in appropriate select 

    // todo use select with onchange to sort all soirées by date, place and style

    // todo print all soirées in sort 
}