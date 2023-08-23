import '../css/app.scss';
import { Dropdown } from 'bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    enableDropdownsOnHover();
}); // Calls the function when the document is completely downloaded

const enableDropdownsOnHover = () => {
    const dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));

    dropdownElementList.forEach(function (dropdownToggleEl) {
        const dropdown = new Dropdown(dropdownToggleEl);

        dropdownToggleEl.addEventListener('mouseenter', function () {
            if (!dropdown._element.classList.contains('show')) {
                dropdown.show();
            }
        }); // Open dropdown when mouse enters menu

        const dropdownMenu = dropdown._menu;
        if (dropdownMenu) {
            const dropdownLinks = dropdownMenu.querySelectorAll('a');
            dropdownLinks.forEach(link => {
                link.addEventListener('click', function (event) {
                    event.stopPropagation(); // Prevents click propagation to parent
                }); // Avoid closing the dropdown if the user clicks on a link
            });

            dropdownMenu.addEventListener('mouseleave', function () {
                if (dropdown._element.classList.contains('show')) {
                    dropdown.hide();
                }
            }); // Close dropdown when mouse leaves menu
        }
    });
};
