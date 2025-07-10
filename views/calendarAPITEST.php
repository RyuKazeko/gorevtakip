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
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/google-calendar@6.1.18/index.global.min.js"></script>
    <main class="row">
        <div id='calendar' style="width: 100%;"></div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/google-apis@1.0.0/lib/index.min.js"></script>
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
                //events: taskList,
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
                slotDuration: '24:00:00',
                nowIndicator: false,
                googleCalendarApiKey: 'AIzaSyDC_M_ByVX88DNrM7taMhC8QfjNDxf5i_0',
                events: 'a08f0f28d06c8db1e11a9d432f61d5b4fab2233e390e3c47a7da5db083f1463f@group.calendar.google.com'

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
        fuckGoogleApi();
        async function fuckGoogleApi() {
            $.ajax({
                method: "POST",
                async: false,
                url: "https://www.googleapis.com/calendar/v3/calendars/3d83ccea1093320d6b6308c5e869281252246d76f5d2f4178a41a77b6bc886a5@group.calendar.google.com/events",
                calendarId: "3d83ccea1093320d6b6308c5e869281252246d76f5d2f4178a41a77b6bc886a5@group.calendar.google.com",
                start: {
                    date: "2025-07-11",
                    timezone: "Europe/Istanbul"
                },
                end: {
                    date: "2025-07-12",
                    timezone: "Europe/Istanbul"
                },
                success: function(response) {
                    alert("shiii");
                }
            })
        }
    </script>
</body>

</html>