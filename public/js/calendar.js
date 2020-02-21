'use strict';

var fullcalendar = function () {

  var colorClass;

  function events() {
    $(document).on('click touchstart', '.event-color > li > a', function (e) {
      e.preventDefault();
      e.stopPropagation();

      colorClass = $(this).data('class');

      $('#event-color-btn').removeClass().addClass('text-' + colorClass);
    });

    $(document).on('click touchstart', '.add-event', function (e) {

      if (typeof colorClass === 'undefined') {
        colorClass = 'color';
      }

      var newEvent = $('.new-event').val(),
        markup = $('<div class="external-event label label-' + colorClass + '" data-class="bg-' + colorClass + '">' + newEvent + '</div>');

      if (newEvent !== '') {
        $('.external-events').append(markup);

        externalEvents(markup);

        $('.new-event').val('');
      }

      e.preventDefault();
      e.stopPropagation();
    });
  }

  function buttons() {

    $('#calendar-day > span').html($('.fc-agendaDay-button').html());

    $('#calendar-week > span').html($('.fc-agendaWeek-button').html());

    $('#calendar-month > span').html($('.fc-month-button').html());

    $('#calendar-today').html($('.fc-today-button').html());

    $('#calendar-prev').html($('.fc-prev-button').html());

    $('#calendar-next').html($('.fc-next-button').html());

    $(document).on('click touchstart', '#calendar-day', function (e) {

      e.preventDefault();

      $('#calendar').fullCalendar('changeView', 'agendaDay');

    });

    $(document).on('click touchstart', '#calendar-week', function (e) {

      e.preventDefault();

      $('#calendar').fullCalendar('changeView', 'agendaWeek');

    });

    $(document).on('click touchstart', '#calendar-month', function (e) {

      e.preventDefault();

      $('#calendar').fullCalendar('changeView', 'month');

    });

    $(document).on('click touchstart', '#calendar-today', function (e) {

      e.preventDefault();

      $('#calendar').fullCalendar('today');

      updateDate();
    });

    $(document).on('click touchstart', '#calendar-prev', function (e) {

      e.preventDefault();

      $('#calendar').fullCalendar('prev');

      updateDate();

    });

    $(document).on('click touchstart', '#calendar-next', function (e) {

      e.preventDefault();

      $('#calendar').fullCalendar('next');

      updateDate();

    });

  }

  function updateDate() {
    var moment = $('#calendar').fullCalendar('getDate');
    $('.week-day').html(moment.format('dddd'));
    $('.current-date').html(moment.format('MMM Do [<b>] YYYY [</b>]'));
  }

  function externalEvents(elm) {
    // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
    // it doesn't need to have a start or end
    var eventObject = {
      title: $.trim(elm.text()), // use the element's text as the event title
      className: elm.data('class')
    };

    // store the Event Object in the DOM element so we can get to it later
    elm.data('eventObject', eventObject);

    // make the event draggable using jQuery UI
    elm.draggable({
      zIndex: 999,
      revert: true, // will cause the event to go back to its
      revertDuration: 0 //  original position after the drag
    });
  }

  // initialize the external events
  function initCalendarEvents() {
    $('#external-events div.external-event').each(function () {
      externalEvents($(this));
    });
  }

  // initialize the calendar
  function initCalendar(mainevents) {
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth()+1; //January is 0!

    var yyyy = today.getFullYear();
    if(dd<10){
        dd='0'+dd;
    } 
    if(mm<10){
        mm='0'+mm;
    } 
    var today = yyyy+'-'+mm+'-'+dd;

   
       $('#calendar').fullCalendar({
        events: mainevents,
        header: {
            left: 'prev,next',
            center: 'prev title next',
            right: 'today,month,agendaWeek,agendaDay'
        },
        buttonIcons: {
        prev: ' ti-arrow-circle-left',
        next: ' ti-arrow-circle-right'
      },
        eventClick:  function(event, jsEvent, view) {
            $('#modalTitle').html(event.title);
           $("#startTime").html(moment(event.start).format('MMM Do h:mm A'));
            $("#endTime").html(moment(event.end).format('MMM Do h:mm A'));
             $("#arrivalTime").html(moment(event.arrival).format('MMM Do h:mm A'));
             $("#town").html(event.town);
             /*$("#duration")..html(moment(event.end - ).format('MMM Do h:mm A'));;*/
            $('#eventUrl').attr('href',event.url_nas);
            $('#fullCalModal').modal();
        }
    });
  }

  return {
    init: function () {
      events();
      initCalendarEvents();
      initCalendar(mainevents);
      buttons();
      updateDate();
    }
  };
}();

$(function () {
  fullcalendar.init(mainevents);
});
