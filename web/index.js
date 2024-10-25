import { afficheSpectacles } from './lib/spectacle.js';
import { afficheAccount } from './lib/compte.js';


//import { panier } from './lib/panier.js';

console.log('index js build');
afficheSpectacles();

document.querySelector("#img-compte").addEventListener("click", () => {
    afficheAccount();
});
document.querySelector('h1').addEventListener('click', () => {
    afficheSpectacles();
});
document.querySelector('#home').addEventListener('click', () => {
    afficheSpectacles();
});




/*document.querySelector('#logo-panier').addEventListener('click', () => {
    panier();
});*/