const express = require('express');
const router = express.Router();

router.post('/', (req, res) => {
    const subscription = req.body;
    // Store subscription in database or send to push service
    res.json({ success: true });
});

module.exports = router;
