import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css"; // Importa o CSS do Flatpickr

document.addEventListener('livewire:init', () => {
    Livewire.on('set-occupied-dates', (event) => {
        const occupiedDates = event[0];
        console.log('Datas Ocupadas:', occupiedDates);

        if (Array.isArray(occupiedDates)) {
            flatpickr("#start_date", {
                dateFormat: "Y-m-d",
                disable: occupiedDates,
            });

            flatpickr("#end_date", {
                dateFormat: "Y-m-d",
                disable: occupiedDates,
            });
        } else {
            console.error("Formato inesperado de occupiedDates:", occupiedDates);
        }
    });

    flatpickr("#start_date", {
        dateFormat: "Y-m-d",
    });

    flatpickr("#end_date", {
        dateFormat: "Y-m-d",
    });
});
