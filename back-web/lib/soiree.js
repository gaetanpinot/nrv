import Handlebars from "handlebars";
import {URL_API, URI_SOIREE, URI_THEMES, URI_LIEUX, URI_SPECTACLES} from './settings.js';
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
    document.querySelector('#formSoiree').addEventListener('submit',submitSoireeForm);
}
let submitSoireeForm = function(e){
    e.preventDefault();
    let formData =e.target.elements;
    let getD = function($ch){
    return formData[$ch].value.trim();
    }
    console.log(getD('date'));
    let submitData= {
    nom: getD('nom'),
    id_theme: getD('theme'),
    date: getD('date'),
    heure_debut: getD('debut'),
    duree: getD('duree'),
    lieu_id: getD('lieux'),
    tarif_normal: getD('tarif_normal'),
    tarif_reduit: getD('tarif_reduit')
    }
    let spectacles =Array.from(e.target.querySelectorAll('.spectacles'));
    let checkedSpectaclesId = spectacles.filter((spectacle)=>spectacle.checked)
    .map((spectacle)=> spectacle.value.trim());
    if (checkedSpectaclesId.length === 0){
    window.alert("Vous n'avez pas sélléctioné de spectacles");
    }else{
    submitData.spectacles = checkedSpectaclesId;
    console.log(submitData);
    fetch(URL_API + URI_SOIREE, {
    body: JSON.stringify(submitData),
    headers: {
        "content-type": "application/json"
        },
    method: "POST"
    })
    .then((resp) => {
        if(resp.ok){
            alert("La soiree à été crée sans problème");
        }else{
                console.log(resp.status +" " + resp.body);
            alert("Problème lors de la création de la soiree");
        }
    });
    }
    
}


export function listenerSoireeForm(){
document.querySelector('#ajouterSoiree').addEventListener('click', getInfoSoireeForm);
}
