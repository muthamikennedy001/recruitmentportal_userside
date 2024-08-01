<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css' rel='stylesheet' />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js'></script>
        <style>
            @media (max-width: 768px) {
                .fc-header-toolbar {
                    flex-wrap: wrap;
                }

                .fc-toolbar-chunk {
                    width: 100%;
                    text-align: center;
                    margin-bottom: 10px;
                }
            }

            .modal {
                display: none;
                position: fixed;
                z-index: 1;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: auto;
                background-color: rgba(0, 0, 0, 0.5);
            }

            .modal-content {
                background-color: #fefefe;
                margin: 15% auto;
                padding: 20px;
                border: 1px solid #888;
                width: 80%;
                max-width: 600px;
            }

            .close {
                color: #aaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
            }

            .close:hover,
            .close:focus {
                color: black;
                text-decoration: none;
                cursor: pointer;
            }
        </style>
    </head>

    <body class="bg-gray-100">
        <div id='calendar' class="max-w-full"></div>

        <!-- Modal for extended props -->
        <div id="eventModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <p id="eventDetails"></p>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var calendarEl = document.getElementById('calendar');

                // Pass PHP events to JavaScript
                var events = @json($events);

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                    },
                    events: events,
                    eventClick: function(info) {
                        if (info.event.extendedProps.requirements) {
                            var modal = document.getElementById("eventModal");
                            var span = document.getElementsByClassName("close")[0];
                            var eventDetails = document.getElementById("eventDetails");

                            eventDetails.innerText = info.event.extendedProps.requirements;
                            modal.style.display = "block";

                            span.onclick = function() {
                                modal.style.display = "none";
                            };

                            window.onclick = function(event) {
                                if (event.target == modal) {
                                    modal.style.display = "none";
                                }
                            };
                        }
                    }
                });

                function adjustToolbar() {
                    if (window.innerWidth < 768) {
                        calendar.setOption('headerToolbar', {
                            left: 'prev,next today',
                            center: '',
                            right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                        });
                    } else {
                        calendar.setOption('headerToolbar', {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                        });
                    }
                }

                adjustToolbar(); // Adjust toolbar on load

                window.addEventListener('resize', function() {
                    adjustToolbar();
                });

                calendar.render();
            });
        </script>
    </body>

</html>
