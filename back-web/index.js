import Handlebars from "handlebars";
const URL_API = "http://localhost:44014";
const URI_JAUGE = "/jauge";
const TEMPLATE_SOIREES = Handlebars.compile(
document.querySelector('#templateSoirees').innerHTML);
Handlebars.registerHelper('subtract', function (value1, value2) {
    return value1 - value2;
});
function getSoireeJauge(){
fetch(URL_API+URI_JAUGE).then((resp) => resp.json())
        .then((data) => {
            console.log(data);
                document.querySelector('#soirees').innerHTML = TEMPLATE_SOIREES(data);
        });


}
getSoireeJauge();
