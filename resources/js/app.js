import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import Swal from 'sweetalert2';
window.Swal = Swal;


Echo.channel('chat')
.listen('MessageSent', (e) => {
    Livewire.emit('messageSent', { user: e.user, message: e.message });
});