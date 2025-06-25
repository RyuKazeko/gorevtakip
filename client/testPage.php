<?php
include("conn.php");
?>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Başlık</th>
                <th>Açıklama</th>
                <th>Notlar</th>
                <th>Durum</th>
                <th>Atanan</th>
                <th>Başlangıç Tarihi</th>
                <th>Bitiş Tarihi</th>
                <th>Eylemler</th>
            </tr>
        </thead>
        <tbody id="adminTaskList"></tbody>
    </table>
    <button name="post" id="post">POST BUTTON</button>
    <button name="statusButton" id="statusButton">statusButton</button>
    <button name="mailButton" id="mailButton">Mail Button</button>
    <script>
        const adminTaskList = document.getElementById("adminTaskList");
        loadAdminTasks("garo");
        async function createTaskElement(taskId, task) {
            const row = document.createElement('tr');
            row.innerHTML = `
        <td>${task.title}</td>
        <td>${task.description || '-'}</td>
        <td>${task.notes || '-'}</td>
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
                    url: "adminTasks.php",
                    data: {
                        mail: email
                    }
                })
                .done(function(response) {
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
        var poster = document.getElementById("post");
        poster.addEventListener("click",addTask);
        async function addTask() {
            await $.ajax({
                    method: "POST",
                    url: "createTask.php",
                })
                .done(function(response) {
                    if (!response) {
                        alert("Atadığınız bir görev bulunmamakta")
                    } else {
                        console.log(response);
                    }
                });
        };
        var statusButton = document.getElementById("statusButton");
        statusButton.addEventListener("click",updateStatus);

        async function updateStatus() {
            await $.ajax({
                method: "POST",
                url: "changeTaskStatus.php"
            }).done(function(response){
                if(!response){
                    alert("mission failed");
                }
                else{
                    alert(response);
                }
            })
        }
        var mailButton = document.getElementById("mailButton");
        mailButton.addEventListener("click",sendMail);
        async function sendMail(){
            await $.ajax({
                method: "POST",
                url: "mailer.php"
            }).done(function(response){
                if(!response){
                    alert("mission failed");
                }
                else{
                    alert(response);
                }
            })
        }
    </script>
</body>

</html>