

$(document).ready(function () {
    const adminTaskList = document.getElementById("adminTaskList");
    loadAdminTasks("garo");

});

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