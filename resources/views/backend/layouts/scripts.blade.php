<script type="module">
    // 1. Initialize the array
    let notifications = [];

    // 2. Load stored notifications as soon as the page loads
    $(document).ready(function() {
        loadStoredNotifications();
    });

    window.Echo.channel('admin-notifications')
   .listen('.AdminNotification', (e) => {
    console.log("Notification received:", e); // Add this to debug!
    handleIncomingNotification(e);
});

    function handleIncomingNotification(data) {
        // Add new notification to the beginning of the array
        notifications.unshift(data);
        
        addNotificationToUI(data);
        updateNotificationCount();
        playNotificationSound();
        
        // Save the updated array to LocalStorage
        saveNotifications();
    }

function addNotificationToUI(data) {
    let label = '';
    if (data.type === 'contact') { label = 'sent a message'; } 
    else if (data.type === 'order') { label = 'placed a new order'; }
    else if (data.type === 'newsletter') { label = 'joined newsletter'; }

    // Use the timestamp from the server, or fallback to "Just now" if missing
    let displayTime = data.created_at ? moment(data.created_at).format('h:mm A') : 'Just now';

    let html = `
    <li class="notification-message">
        <a href="javascript:void(0);">
            <div class="media d-flex">
                <span class="avatar flex-shrink-0">
                    <img src="/backend/assets/img/profiles/avatar-02.jpg">
                </span>
                <div class="media-body flex-grow-1">
                    <p class="noti-details">
                        <span class="noti-title">${data.title}</span> ${label}
                    </p>
                    <p class="noti-time">
                        <span class="notification-time">${displayTime}</span>
                    </p>
                </div>
            </div>
        </a>
    </li>
    `;

    $('#notification-list').prepend(html);
}

    function updateNotificationCount() {
        $('#notification-count').text(notifications.length);
    }

    function playNotificationSound() {
        let sound = document.getElementById("notificationSound");
        if (sound) {
            sound.play().catch(() => {});
        }
    }

    $('#clearNotifications').on('click', function () {
        // Clear the array, the UI, and the LocalStorage
        notifications = [];
        $('#notification-list').html('');
        updateNotificationCount();
        localStorage.removeItem('admin_notifications');
    });

    // --- NEW FUNCTIONS FOR PERSISTENCE --- //

    function saveNotifications() {
        // Convert the array to a JSON string and save it
        localStorage.setItem('admin_notifications', JSON.stringify(notifications));
    }

    function loadStoredNotifications() {
        // Retrieve the JSON string from LocalStorage
        let stored = localStorage.getItem('admin_notifications');
        
        if (stored) {
            // Parse it back into a JavaScript array
            notifications = JSON.parse(stored);
            
            // Re-build the UI
            $('#notification-list').html('');
            
            // We loop backwards because addNotificationToUI uses .prepend()
            // This ensures they render in the correct original order
            for (let i = notifications.length - 1; i >= 0; i--) {
                addNotificationToUI(notifications[i]);
            }
            
            updateNotificationCount();
        }
    }
</script>