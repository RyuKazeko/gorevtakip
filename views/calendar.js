var taskData = [];
var taskList = [];
loadAdminTasks("atafanii@indiatimes.com");
taskData.forEach(function(task){
            taskList.push({start: task.dateStart,loco:"parabara", end: task.dateEnd, resourceId:1, title: task.title,color: getRandomColor()});
        })
const ec = EventCalendar.create(document.getElementById('ec'), {
        view: 'timeGridWeek',
        headerToolbar: {
            start: 'prev,next today',
            center: 'title',
            end: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek resourceTimeGridWeek,resourceTimelineWeek'
        },
        resources: [
            {id: 1, title: 'Resource A'},
            {id: 2, title: 'Resource B'}
        ],
        scrollTime: '09:00:00',
        events: createEvents(),
        views: {
            timeGridWeek: {pointer: true},
            resourceTimeGridWeek: {pointer: true},
            resourceTimelineWeek: {
                slotDuration: '00:15',
                slotLabelInterval: '01:00',
                slotMinTime: '09:00',
                slotMaxTime: '21:00',
                slotWidth: 16,
                resources: [
                    {id: 1, title: 'Resource A'},
                    {id: 2, title: 'Resource B'},
                    {id: 3, title: 'Resource C'},
                    {id: 4, title: 'Resource D'},
                    {id: 5, title: 'Resource E'},
                    {id: 6, title: 'Resource F'},
                    {id: 7, title: 'Resource G'},
                    {id: 8, title: 'Resource H'},
                    {id: 9, title: 'Resource I', children: [
                        {id: 10, title: 'Resource J'},
                        {id: 11, title: 'Resource K'},
                        {id: 12, title: 'Resource L', children: [
                            {id: 13, title: 'Resource M'},
                            {id: 14, title: 'Resource N'},
                            {id: 15, title: 'Resource O'}
                        ]}
                    ]}
                ]
            }
        },
        dayMaxEvents: true,
        nowIndicator: true,
        selectable: true,
        eventClick: function(info){
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
        let days = [];
        for (let i = 0; i < 7; ++i) {
            let day = new Date();
            let diff = i - day.getDay();
            day.setDate(day.getDate() + diff);
            days[i] = day.getFullYear() + "-" + _pad(day.getMonth()+1) + "-" + _pad(day.getDate());
        }
        
        return taskList;    
        /*
        return [
            {start: days[0] + " 00:00", end: days[0] + " 09:00", resourceId: 1, display: "background"},
            {start: days[1] + " 12:00", end: days[1] + " 14:00", resourceId: 2, display: "background"},
            {start: days[2] + " 17:00", end: days[2] + " 24:00", resourceId: 1, display: "background"},
            {start: days[0] + " 10:00", end: days[0] + " 14:00", resourceId: 1, title: "The calendar can display background and regular events", color: "#FE6B64"},
            {start: days[1] + " 16:00", end: days[2] + " 08:00", resourceId: 2, title: "An event may span to another day", color: "#B29DD9"},
            {start: days[2] + " 09:00", end: days[2] + " 13:00", resourceId: 2, title: "Events can be assigned to resources and the calendar has the resources view built-in", color: "#779ECB"},
            {start: days[3] + " 14:00", end: days[3] + " 20:00", resourceId: 1, title: "", color: "#FE6B64"},
            {start: "2025-06-25" + " 15:00", end: "2025-06-28" + " 12:00", resourceId: 1, title: "Overlapping events are positioned properly", color: "#779ECB"},
            {start: days[5] + " 10:00", end: days[5] + " 16:00", resourceId: 2, title: {html: "You have complete control over the <i><b>display</b></i> of events…"}, color: "#779ECB"},
            {start: days[5] + " 14:00", end: days[5] + " 19:00", resourceId: 2, title: "…and you can drag and drop the events!", color: "#FE6B64"},
            {start: days[5] + " 18:00", end: days[5] + " 21:00", resourceId: 2, title: "", color: "#B29DD9"},
            {start: days[1], end: days[3], resourceId: 1, title: "All-day events can be displayed at the top", color: "#B29DD9", allDay: true}
        ];*/
    }
    
    function _pad(num) {
        let norm = Math.floor(Math.abs(num));
        return (norm < 10 ? '0' : '') + norm;
    }

  function loadAdminTasks(email) {
    return $.ajax({
        method: "POST",
        async: false,
        url: "../client/adminTasks.php",
        data: {
            mail: email
        },
        success: function(response){
         taskData = JSON.parse(response);
        }
    })
}
