<?php session_start() ?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kullanıcı Profili - Görev Takip</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
    <style>
        .icobutt {
            font-family: 'Bootstrap-icons';
        }
    </style>
</head>

<body>
    <script src="..\node_modules\tinymce\tinymce.min.js" referrerpolicy="origin"></script>

    <link rel="stylesheet"
        href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.0/css/smoothness/jquery-ui-1.10.0.custom.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.0/jquery-ui.js"></script>
    <script src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>

    <div class="container mt-5">
        <h1 class="text-center">Kullanıcı Profili</h1>
        <div>
            <h3>Kullanıcı Paneli</h3>
            <p>Hoş geldiniz,
                <?php echo $_SESSION["currentLogin"]["name"] ?>!
            </p>
            <button name="cikis" class="btn btn-danger" id="logout"
                onClick="location.href='../client/logout.php';">ÇIKIŞ YAP</button>
            <div class="text-end mb-3">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#taskModal">Ekle</button>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reportModal">Rapor</button>

            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Başlık</th>
                        <th>Öncelik</th>
                        <th>Durum</th>
                        <th>Atayan</th>
                        <th>Başlangıç Tarihi</th>
                        <th>Bitiş Tarihi</th>
                        <th>Işlemler</th>
                    </tr>
                </thead>
                <tbody id="userTaskList"></tbody>
            </table>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <div id="EdetailsModal"></div>
    <div id="EreportModal"></div>

    <script>
        var userList = [];
        async function fillUserList() {
            var userListData = [];
            await $.ajax({
                method: "POST",
                url: "../client/getUserList.php",
                success: function(response) {
                    userListData = JSON.parse(response);
                }
            })

            var parent = document.getElementById("assignedTo");
            var brat = document.createElement("datalist");
            brat.setAttribute("id", "userlist");
            userListData.forEach(function(user) {
                var option = document.createElement("option");
                option.value = user.mail;
                brat.appendChild(option);
            })
            parent.appendChild(brat);
        }

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
            $(function() {
                $("#EaddTaskModal").load("addTaskModal.html");
                $("#EdetailsModal").load("detailsModal.html");
                $("#EreportModal").load("reportModal.html");
            });
            const userTaskList = document.getElementById("userTaskList");
            loadUserTasks("garo");
            fillUserList();
        });

        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });


        async function createTaskElement(taskId, task) {
            var row = document.createElement('tr');
            task.dateStart = reformatDate(new Date(task.dateStart));
            task.dateEnd = reformatDate(new Date(task.dateEnd));
            row.innerHTML = `
    <td>${task.title}</td>
    <td>${task.priority}</td>
    <td><span class="status-badge">${task.taskStatus}</span></td>
    <td>${task.assigner}</td>
    <td>${task.dateStart}</td>
    <td>${task.dateEnd || '-'}</td>
    <td>
        <button class="btn btn-info btn-sm icobutt" onclick="viewDetails(${taskId},'${task.title}')">&#xF33E</button>
       <button class="btn btn-success btn-sm me-1 icobutt reportButton" onClick="reply_click(this)" id="${taskId}" data-bs-toggle="modal" data-bs-target="#reportModal">
            &#xF26E
        </button>
        <button class="btn btn-danger btn-sm me-1 icobutt" onclick="cancelTask(${taskId})">&#xF445</button>
    </td>
    `;
            return row;
        }
        async function loadUserTasks(email) {
            var assignedTasks;
            await $.ajax({
                    method: "POST",
                    url: "../client/userTasks.php"
                })
                .done(function(response) {
                    if (!response) {
                        alert("Atadığınız bir görev bulunmamakta");
                    } else {
                        assignedTasks = JSON.parse(response);
                    }
                });

            userTaskList.innerHTML = '';
            var sortedTasks = assignedTasks.slice().sort(function(a, b) {
                return b.priority - a.priority;
            });
            for (var task of sortedTasks) {
                var taskElement = await createTaskElement(task.id, task);
                userTaskList.appendChild(taskElement);
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


        function submitReport(taskId) {
            completeTask(taskId)
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
                    loadUserTasks();
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
                        loadUserTasks();
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

        function reply_click(subBut) {
            var butId = subBut.getAttribute("id");
            var idKeeper = document.getElementById("taskIdKeeper");
            idKeeper.setAttribute("taskid", butId);
        }
    </script>
</body>

</html>