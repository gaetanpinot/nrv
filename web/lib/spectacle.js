// import {URL_API} from "./constantes.js";
import Handlebars from "handlebars";
const URL_API = 'http://localhost:44010';
const URI_SPECTACLES = '/spectacles';
const TEMPLATE_SPECTACLE =  Handlebars.compile(
    document.querySelector("#templateSpectacle").innerHTML);


export function afficheSpectacles(){
// console.log("affiche spectacle");
    fetch(URL_API + URI_SPECTACLES)
        .then( (resp) => resp.json( ))
        .then( (data)=>{ 
            // console.log(data);
            data.forEach(function(val){
                console.log(val);
            document.querySelector('#liste-soiree').innerHTML += TEMPLATE_SPECTACLE(val);
            });
        });
}

