import {afficheSpectacles} from './lib/spectacle.js';
import { afficheAccount } from './lib/compte.js';

console.log('index js build');
(function(){
    document.getElementById("img-compte").addEventListener("click", (e) => {
        afficheAccount(); 
    });

    document.querySelector('header h1').addEventListener('click', (e) => {
        afficheSpectacles(); 
    });

    afficheSpectacles();
})();
