import Handlebars from "handlebars";
import {URL_API, URI_THEMES, URI_LIEUX, URI_SPECTACLES} from './settings.js';
const TEMPLATE_FORM_SOIREE = Handlebars.compile(
document.querySelector('#templateFormSoiree').innerHTML);

let getInfoSoireeForm = function(){
console.log("soiree form");
}

export function listenerSoireeForm(){
document.querySelector('#ajouterSoiree').addEventListener('click', getInfoSoireeForm);
}
