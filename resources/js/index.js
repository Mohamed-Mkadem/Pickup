import "./bootstrap";

// import Alpine from "alpinejs";

// window.Alpine = Alpine;

// Alpine.start();

const notificationSound = document.getElementById("notification-sound");
const notificationsHandler = document.getElementById("notifications-handler");
const notificationsWrapper = document.getElementById("notifications-wrapper");
var channel = Echo.private(`App.Models.User.${user_id}`);
channel.notification(function (data) {
    let notificationModal = document.createElement("div");
    notificationModal.className = "notification-modal show";
    let notificationModalWrapper = document.createElement("div");
    notificationModalWrapper.className =
        "notification-modal-wrapper p-1 d-flex j-start gap-1 a-start";
    let img = document.createElement("img");
    img.className = "notification-modal-img";
    img.src = `${baseUrl}storage/${data.image}`;

    notificationModalWrapper.append(img);
    let notificationModalBody = document.createElement("p");
    notificationModalBody.textContent = data.body;
    notificationModalWrapper.append(notificationModalBody);
    let link = document.createElement("a");
    link.className = "notification-modal-link";
    link.href = data.url;
    notificationModalWrapper.append(link);
    notificationModal.append(notificationModalWrapper);
    document.body.append(notificationModal);

    notificationSound.play();

    notificationsHandler.classList.add("has-notifications");
    notificationsHandler.dataset.count =
        parseInt(notificationsHandler.dataset.count) + 1;
    setTimeout(function () {
        notificationModal.classList.remove("show");
    }, 5000);
    console.log(data);
    // let url = `${baseUrl}${prefix.toLowerCase()}/getNotifications`;
    // fetch(url)
    //     .then((response) => response.text())
    //     .then((html) => {
    //         // Replace the existing component HTML with the updated HTML
    //         let notificationMenu = document.getElementById("notification-menu");
    //         notificationMenu.innerHTML = html;
    //         // addEventListenersToDropdowns();

    //     })
    //     .catch((error) => {
    //         console.error("Failed to fetch notifications:", error);
    //     });

    createNotification(data);
});
function createNotification(data) {
    // Create the elements
    const notification = document.createElement("li");
    notification.className = "notification unread";

    const img = document.createElement("img");
    img.src = `${baseUrl}storage/${data.image}`;
    img.alt = "";

    const details = document.createElement("div");
    details.className = "details";

    const body = document.createElement("p");
    body.className = "notification-body";
    const link = document.createElement("a");
    link.href = ` ${data.url}?notification_id=${data.id}`;
    link.textContent = data.body;
    body.appendChild(link);

    const time = document.createElement("p");
    time.className = "notification-time";
    const timeIcon = document.createElement("i");
    timeIcon.className = "fa-light fa-timer";
    const timestamp = new Date(data.created_at * 1000); // Convert timestamp to milliseconds
    const formattedTime = timestamp.toLocaleString("en-US", {
        month: "long",
        day: "numeric",
        year: "numeric",
        hour: "numeric",
        minute: "numeric",
        hour12: true,
    });
    time.innerHTML = `${timeIcon.outerHTML} ${formattedTime}`;

    // Append elements
    details.appendChild(body);
    details.appendChild(time);

    notification.appendChild(img);
    notification.appendChild(details);

    // Prepend the notification to notificationsWrapper

    notificationsWrapper.prepend(notification);

    // Check if there are more than 4 notifications and remove the last one
    const notifications =
        notificationsWrapper.getElementsByClassName("notification");
    if (notifications.length > 4) {
        notifications[notifications.length - 1].remove();
    }
}
