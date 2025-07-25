// Register service worker
navigator.serviceWorker.register('sw.js')
    .then(registration => {
        // Request permission for push notifications
        return registration.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: 'YOUR_VAPID_PUBLIC_KEY'
        });
    })
    .then(subscription => {
        // Store subscription information on your server
        fetch('/api/subscribe', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(subscription)
        });
    });