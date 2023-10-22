import * as noUiSlider from 'nouislider';
import 'nouislider/dist/nouislider.css';

/*// Créez un slider noUiSlider
const priceSlider = document.getElementById('price-slider');
const minPriceSpan = document.getElementById('min-price');
const maxPriceSpan = document.getElementById('max-price');*/
// Search button click
document.getElementById("search").addEventListener("click", () => {
    // Initializations
    let searchInput = document.getElementById("search-input").value.trim().toUpperCase(); //trim() permet d'enlever les blancs puis convertit la valeur en majuscules
    let cards = document.querySelectorAll(".card"); //recuperer les cartes dans le dom

    // Loop through all cards
    cards.forEach(card => {
        let titleElement = card.querySelector(".card-body");
        if (titleElement) {
            let cardTitle = titleElement.innerText.toUpperCase();
            if (cardTitle.includes(searchInput)) {
                card.classList.remove("d-none");
            } else {
                card.classList.add("d-none");
            }
        }
    });
});

/*noUiSlider.create(priceSlider, {
    start: [500, 100000], // Valeurs initiales
    connect: true,
    range: {
        'min': 500,
        'max': 100000
    }
});*/

// Mettre à jour le filtrage lorsque les curseurs sont déplacés
/*priceSlider.noUiSlider.on('update', function (values, handle) {
    const minPrice = parseInt(values[0]);
    const maxPrice = parseInt(values[1]);

    // Mettez à jour les valeurs affichées
    minPriceSpan.textContent = minPrice + ' €';
    maxPriceSpan.textContent = maxPrice + ' €';

    // Filtrez les offres en fonction des nouvelles valeurs du curseur
    filterOffers(minPrice, maxPrice);
    console.log('filterOffers called');
});

// Fonction pour filtrer les annonces
function filterOffers(minPrice, maxPrice) {
    const cardPrices = document.querySelectorAll('.card-price');
    cardPrices.forEach(function (cardPrice) {
        const price = parseInt(cardPrice.textContent);
        const card = cardPrice.closest('.card');
        if (price >= minPrice && price <= maxPrice) {
            card.style.display = 'block';
        } else {
            card.style.display = 'd-none';
        }
    });
}*/
// Initially display all products
window.onload = () => {

    let cards = document.querySelectorAll(".card"); //recuperer les cartes dans le dom
    cards.forEach(card => {
        card.classList.remove("d-none");
    });
};










