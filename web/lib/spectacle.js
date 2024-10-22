// import {URL_API} from "./constantes.js";
import Handlebars from "handlebars";
const URL_API = 'http://localhost:44010';
const URI_SPECTACLES = '/spectacles';
const TEMPLATE_SPECTACLE =  Handlebars.compile(
    document.querySelector("#templateSpectacle").innerHTML);
const TEMPLATE_SOIREE = Handlebars.compile(
document.querySelector("#templateSoiree").innerHTML);


export function afficheSpectacles(){
// console.log("affiche spectacle");
    
    fetch(URL_API + URI_SPECTACLES)
        .then( (resp) => resp.json( ))
        .then( (data)=>{ 
            // console.log(data);
            data.forEach(function(val){
            document.querySelector('#liste-soiree').innerHTML += TEMPLATE_SPECTACLE(val);
            });
        }).then(()=>{
            document.querySelectorAll(".concerts").forEach((e) => {
                e.addEventListener("click",()=>{afficheSoiree(e.querySelector('input').value);});
      });

        });
}

function afficheSoiree(idSpectacles){
console.log('affiche soiree ' + idSpectacles);
    let uri = URL_API + '/spectacles/'+ idSpectacles + '/soirees';
    console.log(uri);
    fetch(uri)
        .then( (resp) => resp.json())
        .then( (data) => {
            data.forEach((val)=>{
                let insertion = document.querySelector('#liste-soiree');
                insertion.innerHTML = "";
                insertion.innerHTML+= TEMPLATE_SOIREE(val);
            });
        });
}

