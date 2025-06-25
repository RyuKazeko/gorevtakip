$(document).ready(function () {
    const loggedInUser = localStorage.getItem("loggedInUser");
    const userRole = localStorage.getItem("userRole");

    if (!loggedInUser || userRole !== "user") {
        window.location.href = "login.html"; // Redirect to login if not logged in
    }

    // Additional user-specific JavaScript can go here
});