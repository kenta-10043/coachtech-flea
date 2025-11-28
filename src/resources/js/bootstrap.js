import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

import Echo from "laravel-echo";
import Pusher from "pusher-js";

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: "pusher",
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
});

document.addEventListener("DOMContentLoaded", () => {
    const userId = document.querySelector('meta[name="user-id"]').content;

    console.log("userId:", userId);

    // チャンネル購読
    window.Echo.private(`chat.${userId}`).listen(".MessageSent", (e) => {
        console.log("受信データ:", e);
    });
});
