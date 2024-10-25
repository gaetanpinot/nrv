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
                document.querySelector('#liste-concert').innerHTML += TEMPLATE_SPECTACLE(val.trim());
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

function renderTemplate(containerId, data, template) {

    const container = document.getElementById(containerId);
    if (container) {
        container.innerHTML = '';
        data.forEach(item => {
            container.innerHTML += template(item);
        });
    } else {
        console.error(`container ${containerId} not found`);
    }
}


function setSpectacleEventListeners() {
    const preButton = document.getElementById("Pre");
    const suivButton = document.getElementById("Suiv");
    const retourConcertButton = document.getElementById("retour-concert");

    if (preButton && suivButton && retourConcertButton) {
        preButton.addEventListener("click", () => handlePaginationChange(-1));
        suivButton.addEventListener("click", () => handlePaginationChange(1));
        retourConcertButton.addEventListener("click", resetToConcertList);
    }

    // Добавляем обработчики событий для каждой кнопки "footer-concert-button"
    document.querySelectorAll(".footer-concert-button").forEach((e) => {
        e.addEventListener("click", () => {
            afficheSoiree(e.dataset.id);
        });
    });
}

function handlePaginationChange(step) {
    pagination += step;
    pagination = Math.max(pagination, 0);
    loadSpectacles();
}

function resetToConcertList() {
    pagination = 0;
    loadSpectacles();
}


function loadSpectacles() {
    const NEW_URI_SPECTACLES = `/spectacles?page=${pagination}&nombre=12`;
    fetch(URL_API + NEW_URI_SPECTACLES)
        .then((resp) => resp.json())
        .then((data) => {
            renderTemplate('liste-concert', data, TEMPLATE_SPECTACLE);
            setSpectacleEventListeners();
            document.querySelector('#actuelle').textContent = pagination;
        })
        .catch((err) => console.error("Ошибка при загрузке спектаклей:", err));
}

export function afficheSpectacles() {
    console.log("affiche spectacle");
    fetch(URL_API + URI_SPECTACLES)
        .then((resp) => resp.json())
        .then((data) => {
            renderTemplate('main-content', data, TEMPLATE_SPECTACLE);
            console.log(data);
            data.forEach(function(val) {
                document.querySelector('#liste-concert').innerHTML += TEMPLATE_SPECTACLE(val.trim());
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
    let uri = URL_API + '/spectacles/' + idSpectacles + '/soirees';
    fetch(uri)
        .then((resp) => resp.json())
        .then((data) => {
            let insertion = document.querySelector('#liste-concert');
            if (insertion) {
                insertion.setAttribute("id", "liste-soiree");
            } else {
                console.error("Élément #liste-concert introuvable.");
                return;
            }

            insertion.innerHTML = "";
            data.forEach((val) => {
                insertion.innerHTML += TEMPLATE_SOIREE(val);
            });
        })
        .catch((error) => console.error("Erreur lors de la récupération des données:", error));
}



function filter() {
    // todo fetch all soirées and sort distinct dates, place, style

    // todo insert this in appropriate select 

    // todo use select with onchange to sort all soirées by date, place and style

    // todo print all soirées in sort 
}