    var calendar;
    var Calendar = FullCalendar.Calendar;
    var events = [];
    $(function() {
        if (!!scheds) {
            Object.keys(scheds).map(k => {
                var row = scheds[k]
                events.push({ id: row.id, name: row.name, specialty: row.specialty, sched_date: row.sched_date, am: row.am, pm: row.pm });
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
                    _details.find('#name').text(scheds[id].name)
                    _details.find('#specialty').text(scheds[id].specialty)
                    _details.find('#sched_date').text(scheds[id].sched_date)
                    _details.find('#am').text(scheds[id].am)
                    _details.find('#pm').text(scheds[id].pm)
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
        $('#doctor').change(function() {
            var selectedDoctorId = $(this).val();
            fetchDoctorEvents(selectedDoctorId);
        });
    
        // Render the calendar
        calendar.render();
    
        // Form reset handling
        $('#schedule-form').on('reset', function() {
            $(this).find('input:hidden').val('');
            $(this).find('input:visible').first().focus();
        });
    });
        // calendar.render();

        // $('#schedule-form').on('reset', function() {
        //     $(this).find('input:hidden').val('')
        //     $(this).find('input:visible').first().focus()
        // })

        // Edit Button
        // $('#edit').click(function() {
        //     var id = $(this).attr('data-id')
        //     if (!!scheds[id]) {
        //         var _form = $('#schedule-form')
        //         console.log(String(scheds[id].sched_date), String(scheds[id].sched_date).replace(" ", "\\t"))
        //         _form.find('[name="id"]').val(id)
        //         _form.find('[name="title"]').val(scheds[id].title)
        //         _form.find('[name="name"]').val(scheds[id].name)
        //         _form.find('[name="specialty"]').val(scheds[id].specialty)
        //         _form.find('[name="sched_date"]').val(String(scheds[id].sched_date).replace(" ", "T"))
        //         _form.find('[name="am"]').val(String(scheds[id].am))
        //         _form.find('[name="pm"]').val(String(scheds[id].pm))
        //         $('#event-details-modal').modal('hide')
        //         _form.find('[name="title"]').focus()
        //     } else {
        //         alert("Event is undefined");
        //     }
        // })

        // // Delete Button / Deleting an Event
        // $('#delete').click(function() {
        //     var id = $(this).attr('data-id')
        //     if (!!scheds[id]) {
        //         var _conf = confirm("Are you sure to delete this scheduled event?");
        //         if (_conf === true) {
        //             location.href = "delete_schedule.php?id=" + id;
        //         }
        //     } else {
        //         alert("Event is undefined");
        //     }
        // })
  



        // $(function() {
        //     var calendar;
        //     var Calendar = FullCalendar.Calendar;
        //     var events = [];
        
        //     // Initialize FullCalendar
        //     function initializeCalendar(eventsData) {
        //         calendar = new Calendar(document.getElementById('calendar'), {
        //             headerToolbar: {
        //                 left: 'prev,next today',
        //                 center: 'title',
        //                 right: 'dayGridMonth,dayGridWeek,list'
        //             },
        //             themeSystem: 'bootstrap',
        //             events: eventsData, // Initial events data
        //             eventClick: function(info) {
        //                 // Handle event click as before
        //                 var id = info.event.id;
        //                 var _details = $('#event-details-modal');
        //                 if (!!scheds[id]) {
        //                     _details.find('#title').text(info.event.title);
        //                     _details.find('#name').text(scheds[id].name);
        //                     _details.find('#specialty').text(scheds[id].specialty);
        //                     _details.find('#sched_date').text(scheds[id].sched_date);
        //                     _details.find('#am').text(scheds[id].am);
        //                     _details.find('#pm').text(scheds[id].pm);
        //                     _details.find('#edit,#delete').attr('data-id', id);
        //                     _details.modal('show');
        //                 } else {
        //                     alert("Event details not found.");
        //                 }
        //             },
        //             eventDidMount: function(info) {
        //                 // Additional actions after events are mounted
        //             },
        //             editable: true // Adjust as per your requirement
        //         });
        
        //         calendar.render();
        //     }
        
            // Doctor selection change handler
            // $('#doctor').change(function() {
            //     var doctorId = $(this).val();
        
            //     $.ajax({
            //         url: 'api/get_doctor_schedule.php', 
            //         type: 'GET',
            //         data: {
            //             doctor_id: doctorId
            //         },
            //         success: function(response) {
            //             events = response; 
            //             calendar.removeAllEvents(); 
            //             calendar.addEventSource(events); 
            //             calendar.refetchEvents(); 
            //             calendar.render();
            //         },
            //         error: function(xhr, status, error) {
            //             console.log('Error fetching doctor schedule: ' + error);
            //         }
            //     });
            // });
        
            // Initial calendar setup with empty events
            // initializeCalendar(events);
//   });