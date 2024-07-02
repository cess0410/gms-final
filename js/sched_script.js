    var calendar;
    var Calendar = FullCalendar.Calendar;
    var events = [];

    function initializeCalendar(eventsData) {
        calendar = new Calendar(document.getElementById('calendar'), {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek,list'
            },
            themeSystem: 'bootstrap',
            events: eventsData, // Initial events data
            eventClick: function(info) {
                // Handle event click as before
                var id = info.event.id;
                var _details = $('#event-details-modal');
                if (!!scheds[id]) {
                    _details.find('#title').text(info.event.title);
                    _details.find('#name').text(scheds[id].name);
                    _details.find('#specialty').text(scheds[id].specialty);
                    _details.find('#start_datetime').text(scheds[id].start_datetime);
                    _details.find('#end_datetime').text(scheds[id].end_datetime);
                    _details.find('#edit,#delete').attr('data-id', id);
                    _details.modal('show');
                } else {
                    alert("Event details not found.");
                }
            },
            eventDidMount: function(info) {
                // Additional actions after events are mounted
            },
            editable: true // Adjust as per your requirement
        });

        calendar.render();
    }
    $(function() {
        if (!!scheds) {
            Object.keys(scheds).map(k => {
                var row = scheds[k]
                events.push({ id: row.id, name: row.doctor, specialty: row.specialty, start_datetime: row.start_datetime, end_datetime: row.end_datetime });
            })
        }
        var date = new Date()
        var d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear()

        calendar = new Calendar(document.getElementById('calendar'), {
            headerToolbar: {
                left: 'prev,next today',
                right: 'dayGridMonth,dayGridWeek,list',
                center: 'title',
            },
            selectable: true,
            themeSystem: 'bootstrap',
            events: events,
            eventClick: function(info) {
                var _details = $('#event-details-modal')
                var id = info.event.id
                if (!!scheds[id]) {
                    _details.find('#title').text(scheds[id].title)
                    _details.find('#doctor').text(scheds[id].doctor)
                    _details.find('#specialty').text(scheds[id].specialty)
                    _details.find('#start_datetime').text(scheds[id].start_datetime)
                    _details.find('#end_datetime').text(scheds[id].end_datetime)
                    _details.find('#edit,#delete').attr('data-id', id)
                    _details.modal('show')
                    console.log("sadad")
                } else {
                    alert("Event is undefined");
                }
            },
            eventDidMount: function(info) {
            },
            editable: true
        });
        function fetchDoctorEvents(doctorId) {
            $.ajax({
                url: 'api/get_doctor_schedule.php',
                type: 'GET',
                data: {
                    doctor_id: doctorId
                },
                success: function(response) {
                    events = response;
                    calendar.removeAllEvents();
                    calendar.addEventSource(events);
                    calendar.refetchEvents();
                },
                error: function(xhr, status, error) {
                    console.log('Error fetching doctor schedule: ' + error);
                }
            });
        }
    
        // Initial load with default doctor (if any)
        var defaultDoctorId = $('#doctor').val();
        if (defaultDoctorId) {
            fetchDoctorEvents(defaultDoctorId);
        }
    
        // Event handler for doctor selection change
       
        initializeCalendar(events);




        // Render the calendar
        calendar.render();
    
        // Form reset handling
        $('#schedule-form').on('reset', function() {
            $(this).find('input:hidden').val('');
            $(this).find('input:visible').first().focus();
        });
    // });
        calendar.render();

        $('#schedule-form').on('reset', function() {
            $(this).find('input:hidden').val('')
            $(this).find('input:visible').first().focus()
        })


        $('#edit').click(function() {
            var id = $(this).attr('data-id')
            if (!!scheds[id]) {
                var _form = $('#schedule-form')
                console.log(String(scheds[id].start_datetime), String(scheds[id].start_datetime))
                _form.find('[name="id"]').val(id)
                _form.find('[name="title"]').val(scheds[id].title)
                _form.find('[name="doctor"]').val(scheds[id].doctor)
                _form.find('[name="specialty"]').val(scheds[id].specialty)
                _form.find('[name="start_datetime"]').val(String(scheds[id].start_datetime))
                _form.find('[name="end_datetime"]').val(String(scheds[id].end_datetime))
                $('#event-details-modal').modal('hide')
                _form.find('[name="title"]').focus()
            } else {
                alert("Event is undefined");
            }
        })

        // Delete Button / Deleting an Event
        $('#delete').click(function() {
            var id = $(this).attr('data-id')
            if (!!scheds[id]) {
                var _conf = confirm("Are you sure to delete this scheduled event?");
                if (_conf === true) {
                    location.href = "../api/delete_schedule.php?id=" + id;
                  

                }
            } else {
                alert("Event is undefined");
            }
        });

  



        // $(function() {
        //     var calendar;
        //     var Calendar = FullCalendar.Calendar;
        //     var events = [];
        
        //     // Initialize FullCalendar
            
        
       
           
  });