import Handlebars from "handlebars";
import { afficheAccount } from './compte.js';
import { URL_API } from "./settings.js";
const URI_BILLET = '/billet';
const TEMPLATE_BILLET = Handlebars.compile(document.querySelector("#templateBillet").innerHTML);

export function package_billet(idSoiree) {
    document.querySelector(".prendre-billet").addEventListener("click", function() {
        const uri = `${URL_API}/soirees/${idSoiree}`;
        fetch(uri)
            .then((resp) => resp.json())
            .then((data) => {
                create_billet(data, idSoiree); // Pass the ID soiree here
            })
            .catch((err) => console.error("Erreur lors de la récupération de la soirée :", err));
    });
}

function create_billet(data, idSoiree) {
    let insertion = document.querySelector('#liste-soiree');
    if (insertion) {
        insertion.innerHTML = ""; // Clear existing content
        insertion.innerHTML += TEMPLATE_BILLET(data);

        // Create the form element and append it to the insertion point
        const form = document.createElement('form');
        form.setAttribute("id", "billet-form");
        insertion.appendChild(form); // Append the form to the insertion point
    } else {
        console.error("Élément #liste-soiree introuvable.");
        return;
    }

    // Access the newly created form
    const formElement = document.querySelector('#billet-form');
    if (formElement) {
        formElement.addEventListener('submit', (event) => {
            event.preventDefault(); // Empêche le rechargement de la page
            const formData = new FormData(formElement);

            // Vérifie si les champs sont vides
            if (!formData.get('tarif') || !formData.get('place')) {
                alert('Veuillez renseigner tous les champs.');
                return;
            }

            // Récupère les valeurs du formulaire
            const tarif = formData.get('tarif');
            const place = formData.get('place');

            // Récupère le token
            const token = localStorage.getItem('jwt') || '';

            // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
            /*if (!token) {
                alert('Veuillez vous connecter pour continuer.');
                afficheAccount();
                return;
            }*/
            console.error('active token verification');
            // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

            // Assemble les données
            let dataform = `token=${token}&place=${place}&tarif=${tarif}&soiree=${idSoiree}`;
            console.log(dataform); // Affiche les données assemblées

            console.log(token);
            // Envoie les données au serveur en POST
            fetch(`${URL_API}/panier/billet`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify({
                    tarif: tarif,
                    place: place,
                    soiree: idSoiree
                })
            })
                .then(resp => {
                    if (!resp.ok) {
                        throw new Error('Erreur dans la réponse du serveur');
                    }
                    return resp.json();
                })
                .then(data => {
                    if (data.status === 'success') {
                        alert('Billet acheté avec succès.');
                    } else {
                        alert('Billet pas acheté.');
                    }
                })
                .catch(err => console.error("Erreur lors de l'achat du billet :", err));
        });
    } else {
        console.error("Élément #billet-form introuvable.");
    }
}
