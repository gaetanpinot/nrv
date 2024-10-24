import Handlebars from "handlebars";
import {URL_API, URI_JAUGE} from './settings.js';
const TEMPLATE_FORM_SPECTACLE = Handlebars.compile(
document.querySelector('#templateFormSpectacle').innerHTML);
let afficherSpectacleForm = function(){
    document.querySelector('main').innerHTML = TEMPLATE_FORM_SPECTACLE([]);
}
export function listenerSpectacleForm(){
document.querySelector('#ajouterSpectacle').addEventListener('click', afficherSpectacleForm);
}
