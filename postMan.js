const webpush = require('web-push');

// Set up VAPID keys
const vapidKeys = {
    publicKey: 'YOUR_VAPID_PUBLIC_KEY',
    privateKey: 'YOUR_VAPID_PRIVATE_KEY'
};

// Store subscription information
app.post('/api/subscribe', (req, res) => {
    const subscription = req.body;
    // Store subscription information in your database
    db.storeSubscription(subscription);
    res.sendStatus(201);
});

// Send push notification
app.post('/api/send-notification', (req, res) => {
    const notification = req.body;
    const subscription = db.getSubscription(notification.userId);
    webpush.sendNotification(subscription, notification.payload, {
        vapidDetails: {
            subject: 'mailto:your_email@example.com',
            publicKey: vapidKeys.publicKey,
            privateKey: vapidKeys.privateKey
        }
    })
        .then(() => res.sendStatus(201))
        .catch(error => console.error(error));
});