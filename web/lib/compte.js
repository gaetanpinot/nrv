import Handlebars from "handlebars";
import {fetchUserTickets} from './mesbillets.js';

let TEMPLATE_ACCOUNT;
const URL_API = 'http://localhost:44010';

function isAuthenticated() {

    return localStorage.getItem("jwt") != null;
}

function renderAccountTemplate() {
    const main = document.querySelector('main');
    console.log(isAuthenticated());
    if (isAuthenticated()) {
        TEMPLATE_ACCOUNT = Handlebars.compile(document.querySelector("#templateAccountAuth").innerHTML);
    } else {
        TEMPLATE_ACCOUNT = Handlebars.compile(document.querySelector("#templateAccountNonAuth").innerHTML);
    }

    main.innerHTML = TEMPLATE_ACCOUNT();
    isAuthenticated() ? setAuthenticatedEventListeners() : setUnauthenticatedEventListeners();
}

function setUnauthenticatedEventListeners() {
    document.getElementById("login-btn").addEventListener("click", showLoginForm);
    document.getElementById("signup-btn").addEventListener("click", showSignupForm);
    document.getElementById("login-form").addEventListener("submit", handleLogin);
    document.getElementById("signup-form").addEventListener("submit", handleSignup);
}

function setAuthenticatedEventListeners() {
    document.getElementById("logout-btn").addEventListener("click", handleLogout);
    document.getElementById("billet-btn").addEventListener("click", fetchUserTickets);
}
function showLoginForm() {
    document.getElementById("login-form").classList.add("active");
    document.getElementById("signup-form").classList.remove("active");
    document.getElementById("login-btn").classList.add("active");
    document.getElementById("signup-btn").classList.remove("active");
}

function showSignupForm() {
    document.getElementById("signup-form").classList.add("active");
    document.getElementById("login-form").classList.remove("active");
    document.getElementById("signup-btn").classList.add("active");
    document.getElementById("login-btn").classList.remove("active");
}

function handleLogin(event) {
    event.preventDefault();
    const email = document.querySelector("#login-form input[type='email']").value;
    const password = document.querySelector("#login-form input[type='password']").value;

    fetch(`${URL_API}/connexion`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ email, password })
        })
        .then(resp => resp.json())
        .then(data => {
            if (data && data.token) {
                localStorage.setItem("jwt", data.token);
                localStorage.setItem("id", data.id);
                renderAccountTemplate();
            } else {
                alert('Échec de la connexion: ' + data.message);
            }
        })
        .catch(error => console.error('Erreur de connexion:', error));
}

function handleSignup(event) {
    event.preventDefault();
    const nom = document.querySelector("#signup-form input[placeholder='Nom complet']").value;
    const prenom = document.querySelector("#signup-form input[placeholder='Prenom complet']").value;
    const email = document.querySelector("#signup-form input[type='email']").value;
    const password = document.querySelector("#signup-form input[type='password']").value;

    fetch(`${URL_API}/inscription`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ nom, prenom, email, password })
        })
        .then(resp => resp.json())
        .then(data => {
            if (data && data.token) {
                localStorage.setItem("jwt", data.token);
                renderAccountTemplate();
            } else {
                alert('Échec de l\'inscription: ' + data.message);
            }
        })
        .catch(error => console.error('Erreur d\'inscription:', error));
}

function handleLogout() {
    localStorage.removeItem("jwt");
    alert("Déconnexion réussie");
    renderAccountTemplate();
}

export function afficheAccount() {
    renderAccountTemplate();
}
