<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi-date Calendar with Times</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
</head>

<body>
    <div id="calendar"></div>
    <script>
        $(document).ready(function() {
            $('#calendar').fullCalendar({
                selectable: true,
                select: function(start, end) {
                    handleDateSelection(start);
                    $('#calendar').fullCalendar('unselect');
                }
            });
        });

        function handleDateSelection(start) {
            var start_time = prompt('Enter start time (HH:mm)', '08:00');
            var end_time = prompt('Enter end time (HH:mm)', '17:00');

            var selectedDate = {
                date: {
                    start_time: start_time,
                    end_time: end_time
                }
            };

            console.log(selectedDate);
        }
    </script>
</body>

</html>