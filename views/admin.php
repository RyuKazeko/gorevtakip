<?php session_start() ?>
<!DOCTYPE html>
<html lang="tr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Profili - Görev Takip</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
  </head>

  <body>
    <div class="container mt-5">
      <h1 class="text-center">Admin Profili</h1>
      <div>
        <h3>Admin Paneli</h3>
        <!-- Admin Profile Content -->
        <p>Hoş geldiniz, <?php echo $_SESSION["currentLogin"]["name"]?>!</p>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>Başlık</th>
              <th>Durum</th>
              <th>Atanan</th>
              <th>Başlangıç Tarihi</th>
              <th>Bitiş Tarihi</th>
              <th>Eylemler</th>
            </tr>
          </thead>
          <tbody id="adminTaskList"></tbody>
        </table>
      </div>
    </div>
    <script src="admin.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>


$(document).ready(function () {
    const adminTaskList = document.getElementById("adminTaskList");
    loadAdminTasks("garo");

});

function reformatDate(date){
    const options = {
  year: 'numeric',
  month: 'numeric',
  day: 'numeric',
  hour: "2-digit",
  minute: "2-digit"
}; 
  return date.toLocaleDateString("tr-TR",options);
}

async function createTaskElement(taskId, task) {
    const row = document.createElement('tr');

    task.dateStart = reformatDate(new Date(task.dateStart));
    task.dateEnd = reformatDate(new Date(task.dateEnd) );

    row.innerHTML = `
        <td>${task.title}</td>
        <td><span class="status-badge">${task.taskStatus}</span></td>
        <td>${task.assignedTo} </td>
        <td>${task.dateStart}</td>
        <td>${task.dateEnd || '-'}</td>
    `;
    return row;
}
async function loadAdminTasks(email) {
    var assignedTasks;
    await $.ajax({
        method: "POST",
        url: "../client/adminTasks.php",
        data: {
            mail: email
        }
    })
        .done(function (response) {
            if (!response) {
                alert("Atadığınız bir görev bulunmamakta")
            } else {
                assignedTasks = JSON.parse(response);
                let alel;
                assignedTasks.forEach(task => {
                    alel += task.title
                });
            }
        });
    adminTaskList.innerHTML = '';
    for (var task of assignedTasks) {
        const taskElement = await createTaskElement(task.id, task);
        adminTaskList.appendChild(taskElement);
    }
}

    </script>
  </body>
</html>
