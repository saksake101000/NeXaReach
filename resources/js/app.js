import 'flowbite';
import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', function () {
    const menuButton = document.getElementById('menu-button');
    const dropdownMenu = document.getElementById('user-dropdown');
    
    // Toggle the visibility of the dropdown menu
    menuButton.addEventListener('click', function () {
        dropdownMenu.classList.toggle('hidden');
    });

    // Close the dropdown menu if clicked outside
    document.addEventListener('click', function (event) {
        if (!dropdownMenu.contains(event.target) && !menuButton.contains(event.target)) {
            dropdownMenu.classList.add('hidden');
        }
    });

    // Handle keyboard accessibility (ESC to close)
    menuButton.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            dropdownMenu.classList.add('hidden');
        }
    });
});
