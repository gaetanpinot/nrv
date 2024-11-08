import {URL_API} from './settings.js';
import Handlebars from "handlebars";

const TEMPLATE_TICKETS = Handlebars.compile(document.querySelector("#templateTickets").innerHTML);


function isAuthenticated() {
    return localStorage.getItem("jwt") !== null;
}


function affichePanier() {
    const main = document.querySelector('main');
    
    if (!isAuthenticated()) {
        afficheAccount();
        return;
    }

     fetchPanierData()
        .then((paniers) => {
            main.innerHTML = TEMPLATE_TICKETS({ paniers });
            setPanierEventListeners();
        })
        .catch((error) => console.error("Erreur de chargement des billets:", error));
}


function fetchPanierData() {
    const token = localStorage.getItem("jwt");

    let userId= localStorage.getItem('id');
    return fetch(`${URL_API}/utilisateurs/${userId}/panier`, {
        headers: {
            'Authorization': `Bearer ${token}`
        }
    })
    .then((response) => {
        if (!response.ok) throw new Error("Erreur de récupération des données du panier");
        return response.json();
    });
}



function setPanierEventListeners() {
    console.log('bonojour');
    document.getElementById("payment-form").addEventListener("submit", (event) => {

        event.preventDefault();
        handlePayment();
    });
    console.log("fin");
}


function handlePayment(panierId) {
    const token = localStorage.getItem("jwt");
    const cardNumber = document.getElementById(`card-number-${panierId}`).value;
    const expiryDate = document.getElementById(`expiry-date-${panierId}`).value;
    const cvc = document.getElementById(`cvc-${panierId}`).value;

    let userId= localStorage.getItem('id');
    fetch(`${URL_API}/utilisateurs/${userId}/panier/${panierId}/payment`, {
        method: "POST",
        headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            card_number: cardNumber,
            expiry_date: expiryDate,
            cvc: cvc
        })
    })
    .then((response) => {
        if (!response.ok) throw new Error("Erreur de traitement du paiement");
        return response.json();
    })
    .then((data) => {
        alert("Paiement effectué avec succès!");
        affichePanier(); 
    })
    .catch((error) => console.error("Erreur de paiement:", error));
}

export { affichePanier };
