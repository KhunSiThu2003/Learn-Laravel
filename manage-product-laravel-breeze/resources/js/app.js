import './bootstrap';
import Alpine from 'alpinejs';
import { Notyf } from 'notyf';
import 'notyf/notyf.min.css';

window.Alpine = Alpine;
Alpine.start();

// Add CSS to prevent wrapping
const style = document.createElement('style');
style.textContent = `
    /* Prevent Notyf text wrapping */
    .notyf__toast {
        min-width: fit-content !important;
        width: auto !important;
    }
    
    .notyf__message {
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        display: block !important;
    }
`;
document.head.appendChild(style);

// Initialize Notyf
const notyf = new Notyf({
    duration: 2000,
    position: {
        x: 'right',
        y: 'bottom',
    },
    types: [
        {
            type: 'success',
            background: '#22C55E',
        },
        {
            type: 'error',
            background: '#EF4444',
        }
    ]
});

window.notyf = notyf;