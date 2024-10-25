import Handlebars from "handlebars";
const URL_API = 'http://localhost:44010';
const URI_SPECTACLES = '/spectacles?page=0&nombre=12';
var FILTRES = '';
let ancien_filtres = '';
const TEMPLATE_CONCERTS = Handlebars.compile(document.querySelector("#templateConcerts").innerHTML);
const TEMPLATE_SPECTACLE = Handlebars.compile(document.querySelector("#templateSpectacle").innerHTML);
const TEMPLATE_SOIREE = Handlebars.compile(document.querySelector("#templateSoiree").innerHTML);

let pagination = 0;

function showLoader() {
    const loader = document.getElementById("loader");
    if (loader) {
        loader.style.display = "block";
    }
}

function hideLoader() {
    const loader = document.getElementById("loader");
    if (loader) {
        loader.style.display = "none";
    }
}

function renderTemplate(template, data) {
    const main = document.querySelector('main');
    main.innerHTML = ''; 
    main.innerHTML = template(data); 
}

function filtrer() {

    let lieu = document.getElementById('filtre-lieu').value;
    let date = document.getElementById('filtre-date').value;
    let theme = document.getElementById('filtre-style').value;

    FILTRES = '&lieu=' + lieu + '&date=' + date + '&style=' + theme;
    if (FILTRES != ancien_filtres || FILTRES == '') {
        ancien_filtres = FILTRES;
        pagination = 0;
    }

    //clear list
    document.getElementById('liste-concert').innerHTML = '';

    //load new list
    loadConcerts();

    document.getElementById('filtre-lieu').value = lieu;
    document.getElementById('filtre-date').value = date;
    document.getElementById('filtre-style').value = theme;
}

function loadConcerts() {
    
    showLoader();

    renderTemplate(TEMPLATE_CONCERTS, {pagination});

    const NEW_URI_SPECTACLES = `/spectacles?page=${pagination}&nombre=12`;
    fetch(URL_API + NEW_URI_SPECTACLES + FILTRES)
        .then((resp) => resp.json())
        .then((data) => {
            
            const listeConcertContainer = document.getElementById('liste-concert');
            listeConcertContainer.innerHTML = '';
            data.forEach(item => {
                listeConcertContainer.innerHTML += TEMPLATE_SPECTACLE(item);
            });

            // document.getElementById('actuelle').textContent = pagination;
            setEventListeners();
        })
        .catch((err) => console.error("Erreur lors de la récupération des spectacles:", err))
        .finally(() => hideLoader());
}


function setEventListeners() {
    document.getElementById("Pre").addEventListener("click", () => handlePaginationChange(-1));
    document.getElementById("Suiv").addEventListener("click", () => handlePaginationChange(1));
    document.getElementById("retour-concert").addEventListener("click", resetToConcertList);

    document.querySelectorAll(".footer-concert-button").forEach((e) => {
        e.addEventListener("click", () => {
            afficheSoiree(e.dataset.id);
        });
    });

    document.getElementById("filtre-style").addEventListener("change", filtrer);
    document.getElementById("filtre-date").addEventListener("change", filtrer);
    document.getElementById("filtre-lieu").addEventListener("change", filtrer);
}

function handlePaginationChange(step) {
    pagination += step;
    pagination = Math.max(pagination, 0);
    filtrer(); 
}

function afficheSoiree(idSpectacles) {
    showLoader();
    const uri = `${URL_API}/spectacles/${idSpectacles}/soirees`;
    fetch(uri)
        .then((resp) => resp.json())
        .then((data) => {
            renderTemplate(TEMPLATE_SOIREE, { soiree: data });
        })
        .catch((err) => console.error("Erreur lors de la récupération des soirees :", err))
        .finally(() => hideLoader());
}


function resetToConcertList() {
    FILTRES = '&lieu=all&date=ASC&style=all';
    pagination = 0;
    loadConcerts(); 
}

export function afficheSpectacles() {
    loadConcerts(); 
}
