import Echo from "laravel-echo";

import Pusher from "pusher-js";
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: "pusher",
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER ?? "mt1",
    forceTLS: true,
});

var channel = Echo.private(`App.Models.user.${user_id}`);
channel.notification(function (data) {
    console.log(JSON.stringify(data));
});
