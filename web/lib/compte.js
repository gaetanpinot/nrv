import Handlebars from "handlebars";
const TEMPLATE_ACCOUNT = Handlebars.compile(document.querySelector("#templateAccount").innerHTML);
const URL_API = 'http://localhost:44010';

function renderAccountTemplate() {
    const main = document.querySelector('main');
    main.innerHTML = TEMPLATE_ACCOUNT(); 
    setEventListeners();
}

function setEventListeners() {
    document.getElementById("login-btn").addEventListener("click", showLoginForm);
    document.getElementById("signup-btn").addEventListener("click", showSignupForm);

    document.getElementById("login-form").addEventListener("submit", handleLogin);
    document.getElementById("signup-form").addEventListener("submit", handleSignup);
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
        if (data) {
            alert('Login successful');
        } else {
            alert('Login failed: ' + data.message);
        }
    })
    .catch(error => console.error('Login error:', error));
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
        if (data) {
            alert('Signup successful');
        } else {
            alert('Signup failed: ' + data.message);
        }
    })
    .catch(error => console.error('Signup error:', error));
}

export function afficheAccount() {
    renderAccountTemplate();
}
