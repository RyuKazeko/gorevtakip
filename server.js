const http = require('http');
const express = require('express');
const app = express();

http.createServer((req, res) => {
    if (req.url === '/api/subscribe') {
        const subscription = req.body;
        console.log('Subscription:', subscription);
        res.writeHead(201, { 'Content-Type': 'text/plain' });
        res.end('Subscription successful!');
    } else {
        res.writeHead(404, { 'Content-Type': 'text/plain' });
        res.end('Not found!');
    }
}).listen(3000, () => {
    console.log('Server listening on port 3000');
});

app.post('/api/subscribe', (req, res) => {
    const subscription = req.body;
    console.log('Subscription:', subscription);
    // Store the subscription information in your database or handle it as needed
    res.status(201).send('Subscription successful!');
});

app.listen(3000, () => {
    console.log('Server listening on port 3000');
});