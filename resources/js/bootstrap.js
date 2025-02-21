window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */
import Echo from "laravel-echo";
import Pusher from "pusher-js";
window.Pusher = require("pusher-js");

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    wsHost: window.location.hostname,
    wsPort: 6001,
    forceTLS: false,
    disableStats: true,
    enabledTransports: ['ws', 'wss'],
});


// import Echo from "laravel-echo";
// import Pusher from "pusher-js";

// const token = localStorage.getItem("auth_token");

// window.Pusher = require("pusher-js");

// window.Echo = new Echo({
//     broadcaster: "pusher",
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true,
//     authEndpoint: "/broadcasting/auth",
//     auth: {
//         withCredentials: true,
//         headers: {
//             "Accept": "application/json",
//             "Authorization": `Bearer ${token}`,
//             "X-CSRF-TOKEN": document.head.querySelector('meta[name="csrf-token"]').content
//         }
//     }
// });


// import Echo from "laravel-echo";
// import Pusher from "pusher-js";

// // Usa el Websockets en vez de Pusher
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: "pusher",
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true,
//     wsHost: window.location.hostname,
//     wsPort: 6001,  // Usualmente el puerto por defecto de websockets
//     disableStats: true
// });
