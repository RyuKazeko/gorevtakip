$(document).ready(function () {
  // Check if user is already logged in
  const loggedInUser = localStorage.getItem("loggedInUser");
  const userRole = localStorage.getItem("userRole");

  if (loggedInUser) {
    $("#loginContainer").addClass("d-none");
    if (userRole === "user") {
      $("#userPanel").removeClass("d-none");
    } else if (userRole === "admin") {
      $("#adminPanel").removeClass("d-none");
    }
  }

  $("#loginBtn").on("click", function () {
    const mailField = document.getElementById("mail");
    const passwordField = document.getElementById("password");
    const mail = $("#mail").val();
    const password = $("#password").val();
    if (loginCheck(mail, password)) {
      alert("logged in!")
    } else {
        mailField.val = "";
        passwordField.val = "";
    }
    /*
        // Predefined credentials
        const userCredentials = {
            mail: "user",
            password: "userpass"
        };

        const adminCredentials = {
            mail: "admin",
            password: "adminpass"
        };

        // Check credentials
        if (mail === userCredentials.mail && password === userCredentials.password) {
            localStorage.setItem('loggedInUser', 'true');
            localStorage.setItem('userRole', 'user');
            $('#loginContainer').addClass('d-none');
            $('#userPanel').removeClass('d-none');
        } else if (mail === adminCredentials.mail && password === adminCredentials.password) {
            localStorage.setItem('loggedInUser', 'true');
            localStorage.setItem('userRole', 'admin');
            $('#loginContainer').addClass('d-none');
            $('#adminPanel').removeClass('d-none');
        } else {
            alert("Geçersiz kullanıcı adı veya şifre.");
        }
            */
  });
  /*
        // User info submission
        $('#submitUserInfo').on('click', function () {
            $('#userTaskPanel').removeClass('d-none');
        });
    */
  // Admin info submission
  $("#submitAdminInfo").on("click", function () {
    //$('#adminTaskPanel').removeClass('d-none');
    alert(localStorage.getItem("userRole"));
  });

  // Show Add Task Modal
  $("#addTaskBtn").on("click", function () {
    $("#addTaskModal").modal("show");
  });
  // Add new task
  $("#submitTaskBtn").on("click", function () {
    const title = $("#taskTitle").val();
    const details = $("#taskDetails").val();
    const status = $("#taskStatus").val();
    const assigned = $("#taskAssigned").val();
    const startDate = $("#taskStartDate").val();
    const endDate = $("#taskEndDate").val();

    const newRow = `
            <tr>
                <td>${title}</td>
                <td>${status}</td>
                <td>${assigned}</td>
                <td>${startDate}</td>
                <td>${endDate}</td>
                <td>
                    <button class="btn btn-info btn-sm viewDetails">Detaylar</button>
                    <button class="btn btn-danger btn-sm deleteTask">Sil</button>
                </td>
            </tr>
        `;

    $("#taskTable tbody").append(newRow);
    $("#addTaskModal").modal("hide");
    $("#taskForm")[0].reset(); // Reset the form
  });

  // View task details
  $(document).on("click", ".viewDetails", function () {
    const row = $(this).closest("tr");
    const title = row.find("td:eq(0)").text();
    const status = row.find("td:eq(1)").text();
    const assigned = row.find("td:eq(2)").text();
    const startDate = row.find("td:eq(3)").text();
    const endDate = row.find("td:eq(4)").text();

    alert(
      `Başlık: ${title}\nDurum: ${status}\nAtanan: ${assigned}\nBaşlangıç Tarihi: ${startDate}\nBitiş Tarihi: ${endDate}`
    );
  });

  // Delete task
  $(document).on("click", ".deleteTask", function () {
    $(this).closest("tr").remove();
  });

  // Clear local storage on page unload
  $(window).on("beforeunload", function () {
    sessionStorage.removeItem("loggedInUser");
    localStorage.removeItem("userRole");
  });
});

async function loginCheck(mail, password) {
  $.ajax({
    method: "POST",
    async: false,
    url: "client/loginCheck.php",
    data: {
      mail: mail,
      password: password,
    },
  }).done(function (response) {
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
  });
}
async function loadTasks() {
  await $.ajax({
    method: "POST",
    url: "/client/adminTasks.php",
    data: {
      mail: mail,
    },
  }).done(function (response) {
    if (!response) {
      alert("Sorun");
    } else {
      console.log(response);
    }
  });
}
