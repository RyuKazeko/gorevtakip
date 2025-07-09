<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />

    <title>EventCalendar</title>

    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png" />
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png" />
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png" />
    <link rel="manifest" href="site.webmanifest" />
    <link rel="stylesheet" href="global.css?20231021" />

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@event-calendar/build@4.4.1/dist/event-calendar.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/@event-calendar/build@4.4.1/dist/event-calendar.min.js"></script>

    <style>
        .ec-timeline .ec-time,
        .ec-timeline .ec-line {
            width: 16px;
        }

        .ec-timeline .ec-time {
            overflow: visible;
        }

        .ec-timeline .ec-time time {
            display: inline-block;
            width: 64px;
            text-align: center;
        }
    </style>
</head>

<body>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.18/index.global.min.js'></script>
    <main class="row">
        <div id='calendar' style="width: 100%;"></div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        var taskData = [];
        var taskList = [];
        <?php
        session_start();
        if ($_SESSION["currentLogin"]["role"] === "admin") {
            echo "loadAdminTasks();";
        } else {
            echo "loadUserTasks();";
        }


        ?>
        taskData.forEach(function(task) {
            taskList.push({
                start: task.dateStart,
                id: task.id,
                end: task.dateEnd,
                resourceId: 1,
                title: task.title
            });
        })
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 800,
                events: taskList,
                eventTimeFormat: { // like '14:30:00'
                    hour: '2-digit',
                    minute: '2-digit',
                    meridiem: false
                },
                headerToolbar: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'timeGridWeek,timeGridDay' // user can switch between the two
                },
                minTime: '08:30:00',
                maxTime: '17:00:00',
                slotDuration: '24:00:00',
                nowIndicator: false
            });
            calendar.render();
        });

        function loadAdminTasks() {
            return $.ajax({
                method: "POST",
                async: false,
                url: "../client/adminTasks.php",
                success: function(response) {
                    taskData = JSON.parse(response);
                }
            })
        }

        function loadUserTasks() {
            return $.ajax({
                method: "POST",
                async: false,
                url: "../client/userTasks.php",
                success: function(response) {
                    taskData = JSON.parse(response);
                }
            })
        }
    </script>
</body>

</html>