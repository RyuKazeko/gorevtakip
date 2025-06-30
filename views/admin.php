<?php session_start() ?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Profili - Görev Takip</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="popper.css" />
    <style>
        .icobutt {
            font-family: 'Bootstrap-icons';
        }

        .tooltip {
            position: relative;
            display: inline-block;
            border-bottom: 1px dotted black;
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: 120px;
            background-color: black;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px 0;

            /* Position the tooltip */
            position: absolute;
            z-index: 1;
        }

        .tooltip:hover .tooltiptext {
            visibility: visible;
        }
    </style>
</head>

<body>
    <script src="https://cdn.jsdelivr.net/npm/@floating-ui/core@1.7.2"></script>
    <script src="https://cdn.jsdelivr.net/npm/@floating-ui/dom@1.7.2"></script>
    <button id="button" aria-describedby="tooltip">My button</button>
    <div id="tooltip" role="tooltip">
        Tamamla
        <div id="arrow" data-popper-arrow></div>
    </div>
    <div class="container mt-5">
        <h1 class="text-center">Admin Profili</h1>
        <div>
            <h3>Admin Paneli</h3>
            <p>Hoş geldiniz, <?php echo $_SESSION["currentLogin"]["name"] ?>!</p>

            <div class="text-end mb-3">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#taskModal">Ekle</button>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Başlık</th>
                        <th>Durum</th>
                        <th>Atanan</th>
                        <th>Başlangıç Tarihi</th>
                        <th>Bitiş Tarihi</th>
                        <th>Işlemler</th>
                    </tr>
                </thead>
                <tbody id="adminTaskList"></tbody>
            </table>
        </div>
    </div>

    <div id="EaddTaskModal"></div>
    <div id="EdetailsModal"></div>


    <script>
        function reformatDate(date) {
            const options = {
                year: 'numeric',
                month: 'numeric',
                day: 'numeric',
                hour: "2-digit",
                minute: "2-digit"
            };
            return date.toLocaleDateString("tr-TR", options);
        }
        var taskCache = {};
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
            const adminTaskList = document.getElementById("adminTaskList");
            loadAdminTasks("garo");
            $("#saveTaskButton").on("click", async function() {
                    const newTask = {
                        title: $("#taskTitle").val(),
                        details: $("#taskDescription").val(),
                        assignedTo: $("#assignedTo").val(),
                        taskStatus: $("#taskStatus").val(),
                        dateStart: $("#dateStart").val(),
                        dateEnd: $("#dateEnd").val(),
                    };

                    await assignNewTask(newTask);
                    $("#taskModal").modal('hide');
                    loadAdminTasks("garo"); // Reload the tasks
                }

            );
        });
        $(function() {
            $("#EaddTaskModal").load("addTaskModal.html");
            $("#EdetailsModal").load("detailsModal.html");
        });
        async function createTaskElement(taskId, task) {
            var row = document.createElement('tr');
            task.dateStart = reformatDate(new Date(task.dateStart));
            task.dateEnd = reformatDate(new Date(task.dateEnd));
            row.innerHTML = `   
                <td>${task.title}</td>
                <td><span class="status-badge">${task.taskStatus}</span></td>
                <td>${task.assignedTo}</td>
                <td>${task.dateStart}</td>
                <td>${task.dateEnd || '-'}</td>
            <td>
            <button class="btn btn-info btn-sm" onclick="viewDetails(${taskId},'${task.title}')">Details</button>
            <button class="btn btn-danger btn-sm me-1" onclick="cancelTask(${taskId})">Sil</button>
            <button class="btn btn-success btn-sm me-1 icobutt" data-placement="bottom" data-toggle="tooltip" data-placement="top" title="Tamamla" onclick="completeTask(${taskId})">
            &#xF26E
            </button>
           </td>
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
                .done(function(response) {
                    if (!response) {
                        alert("Atadığınız bir görev bulunmamakta");
                    } else {
                        assignedTasks = JSON.parse(response);
                    }
                });

            adminTaskList.innerHTML = '';
            for (var task of assignedTasks) {
                var taskElement = await createTaskElement(task.id, task);
                adminTaskList.appendChild(taskElement);
            }
        }

        async function assignNewTask(task) {
            await $.ajax({
                method: "POST",
                url: "../client/createTask.php",
                data: {
                    taskData: task
                },
                success: function(response) {
                    alert(response);
                }
            });
        }

        function completeTask(taskId) {
            $.ajax({
                method: "POST",
                url: "../client/changeTaskStatus.php",
                data: {
                    id: taskId,
                    option: "Tamamlandı"
                },
                success: function(response) {
                    alert(response);
                    loadAdminTasks();
                }
            })
        }

        function cancelTask(taskId) {
            // Implement the logic to delete the task
            if (confirm("Bu görevi iptal etmek istediğinizden emin misiniz?")) {
                // Make an AJAX call to delete the task
                $.ajax({
                    method: "POST",
                    url: "../client/changeTaskStatus.php",
                    data: {
                        id: taskId,
                        option: "iptal"
                    },
                    success: function(response) {
                        alert(response);
                        loadAdminTasks();
                    }
                })
            }
        }

        function viewDetails(taskId, title) {
            if (taskCache[taskId]) {
                $("#detailsModalText").html(taskCache[taskId]);
                $("#detailsModalLabel").html(title);
                $('#detailsModal').modal('show');
            } else {
                $.ajax({
                    method: "POST",
                    url: "../client/getDetails.php",
                    data: {
                        taskId: taskId
                    },
                    success: function(response) {
                        taskCache[taskId] = response;
                        $("#detailsModalText").html(response);
                        $("#detailsModalLabel").html(title);
                        $('#detailsModal').modal('show');
                    }
                })
            }

        }
    </script>
    <script src="popperCode.js"></script>
</body>

</html>