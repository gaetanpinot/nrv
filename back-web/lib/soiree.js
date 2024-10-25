import Handlebars from "handlebars";
import {URL_API, URI_THEMES, URI_LIEUX, URI_SPECTACLES} from './settings.js';
const TEMPLATE_FORM_SOIREE = Handlebars.compile(
document.querySelector('#templateFormSoiree').innerHTML);

let handleResp  = function (resp){
    if(resp.ok){
        return resp.json();
    }else{
        window.alert("Erreur lors de la requete");
        console.log(resp.body);
        return null;
    }
}
let getInfoSoireeForm = async function(){
    let dataForm = {};
    dataForm.lieux =  await fetch(URL_API+URI_LIEUX).then(handleResp);
    dataForm.themes =  await fetch(URL_API + URI_THEMES).then(handleResp);
    dataForm.spectacles =  await fetch(URL_API + URI_SPECTACLES).then(handleResp);
    document.querySelector('main').innerHTML = TEMPLATE_FORM_SOIREE(dataForm);
    document.querySelector('#submitSoiree').addEventListener('submit',submitSoireeForm);
}
let submitSoireeForm = function(e){

}


export function listenerSoireeForm(){
document.querySelector('#ajouterSoiree').addEventListener('click', getInfoSoireeForm);
}
