<?php session_start() ?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Profili - Görev Takip</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="admin.css" />
    <style>
        .icobutt {
            font-family: 'Bootstrap-icons';
        }

        #notifiList {
            list-style: none;
            padding: 0;
            margin: 0;
            background-color: #222222;
            border: 1px solid #FFA500;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(255, 165, 0, 0.2);
            color: #fff;
        }

        #notifiList li {
            padding: 10px;
            border-bottom: 1px solid #FFA500;
        }

        #notifiList li:last-child {
            border-bottom: none;
        }

        #notifiList a {
            color: #fff;
            text-decoration: none;
        }

        #notifiList a:hover {
            color: #FFA500;
        }
    </style>
</head>

<body>
    <svg class="theme-svg-bg" viewBox="0 0 1920 1080" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path class="animated-sine moving-fig" d="M0 540 Q 320 270, 640 540 T 1280 540 T 1920 540" stroke="#aab6ff" stroke-width="6" fill="none" />
        <polygon class="moving-fig2" points="300,900 500,600 700,900" stroke="#aab6ff" stroke-width="5" fill="none" />
        <circle class="moving-fig3" cx="1600" cy="300" r="120" stroke="#aab6ff" stroke-width="5" fill="none" />
        <path class="moving-fig" d="M0 700 Q 160 900, 320 700 T 640 700 T 960 700 T 1280 700 T 1600 700 T 1920 700" stroke="#aab6ff" stroke-width="4" fill="none" />
        <ellipse class="moving-fig2" cx="1000" cy="200" rx="80" ry="40" stroke="#aab6ff" stroke-width="4" fill="none" />
        <rect class="moving-fig3" x="1400" y="800" width="180" height="80" rx="20" stroke="#aab6ff" stroke-width="4" fill="none" />
        <polygon class="moving-fig4" points="900,900 950,850 1000,900 1000,970 950,1020 900,970" stroke="#aab6ff" stroke-width="5" fill="none" />
        <polygon class="moving-fig5" points="400,200 420,250 475,255 435,290 445,345 400,320 355,345 365,290 325,255 380,250" stroke="#aab6ff" stroke-width="5" fill="none" />
    </svg>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.0/css/smoothness/jquery-ui-1.10.0.custom.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.0/jquery-ui.js"></script>
    <script src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.13.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script src="..\node_modules\tinymce\tinymce.min.js" referrerpolicy="origin"></script>

    <div class="container mt-5">
        <h1 class="text-center subtitle">Admin Profili</h1>
        <div>
            <p class="subtitle">Hoş geldiniz, <?php echo $_SESSION["currentLogin"]["name"] ?>!</p>
            <button name="cikis" class="btn btn-indigo" id="logout" onClick="location.href='../client/logout.php';">ÇIKIŞ YAP</button>
            <button class="btn btn-indigo dropdown-toggle" id="notifications-button" data-bs-toggle="dropdown" aria-expanded="false">Bildirimler</button>
            <ul class="dropdown-menu" id="notifiList" aria-labelledby="notifications-button">
                <!-- Add dropdown list items here -->
                <li><a class="dropdown-item" href="#">Notification 1</a></li>
                <li><a class="dropdown-item" href="#">Notification 2</a></li>
            </ul>
            <div class="text-end mb-3">
                <button class="btn btn-indigo me-2" data-bs-toggle="modal" data-bs-target="#taskModal">Ekle</button>
                <div class="d-flex d-md-none justify-content-center mb-4" style="margin-top: 1cm;">
                    <div class="row w-100">
                        <div class="col-6 pe-1">
                            <button class="btn btn-indigo w-100" data-bs-toggle="modal" data-bs-target="#taskModal">
                                <span class="icobutt">&#xF4CB;</span> Ekle
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Başlık</th>
                        <th>Durum</th>
                        <th>Öncelik</th>
                        <th>Atanan</th>
                        <th>Başlangıç Tarihi</th>
                        <th>Bitiş Tarihi</th>
                        <th>Işlemler</th>
                    </tr>
                </thead>
                <tbody id="adminTaskList"></tbody>
            </table>
        </div>
        <nav aria-label="Görev Sayfalama">
            <ul class="pagination" id="taskPagination"></ul>
        </nav>
    </div>
    </div>

    <!-- Mobil için kart görünümü -->
    <div class="d-block d-md-none">
        <div id="adminTaskCards" class="task-cards"></div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <div id="EaddTaskModal"></div>
    <div id="EdetailsModal"></div>
    <div id="EreportModal"></div>
    <div id="EnotifiModal"></div>
    <script>
        var userList = [];
        var allTasks = []; // Tüm görevleri saklamak için
        var currentPage = 1;
        var tasksPerPage = 10;

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
            var person = document.createElement("datalist");
            person.setAttribute("id", "userlist");
            await userListData.forEach(function(user) {
                var option = document.createElement("option");
                option.value = user.mail;
                person.appendChild(option);
            })
            parent.appendChild(person);
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
                $("#EnotifiModal").load("notifiModal.html");
            });
            const adminTaskList = document.getElementById("adminTaskList");
            loadAdminTasks("garo");
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
    <td><span class="status-badge">${task.taskStatus}</span></td>
    <td>${task.priority}</td>
    <td>${task.assignedTo}</td>
    <td>${task.dateStart}</td>
    <td>${task.dateEnd || '-'}</td>
    <td>
    <div class="d-flex flex-wrap justify-content-center">
            <button class="btn btn-darkblue btn-sm icobutt m-1" onclick="viewDetails(${taskId},'${task.title}')" title="Detaylar">&#xF33E<\/button>
            <button class="btn btn-success btn-sm icobutt m-1 reportButton" onClick="reply_click(this)" id="${taskId}" data-bs-toggle="modal" data-bs-target="#reportModal" title="Rapor">
                &#xF26E
            <\/button>
            <button class="btn btn-indigo btn-sm icobutt m-1" onclick="cancelTask(${taskId})" title="İptal">&#xF445<\/button>
        </div>
    </td>
    `;
            return row;
        }

        async function loadAdminTasks(email) {
            await $.ajax({
                    method: "POST",
                    url: "../client/adminTasks.php"
                })
                .done(function(response) {
                    if (!response) {
                        alert("Atadığınız bir görev bulunmamakta");
                        allTasks = [];
                    } else {
                        allTasks = JSON.parse(response);
                    }
                });

            // Sayfalama oluştur
            createPagination();

            // İlk sayfayı göster
            showPage(1);
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

        function reply_click(subBut) {
            var butId = subBut.getAttribute("id");
            var idKeeper = document.getElementById("taskIdKeeper");
            idKeeper.setAttribute("taskid", butId);
        }
        async function createTaskCard(taskId, task) {
            var card = document.createElement('div');
            card.className = 'task-card';

            task.dateStart = reformatDate(new Date(task.dateStart));
            task.dateEnd = reformatDate(new Date(task.dateEnd));

            card.innerHTML = `
                <div class="task-card-header">${task.title}</div>
                                


                <div class="task-card-row">
                    <div class="task-card-label">Durum:</div>
                    <div class="task-card-value"><span class="status-badge">${task.taskStatus}</span></div>
                </div>
                
                <div class="task-card-row">
                    <div class="task-card-label">Öncelik:</div>
                    <div class="task-card-value">${task.priority}</div>
                </div>

                <div class="task-card-row">
                    <div class="task-card-label">Atanan:</div>
                    <div class="task-card-value">${task.assignedTo}</div>
                </div>
                
                <div class="task-card-row">
                    <div class="task-card-label">Başlangıç:</div>
                    <div class="task-card-value">${task.dateStart}</div>
                </div>
                
                <div class="task-card-row">
                    <div class="task-card-label">Bitiş:</div>
                    <div class="task-card-value">${task.dateEnd || '-'}</div>
                </div>
                
                <div class="task-card-actions">
                    <button class="btn btn-darkblue icobutt" onclick="viewDetails(${taskId},'${task.title}')" title="Detaylar">
                        &#xF33E; Detaylar
                    </button>
                    <button class="btn btn-success icobutt reportButton" onClick="reply_click(this)" id="${taskId}" data-bs-toggle="modal" data-bs-target="#reportModal" title="Rapor">
                        &#xF26E; Rapor
                    </button>
                    <button class="btn btn-indigo icobutt" onclick="cancelTask(${taskId})" title="İptal">
                        &#xF445; İptal
                    </button>
                </div>
            `;

            return card;
        }

        function createPagination() {
            const totalPages = Math.ceil(allTasks.length / tasksPerPage);
            const pagination = document.getElementById('taskPagination');
            pagination.innerHTML = '';

            // Önceki sayfa butonu
            const prevLi = document.createElement('li');
            prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
            prevLi.innerHTML = `<a class="page-link" href="#" onclick="changePage(${currentPage - 1})">Önceki</a>`;
            pagination.appendChild(prevLi);

            // Sayfa numaraları
            for (let i = 1; i <= totalPages; i++) {
                const li = document.createElement('li');
                li.className = `page-item ${currentPage === i ? 'active' : ''}`;
                li.innerHTML = `<a class="page-link" href="#" onclick="changePage(${i})">${i}</a>`;
                pagination.appendChild(li);
            }

            // Sonraki sayfa butonu
            const nextLi = document.createElement('li');
            nextLi.className = `page-item ${currentPage === totalPages || totalPages === 0 ? 'disabled' : ''}`;
            nextLi.innerHTML = `<a class="page-link" href="#" onclick="changePage(${currentPage + 1})">Sonraki</a>`;
            pagination.appendChild(nextLi);
        }

        // Sayfa değiştir
        function changePage(page) {
            if (page < 1 || page > Math.ceil(allTasks.length / tasksPerPage) || page === currentPage) {
                return;
            }

            currentPage = page;
            showPage(currentPage);
            createPagination();

            // Sayfanın üstüne kaydır
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // Belirli bir sayfayı göster
        async function showPage(page) {
            // Masaüstü tablo görünümü için
            const adminTaskList = document.getElementById("adminTaskList");
            adminTaskList.innerHTML = '';

            // Mobil kart görünümü için
            const adminTaskCards = document.getElementById("adminTaskCards");
            adminTaskCards.innerHTML = '';

            // Sayfa için görevleri hesapla
            const startIndex = (page - 1) * tasksPerPage;
            const endIndex = Math.min(startIndex + tasksPerPage, allTasks.length);
            var sortedTasks = allTasks.slice().sort(function(a, b) {
                return b.priority - a.priority;
            });
            sortedTasks = allTasks.slice(startIndex, endIndex);

            // Görevleri ekle
            for (var task of sortedTasks) {
                // Tablo görünümü için satır oluştur
                var taskElement = await createTaskElement(task.id, task);
                adminTaskList.appendChild(taskElement);

                // Kart görünümü için kart oluştur
                var taskCard = await createTaskCard(task.id, task);
                adminTaskCards.appendChild(taskCard);
            }
        }
        loadNotifis();

        function loadNotifis() {
            $.ajax({
                method: "POST",
                url: "../client/getNotifis.php",
                success: function(response) {
                    var notifis = JSON.parse(response);
                    var notifiList = document.getElementById("notifiList");
                    notifiList.innerHTML = '';
                    for (var notifi of notifis) {
                        var notifiElement = document.createElement("li");
                        var notifiContent = document.createElement("a");
                        notifiElement.className = "list-group-item";
                        notifiContent.href = "#notifiModal";
                        notifiContent.setAttribute("data-bs-target", "#notifiModal");
                        notifiContent.innerHTML = notifi.title;
                        notifiContent.setAttribute("data-bs-toggle", "modal");
                        notifiElement.appendChild(notifiContent);
                        notifiList.appendChild(notifiElement);
                    }
                }
            });
        }
    </script>
</body>

</html>