var taskData = [];
var taskList = [];
loadUserTasks();
taskData.forEach(function (task) {
    taskList.push({ start: task.dateStart, id: task.id, end: task.dateEnd, resourceId: 1, title: task.title, color: getRandomColor() });
})
const ec = EventCalendar.create(document.getElementById('ec'), {
    view: 'timeGridWeek',
    headerToolbar: {
        start: 'prev,next today',
        center: 'title',
        end: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek resourceTimeGridWeek,resourceTimelineWeek'
    },
    resources: [
        { id: 1, title: 'Resource A' },
        { id: 2, title: 'Resource B' }
    ],
    scrollTime: '09:00:00',
    events: createEvents(),
    views: {
        timeGridWeek: { pointer: true },

        resourceTimeGridWeek: { pointer: true },
        resourceTimelineWeek: {
            slotDuration: '00:15',
            slotLabelInterval: '01:00',
            slotMinTime: '09:00',
            slotMaxTime: '21:00',
            slotWidth: 16,
            resources: [
                { id: 1, title: 'Resource A' },
                { id: 2, title: 'Resource B' },
                { id: 3, title: 'Resource C' },
                { id: 4, title: 'Resource D' },
                { id: 5, title: 'Resource E' },
                { id: 6, title: 'Resource F' },
                { id: 7, title: 'Resource G' },
                { id: 8, title: 'Resource H' },
                {
                    id: 9, title: 'Resource I', children: [
                        { id: 10, title: 'Resource J' },
                        { id: 11, title: 'Resource K' },
                        {
                            id: 12, title: 'Resource L', children: [
                                { id: 13, title: 'Resource M' },
                                { id: 14, title: 'Resource N' },
                                { id: 15, title: 'Resource O' }
                            ]
                        }
                    ]
                }
            ]
        }
    },
    slotMinTime: '08:00',
    slotMaxTime: '18:00',
    dayMaxEvents: true,
    nowIndicator: true,
    editable: false,
    selectable: false,
    eventStartEditable: false,
    eventDurationEditable: false,
    eventClick: function (info) {
        console.log(info.event);
    }
});

function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}
function createEvents() {
    return taskList;
}

function loadUserTasks(email) {
    return $.ajax({
        method: "POST",
        async: false,
        url: "../client/userTasks.php",
        data: {
            mail: email
        },
        success: function (response) {
            taskData = JSON.parse(response);
        }
    })
}
