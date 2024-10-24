import Handlebars from "handlebars";
import {URL_API, URI_JAUGE} from './settings.js';
const TEMPLATE_SOIREES = Handlebars.compile(
document.querySelector('#templateSoirees').innerHTML);
Handlebars.registerHelper('subtract', function (value1, value2) {
    return Number(value1) - Number(value2);
});
//soustrait la somme des deux dernière valeur à celle des deux première
Handlebars.registerHelper('totalPlaces', function (value1, value2, value3, value4) {
    return (Number(value1) + Number(value2)) - (Number(value3) + Number(value4));
});
Handlebars.registerHelper('add', function (value1, value2) {
    return (Number(value1) + Number(value2)) ;
});
let getSoireeJauge = function(){
fetch(URL_API+URI_JAUGE).then((resp) => resp.json())
        .then((data) => {
            // console.log(data);
                document.querySelector('main').innerHTML = TEMPLATE_SOIREES(data);
        });
}

export function listenerJauge(){
document.querySelector('#afficherSoiree').addEventListener('click', getSoireeJauge);
}
