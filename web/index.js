import {afficheSpectacles} from './lib/spectacle.js';
import {compteMain} from './lib/compte.js';

console.log('index js build');
(function(){
    document.getElementById('main-content').innerHTML = TEMPLATE_SPECTACLE(val);
afficheSpectacles();
// compteMain();
})();
