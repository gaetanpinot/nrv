import Handlebars from "handlebars";
import {URL_API, URI_ARTISTES,URI_SPECTACLES} from './settings.js';
const TEMPLATE_FORM_SPECTACLE = Handlebars.compile(
document.querySelector('#templateFormSpectacle').innerHTML);
let afficherSpectacleForm = function(){
    fetch(URL_API + URI_ARTISTES)
        .then((resp) => resp.json())
        .then((data) => {
            document.querySelector('main').innerHTML = TEMPLATE_FORM_SPECTACLE(data);
            document.querySelector('#formSpectacle').addEventListener('submit', submitSpectacleForm);
        });
}
let submitSpectacleForm = function(e){
event.preventDefault();
    let formData =e.target.elements;
    let getD = function($ch){
    return formData[$ch].value.trim();
    }
    let submitData= {
        titre : getD('titre'),
        description : getD('description'),
        url_image : getD('url_image'),
        url_video : getD('url_video')
    };
    let artistes =Array.from( e.target.querySelectorAll('.artistes'));
    // console.log(artistes);
    let checkedArtisteId = artistes.filter((artiste)=>artiste.checked).map((artiste)=> artiste.value);
    // console.log( checkedArtisteId);
    if (checkedArtisteId.length === 0){
        alert("Vous n'avez pas sellectioné d'artiste");
    }else{
    submitData.artistes= checkedArtisteId;
    fetch(URL_API + URI_SPECTACLES, {
    body: JSON.stringify(submitData),
    headers: {
        "content-type": "application/json"
        },
    method: "POST"
    })
    .then((resp) => {
        if(resp.ok){
            alert("Le spectacle à été crée sans problème");
        }else{
            alert("Problème lors de la création du spectacle");
        }
    });
    }
}
export function listenerSpectacleForm(){
document.querySelector('#ajouterSpectacle').addEventListener('click', afficherSpectacleForm);
}
