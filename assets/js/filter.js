import '../css/app.scss';
import 'jquery';
import 'bootstrap-multiselect';


document.addEventListener('DOMContentLoaded', () => {
    // Votre code ici, par exemple :
    $('#multiple-checkboxes').multiselect({
        includeSelectAllOption: true,
    });
});