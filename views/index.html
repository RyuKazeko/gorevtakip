<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <img src="logo.jpeg" alt="logo" width="200" height="200">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Görev Takip</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Görev Takip</h1>
        <div id="loginContainer" class="text-center">
            <h2>Giriş Yap</h2>
            <input type="text" id="mail" placeholder="Mail adresi" class="form-control my-2" required>
            <input type="password" id="password" placeholder="Şifre" class="form-control my-2" required>
            <button id="loginBtn" class="btn btn-primary">Giriş Yap</button>
        </div>

        <div id="userPanel" class="d-none">
            <h3>User</h3>
            <h4>Kullanıcı Bilgileri</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>İsim</th>
                        <th>Soyisim</th>
                        <th>Tamamlanan Görevler</th>
                        <th>Tamamlanmamış Görevler</th>
                        <th>Puan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" class="form-control" id="userName"></td>
                        <td><input type="text" class="form-control" id="userSurname"></td>
                        <td><input type="number" class="form-control" id="completedTasks"></td>
                        <td><input type="number" class="form-control" id="undoneTasks"></td>
                        <td><input type="number" class="form-control" id="userScore"></td>
                    </tr>
                </tbody>
            </table>
            <button id="submitUserInfo" class="btn btn-success">Kaydet ve Görevler</button>

            <div id="userTaskPanel" class="mt-4">
                <h4>Görevler</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Başlangıç Tarihi</th>
                            <th>Bitiş Tarihi</th>
                            <th>Gönderim Tarihi</th>
                            <th>Görev Başlığı</th>
                            <th>Detaylar</th>
                            <th>Durum</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="date" class="form-control"></td>
                            <td><input type="date" class="form-control"></td>
                            <td><input type="date" class="form-control"></td>
                            <td><input type="text" class="form-control"></td>
                            <td><input type="text" class="form-control"></td>
                            <td>
                                <select class="form-select">
                                    <option value="in-progress">Devam Ediyor</option>
                                    <option value="completed">Tamamlandı</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div id="adminPanel" class="d-none">
            <h3>Admin</h3>
            <h4>Admin Bilgileri</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>İsim</th>
                        <th>Soyisim</th>
                        <th>Geçerli Atanan Görevler</th>
                        <th>Atanan Görevler</th>
                        <th>Tamamlanan Görevler</th>
                        <th>Tamamlanmamış Görevler</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" class="form-control" aria-label="ara" id="adminName"></td>
                        <td><input type="text" class="form-control" id="adminSurname"></td>
                        <td><input type="number" class="form-control" id="currentAssignedTasks"></td>
                        <td><input type="number" class="form-control" id="assignedTasks"></td>
                        <td><input type="number" class="form-control" id="completedAdminTasks"></td>
                        <td><input type="number" class="form-control" id="incompletedAdminTasks"></td>
                    </tr>
                </tbody>
            </table>
            <button id="submitAdminInfo" class="btn btn-success">Kaydet ve Görevler</button>

            <div id="adminTaskPanel" class="mt-4">
                <h4>Görevler</h4>
                <div class="text-side mt-3 text-end">
                    <button id="addTaskBtn" class="btn btn-success btn-sm">Ekle</button>
                </div>
                <table class="table table-bordered" id="taskTable">
                    <thead>
                        <tr>
                            <th>Başlık</th>
                            <th>Durumu</th>
                            <th>Atanan</th>
                            <th>Başlangıç Tarihi</th>
                            <th>Bitiş Tarihi</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dynamic task rows will be added here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal for Adding Task -->
    <div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTaskModalLabel">Yeni Görev Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="taskForm">
                        <div class="mb-3">
                            <label for="taskTitle" class="form-label">Başlık</label>
                            <input type="text" class="form-control" id="taskTitle" required>
                        </div>
                        <div class="mb-3">
                            <label for="taskDetails" class="form-label">Detaylar</label>
                            <textarea class="form-control" id="taskDetails" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="taskStatus" class="form-label">Durumu</label>
                            <select class="form-select" id="taskStatus" required>
                                <option value="in-progress">Devam Ediyor</option>
                                <option value="completed">Tamamlandı</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="taskAssigned" class="form-label">Atanan</label>
                            <input type="text" class="form-control" id="taskAssigned" required>
                        </div>
                        <div class="mb-3">
                            <label for="taskStartDate" class="form-label">Başlangıç Tarihi</label>
                            <input type="date" class="form-control" id="taskStartDate" required>
                        </div>
                        <div class="mb-3">
                            <label for="taskEndDate" class="form-label">Bitiş Tarihi</label>
                            <input type="date" class="form-control" id="taskEndDate" required>
                        </div>
                        <button type="button" class="btn btn-primary" id="submitTaskBtn">Ekle</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>

</html>