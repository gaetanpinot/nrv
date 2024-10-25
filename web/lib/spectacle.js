import Handlebars from "handlebars";
const URL_API = 'http://localhost:44010';
const URI_SPECTACLES = '/spectacles?page=0&nombre=12';
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

function loadConcerts() {
    
    showLoader();

    renderTemplate(TEMPLATE_CONCERTS, {pagination});

    const NEW_URI_SPECTACLES = `/spectacles?page=${pagination}&nombre=12`;
    fetch(URL_API + NEW_URI_SPECTACLES)
        .then((resp) => resp.json())
        .then((data) => {
            
            const listeConcertContainer = document.getElementById('liste-concert');
            listeConcertContainer.innerHTML = '';
            data.forEach(item => {
                listeConcertContainer.innerHTML += TEMPLATE_SPECTACLE(item);
            });

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
}

function handlePaginationChange(step) {
    pagination += step;
    pagination = Math.max(pagination, 0);
    console.log(pagination)
    loadConcerts(); 
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
    loadConcerts(); 
}

export function afficheSpectacles() {
    loadConcerts(); 
}
