const schedule = document.getElementById('timeslots'); // Le conteneur des créneaux

const hours = ['16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00', '00:00', '01:00', '02:00', '03:00'];
const days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];

const events = [{
        name: "Réunion",
        day: "Lundi",
        startTime: "16:00",
        endTime: "19:00"
    },
    {
        name: "Cours de danse",
        day: "Mardi",
        startTime: "18:00",
        endTime: "20:00"
    },
    {
        name: "Dîner",
        day: "Samedi",
        startTime: "19:00",
        endTime: "20:00"
    }
];

function addEventsToSchedule() {
    events.forEach(event => {
        // Trouver le créneau horaire de début de l'événement
        let startSlot = document.querySelector(`.slot[data-time="${event.startTime}"][data-day="${event.day}"]`);

        // Calculer la durée de l'événement
        let startHour = parseInt(event.startTime.split(':')[0], 10);
        let endHour = parseInt(event.endTime.split(':')[0], 10);
        let duration = endHour - startHour; // Durée en heures

        if (duration > 0) {
            // Calculer l'indice du créneau central
            let middleIndex = Math.floor(duration / 2);

            // Ajouter l'événement aux créneaux concernés
            for (let i = 0; i < duration; i++) {
                const currentHour = startHour + i;
                const slot = document.querySelector(`.slot[data-time="${currentHour}:00"][data-day="${event.day}"]`);

                if (slot) {
                    // Appliquer le style d'événement
                    slot.style.backgroundColor = "#3ADDE2";
                    slot.classList.add('event');

                    // Placer le nom de l'événement au créneau central
                    if (i === middleIndex) {
                        slot.textContent = event.name;
                    } else {
                        slot.textContent = ''; // Laisser vide les autres créneaux
                    }
                }
            }
        }
    });
}


window.onload = function() {
    const schedule = document.getElementById('schedule'); // Le conteneur des créneaux

    if (schedule) {
        // Générer les créneaux horaires ici
        hours.forEach((hour) => {
            // Crée une nouvelle ligne pour chaque heure
            const row = document.createElement('div');
            row.classList.add('row');

            // Crée l'étiquette de temps (time label)
            const timeLabel = document.createElement('div');
            timeLabel.classList.add('time-label');
            timeLabel.textContent = hour;
            row.appendChild(timeLabel);

            // Crée les créneaux pour chaque jour
            days.forEach((day) => {
                const slot = document.createElement('div');
                slot.classList.add('slot');
                slot.dataset.time = hour; // Stocke l'heure dans les données du slot
                slot.dataset.day = day; // Stocke le jour dans les données du slot


                row.appendChild(slot); // Ajoute le créneau à la ligne
            });

            schedule.appendChild(row); // Ajoute la ligne complète à l'emploi du temps
        });

        // Ajouter les événements
        addEventsToSchedule();
    } else {
        console.error("L'élément avec l'ID 'timeslots' est introuvable.");
    }
};