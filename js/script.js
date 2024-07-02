    var calendar;
    var Calendar = FullCalendar.Calendar;
    var events = [];
    $(function() {
        if (!!scheds) {
            Object.keys(scheds).map(k => {
                var row = scheds[k]
                events.push({ id: row.id, name: row.name,  specialty: row.specialty, start: row.start_datetime });
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
                    _details.find('#start').text(scheds[id].sdate)
                    // _details.find('#end').text(scheds[id].edate)
                    _details.find('#edit,#delete').attr('data-id', id)
                    _details.modal('show')
                    console.log("sadad")
                } else {
                    alert("Event is undefined");
                    console.log("1111")
                }
            },
            eventDidMount: function(info) {
            },
            editable: true
        });

        calendar.render();

        // Form reset listener
        $('#schedule-form').on('reset', function() {
            $(this).find('input:hidden').val('')
            $(this).find('input:visible').first().focus()
        })

        // Edit Button
        // $('#edit').click(function() {
        //     var id = $(this).attr('data-id')
        //     if (!!scheds[id]) {
        //         var _form = $('#schedule-form')
        //         console.log(String(scheds[id].start_datetime), String(scheds[id].start_datetime).replace(" ", "\\t"))
        //         _form.find('[name="id"]').val(id)
        //         _form.find('[name="name"]').val(scheds[id].name)
        //         _form.find('[name="specialty"]').val(scheds[id].specialty)
        //         _form.find('[name="start_datetime"]').val(String(scheds[id].start_datetime).replace(" ", "T"))
        //         $('#event-details-modal').modal('hide')
        //         _form.find('[name="specialty"]').focus() 
        //     } else {
        //         // alert("Event is undefined");
        //     }
        // })
        // Delete Button / Deleting an Event
        // $('#delete').click(function() {
        //     var id = $(this).attr('data-id')
        //     if (!!scheds[id]) {
        //         var _conf = confirm("Are you sure to delete this scheduled event?");
        //         if (_conf === true) {
        //             location.href = "./delete_schedule.php?id=" + id;
        //         }
        //     } else {
        //         // alert("Event is undefined");
        //     }
        // })
    })