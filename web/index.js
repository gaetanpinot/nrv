<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/index.css">
    <script type="text/javascript" src="./js/index.js" defer></script>
    <title>NRV.net</title>
</head>

<body>

    <header>
        <div id="top">
            <h1>Nancy Rock Vibration</h1>
            <nav>

                <ul>
                    <li id="dropdown">
                        Filtré les répresentations
                        <ul id="filtre">
                            <li id="lieu">
                                <a href="index.html#liste-representation ">par lieux</a>
                            </li>
                            <li id="styles">
                                <a href="index.html#liste-representation ">par styles</a>
                            </li>
                            <li id="date">
                                <a href="index.html#liste-representation ">par date</a>
                            </li>

                        </ul>

                    </li>
                    <li>
                        <a href="index.html#edt" alt="emploie du temps ">edt</a>
                    </li>

                </ul>
                <ul>
                    <li id="logo-panier">
                        <img src="/img/panier.svg " alt="panier " onclick="window.location.href='panier.html'">
                    </li>
                    <li id="img-compte">
                        <img src="https://i.pravatar.cc/300 " alt="compte "
                            onclick="window.location.href='compte.html'">
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <div id="description">
            <strong class="creme">Nancy Rock Vibration</strong> est un événement musical palpitant qui se déroule sur 12
            soirées inoubliables, offrant une immersion totale dans l'univers du rock. Réparti dans 4 lieux
            emblématiques de la ville de Nancy,
            chaque lieu accueille 3 représentations uniques, chacune mettant en avant des artistes locaux et
            internationaux. Cependant, chaque soirée se concentre sur un seul lieu, permettant aux spectateurs de
            profiter d'une atmosphère immersive et d'une
            programmation spécialement sélectionnée pour l'endroit.<br>
            <strong class="creme">Nancy Rock Vibration</strong> promet de faire vibrer la ville avec des sons puissants,
            des performances en direct, et une énergie débordante pendant presque deux semaines de pur rock.
        </div>
        <div id="edt">
            <div id="schedule">
                <div class="entete">
                    <div class="time-label"></div>
                    <div class="day">Lundi</div>
                    <div class="day">Mardi</div>
                    <div class="day">Mercredi</div>
                    <div class="day">Jeudi</div>
                    <div class="day">Vendredi</div>
                    <div class="day">Samedi</div>
                    <div class="day">Dimanche</div>
                </div>


                <!-- Les créneaux horaires seront ajoutés ici en JavaScript -->
            </div>
        </div>


        <div id="liste-concert">

        </div>



    </main>
    <footer></footer>

    <script id="templateSoiree" type="text/x-handlebars-template">
        <article>
            <h3>Répresentation de la soirée</h3>

            <ul>
                <li>
                    <ul>
                        <li id="date">{{this.date}}</li>
                        <li id="lieux">{{this.lieu.nom}}</li>
                        <li id="heures">{{this.heure_debut}}</li>
                        <li id="style">{{this.theme.label}}</li>
                    </ul>
                </li>
                <li class="tarif">
                    <ul>
                        <li>Prix</li>
                        <li id="normal">Tarif normal: {{this.tarif_normal}}</li>
                        <li id="reduit">Tarif réduit: {{this.tarif_reduit}}</li>
                    </ul>
                </li>
                <li class="places">
                    <ul>
                        <li>Places restantes</li>
                        <li id="assises">{{this.nb_places_assises_restantes}} places assises</li>
                        <li id="debout">{{this.nb_places_debout_restantes}} places debout</li>
                    </ul>
                </li>
            </ul>
            <div id="grid-concerts">
                {{#each this.spectacles}}
                <div class="concerts" data-id="{{this.id}}">

                    <h4 class="title representation toggle">{{this.titre}}</h4>
                    <div class="info-concert">

                        <div class="description">
                            <ul class="artistes">
                                <h5>Avec :</h5>
                                {{#each this.artistes}}
                                <li>{{this.prenom}}</li>
                                {{/each}}
                            </ul>
                        </div>

                    </div>

                </div>
                {{/each}}
            </div>

        </article>
    </script>


    <script id="templateSpectacle" type="text/x-handlebars-template">
        <article>
            <div class="info-concert">
                <div class="concert-image">
                    <img src="{{this.url_image}} " alt="image concert ">
                </div>
                <h4 class="title representation toggle ">{{this.titre}}</h4>

                <div class="description ">
                    <p class="description-content ">{{this.description}}</p>
                    <ul class="artistes ">
                        <label>Avec :</label> {{#each this.artistes}}
                        <li>{{this.prenom}}</li>
                        {{/each}}
                    </ul>
                </div>

            </div>
            <button class="footer-concert-button" data-id="{{this.id}}">Soir ou ce concert est présent</button>

        </article>
    </script>




</body>

</html>