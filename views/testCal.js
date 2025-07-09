import { Calendar } from '@fullcalendar/core'
import googleCalendarPlugin from '@fullcalendar/google-calendar'
import dayGridPlugin from '@fullcalendar/daygrid'

const calendarEl = document.getElementById('calendar')
const calendar = new Calendar(calendarEl, {
    plugins: [
        googleCalendarPlugin,
        dayGridPlugin
    ],
    initialView: 'dayGridMonth',
    events: {
        googleCalendarId: 'abcd1234@group.calendar.google.com'
    }
})

calendar.render()