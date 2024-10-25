import {URL_API} from './settings.js';
export function fetchUserTickets() {
    const userId= parseJwt(localStorage.getItem("jwt")).sub;

    fetch(`${URL_API}/utilisateur/${userId}/billets`, {
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${localStorage.getItem("jwt")}`,
            'Content-Type': 'application/json'
        }
    })
        .then(resp => resp.json())
        .then(data => {
            if (data && data.billets) {
                displayTickets(data.billets);
            } else {
                alert('Aucun billet acheté trouvé.');
            }
        })
        .catch(error => console.error('Erreur de récupération des billets:', error));
}

function parseJwt(token) {
    const base64Url = token.split('.')[1];
    const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
    const jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(''));
    return JSON.parse(jsonPayload);
}

function displayTickets(billets) {
    const main = document.querySelector('main');
    const templateSource = document.querySelector("#templateUserTickets").innerHTML;
    const template = Handlebars.compile(templateSource);
    main.innerHTML = template({ billets });
}
