$(document).ready(function() {
            const adminTaskList = document.getElementById("adminTaskList");
            loadAdminTasks("garo");
            $("#saveTaskButton").on("click", async function() {
                const newTask = {
                    title: $("#taskTitle").val(),
                    description: $("#taskDescription").val(),
                    assignedTo: $("#assignedTo").val(),
                    taskStatus: $("#taskStatus").val(),
                    dateStart: $("#dateStart").val(),
                    dateEnd: $("#dateEnd").val(),
                };

                await saveNewTask(newTask);
                $("#taskModal").modal('hide');
                loadAdminTasks("garo"); // Reload the tasks
            });
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
            <button class="btn btn-info btn-sm" onclick="viewDetails(${taskId})">Details</button>
            <button class="btn btn-danger btn-sm me-1" onclick="deleteTask(${taskId})">Sil</button>
           
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
                url: "../client/saveTask.php",
                data: task
            });
        }

        function cancelTask(taskId) {
            // Implement the logic to delete the task
            if (confirm("Bu görevi silmek istediğinizden emin misiniz?")) {
                // Make an AJAX call to delete the task
                $.ajax({
                    method: "POST",
                    url: "../client/deleteTask.php",
                    data: {
                        id: taskId
                    }
                }).done(function() {
                    loadAdminTasks("garo"); // Reload the tasks after deletion
                });
            }
        }

        function viewDetails(taskId) {
            // Implement the logic to view task details
            alert("Task ID: " + taskId); // Placeholder for actual details display
        }