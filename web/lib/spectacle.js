import Handlebars from "handlebars";
const URL_API = 'http://localhost:44010';
const URI_SPECTACLES = '/spectacles?page=0&nombre=12';
const TEMPLATE_CONCERTS = Handlebars.compile(document.querySelector("#templateConcerts").innerHTML);
const TEMPLATE_SPECTACLE = Handlebars.compile(document.querySelector("#templateSpectacle").innerHTML);
const TEMPLATE_SOIREE = Handlebars.compile(document.querySelector("#templateSoiree").innerHTML);

let pagination = 0;

function showLoader() {
    const loader = document.getElementById("loader");
    if (loader) {
        loader.style.display = "block";
    }
}

function hideLoader() {
    const loader = document.getElementById("loader");
    if (loader) {
        loader.style.display = "none";
    }
}

function renderTemplate(template, data) {
    const main = document.querySelector('main');
    main.innerHTML = ''; // Очищаем <main>
    main.innerHTML = template(data); // Рендерим данные через шаблон
}

// Функция для загрузки данных и рендеринга списка концертов
function loadConcerts() {
    // Показать индикатор загрузки
    showLoader();

    // Рендерим основной шаблон для концертов и фильтров
    renderTemplate(TEMPLATE_CONCERTS);

    const NEW_URI_SPECTACLES = `/spectacles?page=${pagination}&nombre=12`;
    fetch(URL_API + NEW_URI_SPECTACLES)
        .then((resp) => resp.json())
        .then((data) => {
            // Рендерим каждый концерт с помощью TEMPLATE_SPECTACLE в контейнер `#liste-concert`
            const listeConcertContainer = document.getElementById('liste-concert');
            listeConcertContainer.innerHTML = ''; // Очищаем контейнер
            data.forEach(item => {
                listeConcertContainer.innerHTML += TEMPLATE_SPECTACLE(item);
            });

            // Обновляем пагинацию и устанавливаем обработчики событий
            document.getElementById('actuelle').textContent = pagination;
            setEventListeners();
        })
        .catch((err) => console.error("Erreur lors de la récupération des spectacles:", err))
        .finally(() => hideLoader()); // Скрыть индикатор загрузки
}

// Функция для установки всех необходимых обработчиков событий после рендеринга
function setEventListeners() {
    // Пагинация
    document.getElementById("Pre").addEventListener("click", () => handlePaginationChange(-1));
    document.getElementById("Suiv").addEventListener("click", () => handlePaginationChange(1));
    document.getElementById("retour-concert").addEventListener("click", resetToConcertList);

    // Обработчики для каждой кнопки в списке концертов
    document.querySelectorAll(".footer-concert-button").forEach((e) => {
        e.addEventListener("click", () => {
            afficheSoiree(e.dataset.id);
        });
    });
}

// Пагинация: обработка кнопок "Pre" и "Suiv"
function handlePaginationChange(step) {
    pagination += step;
    pagination = Math.max(pagination, 0); // Не разрешаем отрицательные значения
    loadConcerts(); // Перезагружаем данные с новой страницей
}

// Функция для загрузки и отображения данных soirée
function afficheSoiree(idSpectacles) {
    showLoader();
    const uri = `${URL_API}/spectacles/${idSpectacles}/soirees`;
    fetch(uri)
        .then((resp) => resp.json())
        .then((data) => {
            renderTemplate(TEMPLATE_SOIREE, { soiree: data });
        })
        .catch((err) => console.error("Erreur lors de la récupération des soirees :", err))
        .finally(() => hideLoader());
}

// Функция для возврата к списку концертов без сброса пагинации
function resetToConcertList() {
    loadConcerts(); // Перезагружаем концерты с текущей страницей
}

// Экспортируемая функция для запуска списка концертов
export function afficheSpectacles() {
    loadConcerts(); // Загружаем и рендерим список концертов
}
