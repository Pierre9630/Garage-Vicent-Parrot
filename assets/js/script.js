
import noUiSlider from 'nouislider';

document.addEventListener("DOMContentLoaded", function() {
    //const sliderContainer = document.getElementById("sliderContainer");
    const priceSlider = document.getElementById("priceSlider");
    const minPriceInput = document.getElementById("minPrice");
    const maxPriceInput = document.getElementById("maxPrice");
    const minPriceLabel = document.getElementById("minPriceLabel");
    const maxPriceLabel = document.getElementById("maxPriceLabel");

    noUiSlider.create(priceSlider, {
        start: [0, 100000],
        connect: true,
        range: {
            'min': 0,
            'max': 100000
        }
    });

    priceSlider.noUiSlider.on('update', function (values) {
        // Arrondir les valeurs au nombre entier le plus proche
        const minPrice = Math.round(values[0]);
        const maxPrice = Math.round(values[1]);

        minPriceInput.value = minPrice;
        maxPriceInput.value = maxPrice;

        minPriceLabel.textContent = "Min: " +  Math.round(values[0]);
        maxPriceLabel.textContent = "Max: " + Math.round(values[1]);
    });
});

