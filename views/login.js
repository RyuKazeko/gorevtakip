$(document).ready(function () {
});
$("#loginBtn").on("click", function () {
        const mailField = document.getElementById("mail");
        const passwordField = document.getElementById("password");
        const mail = $("#mail").val();
        const password = $("#password").val();

        loginCheck(mail, password).then(response =>{
            if(response === "vertified"){
                createSession(mail);
            }
        })});
function createSession(mail){
    return $.ajax({
        method: "POST",
        async: false,
        url: "../client/session.php",
        data:{
            mail: mail
        },
        success: function(response){
            window.location.href = response;
        }
    })

}

function loginCheck(mail, password) {
    return $.ajax({
        method: "POST",
        async: false,
        url: "../client/loginCheck.php",
        data: {
            mail: mail,
            password: password,
        },
        success: function (response) {
            switch (response) {
                case "vertified":
                    alert("Başarılı");
                    return true;
                    break;
                case "wrong pass":
                    alert("Yanlış şifre girdiniz.");
                    return false;
                    break;

                case "not found":
                    alert("Email adresiniz bulunamadı!");
                    return false;
                    break;
            }
        }
    });
}