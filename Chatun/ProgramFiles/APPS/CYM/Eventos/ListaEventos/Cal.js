document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');

  var calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    initialDate: '2023-11-12',

    eventDidMount: function(info) {
      var tooltip = new Tooltip(info.el, {
        title: info.event.extendedProps.description,
        placement: 'top',
        trigger: 'hover',
        container: 'body'
      });
    },

    events: [
      {
        title: 'All Day Event',
        description: 'description for All Day Event',
        start: '2023-11-01'
      },
      {
        title: 'Long Event',
        description: 'description for Long Event',
        start: '2023-11-07',
        end: '2023-11-10'
      },
      {
        groupId: '999',
        title: 'Repeating Event',
        description: 'description for Repeating Event',
        start: '2023-11-09T16:00:00'
      },
      {
        groupId: '999',
        title: 'Repeating Event',
        description: 'description for Repeating Event',
        start: '2023-11-16T16:00:00'
      },
      {
        title: 'Conference',
        description: 'description for Conference',
        start: '2023-11-11',
        end: '2023-11-13'
      },
      {
        title: 'Meeting',
        description: 'description for Meeting',
        start: '2023-11-12T10:30:00',
        end: '2023-11-12T12:30:00'
      },
      {
        title: 'Lunch',
        description: 'description for Lunch',
        start: '2023-11-12T12:00:00'
      },
      {
        title: 'Meeting',
        description: 'description for Meeting',
        start: '2023-11-12T14:30:00'
      },
      {
        title: 'Birthday Party',
        description: 'description for Birthday Party',
        start: '2023-11-13T07:00:00'
      },
      {
        title: 'Click for Google',
        description: 'description for Click for Google',
        url: 'https://google.com/',
        start: '2023-11-28'
      }
    ]
  });

  calendar.render();
});