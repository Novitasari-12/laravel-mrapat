<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> Jadwal Rapat </title>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('assets/admin-lte')}}/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel='stylesheet' type='text/css' href='{{asset('assets/calender_schedule')}}/css/dhtmlxscheduler_material.css'>
    <link rel="stylesheet" href="{{asset('assets/calender_schedule')}}/css/controls_styles.css">

    <style type="text/css">
        html,
        body {
            margin: 0px;
            padding: 0px;
            height: 100%;
            overflow: hidden;
        }

        .one_line {
            white-space: nowrap;
            overflow: hidden;
            padding-top: 5px;
            padding-left: 5px;
            text-align: left !important;
        }
    </style>
</head>
<body>
    <div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:100%;'>
        <div class="dhx_cal_navline">
            <div class="dhx_cal_prev_button">&nbsp;</div>
            <div class="dhx_cal_next_button">&nbsp;</div>
            <div class="dhx_cal_today_button"></div>
            <div class="dhx_cal_date"></div>

            <input class="sch_control_button" type="button" name="print" value="Capture"
                onclick="scheduler.exportToPNG({ orientation: 'landscape'})"
                style='position:absolute; right:272px; top:12px; padding:5px 20px;'>

            <input class="sch_control_button" type="button" name="settings" value="Settings"
            style='position:absolute; right:360px; top:12px; padding:5px 20px;'>

            <button class="sch_control_button" type="button" name="fullscreen" style='position:absolute; right:220px; top:12px; padding:5px 20px;'> <i class="fa fa-tv" aria-hidden="true"></i> </button>

            <div class="dhx_cal_tab" name="unit_tab" style="right:460px;"></div>
            <div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div>
            <div class="dhx_cal_tab" name="week_tab" style="right:140px;"></div>
            <div class="dhx_cal_tab" name="timeline_tab" style="right:280px;"></div>
            <div class="dhx_cal_tab" name="month_tab" style="right:76px;"></div>
        </div>
        <div class="dhx_cal_header">
        </div>
        <div class="dhx_cal_data">
        </div>
    </div>


    <div class="modal fade" id="modal-settings" role="dialog">
        <div class="modal-dialog">
        
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"> Settings </h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for=""> Start Date </label>
                    <input type="date" name='start_date' class="form-control">
                </div>
                <div class="form-group">
                    <label for=""> Step (<b id="out_x_step"></b>) </label>
                    <input type="range" name='x_step' class="form-control">
                </div>
                <div class="form-group">
                    <label for=""> Size (<b id="out_x_size"></b>) </label>
                    <input type="range" name='x_size' class="form-control">
                </div>
                <div class="form-group">
                    <label for=""> Start (<b id="out_x_start"></b>) </label>
                    <input type="range" name='x_start' class="form-control">
                </div>
                <div class="form-group">
                    <label for=""> Length (<b id="out_x_length"></b>) </label>
                    <input type="range" name='x_length' class="form-control">
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-default" id='btn-reset-settigs'>Reset Settigs</button>
            <button type="button" class="btn btn-default" id='btn-save-settigs'>Save Settigs</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        
        </div>
    </div>
    
    <!-- jQuery -->
    <script src="{{asset('assets/admin-lte')}}/plugins/jquery/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    {{-- Calender Schedule --}}
    <script src='{{asset('assets/calender_schedule')}}/js/dhtmlxscheduler.js' type="text/javascript" charset="utf-8"></script>
    <script src='{{asset('assets/calender_schedule')}}/js/api.js' type="text/javascript" charset="utf-8"></script>
    <script src='{{asset('assets/calender_schedule')}}/js/dhtmlxscheduler_timeline.js' type="text/javascript" charset="utf-8"></script>
    <script src="{{asset('assets/calender_schedule')}}/js/dhtmlxscheduler_units.js" type="text/javascript" charset="utf-8"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        function showCalendar(){
            window.addEventListener("DOMContentLoaded", function () {

                let x_step = localStorage.getItem('x_step') || 30
                let x_size = localStorage.getItem('x_size') || 24
                let x_start = localStorage.getItem('x_start') || 16
                let x_length = localStorage.getItem('x_length') || 48

                let start_date = localStorage.getItem('start_date') || new Date()
                let type_calendar = localStorage.getItem('type_calendar') || "timeline"

                const setCalendarSections = (sections=[]) => {
                    scheduler.locale.labels.timeline_tab = "Timeline"
                    scheduler.locale.labels.section_custom = "Section";
                    scheduler.config.details_on_create = true;
                    scheduler.config.details_on_dblclick = true;

                    scheduler.createTimelineView({
                        name: "timeline",
                        x_unit: "minute",
                        x_date: "%H:%i",
                        x_step,
                        x_size,
                        x_start,
                        x_length,
                        y_unit: sections,
                        y_property: "section_id",
                        render: "bar"
                    });
                    scheduler.createUnitsView({
                        name: "unit",
                        property: "section_id",
                        list: sections
                    })
                    scheduler.config.lightbox.sections = [
                        { name: "description", height: 130, map_to: "text", type: "textarea", focus: true },
                        { name: "custom", height: 23, type: "select", options: sections, map_to: "section_id" },
                        { name: "time", height: 72, type: "time", map_to: "auto" }
                    ]
                    scheduler.init('scheduler_here', start_date, type_calendar);
                }

                const setCalendarData = (data=[]) => {
                    scheduler.clearAll();
                    scheduler.parse(data);
                }

                const dataLoad = (statLoadData = false) => $.ajax({
                    url : '/jadwal_rapat/show?ruangan=all',
                    method : 'GET'
                }).then(result => {
                    console.log(result)
                    let {data, sections} = result
                    if(!statLoadData) {
                        setCalendarSections(sections)
                    } 
                    setCalendarData(data)
                }).catch(err => {
                    console.log(err)
                    if(!statLoadData) setCalendarSections()
                    setCalendarData()
                })

                dataLoad()
                setInterval(() => dataLoad(true), 5000)

            });
        }

        showCalendar()
        
        $(".dhx_cal_tab[name='unit_tab']").click(e => {
            localStorage.setItem('type_calendar', 'unit')
        })
        $(".dhx_cal_tab[name='day_tab']").click(e => {
            localStorage.setItem('type_calendar', 'day')
        })
        $(".dhx_cal_tab[name='week_tab']").click(e => {
            localStorage.setItem('type_calendar', 'week')
        })
        $(".dhx_cal_tab[name='timeline_tab']").click(e => {
            localStorage.setItem('type_calendar', 'timeline')
        })
        $(".dhx_cal_tab[name='month_tab']").click(e => {
            localStorage.setItem('type_calendar', 'month')
        })
        $(".sch_control_button[name='settings']").click(e => {
            $('#modal-settings').modal('show')
        })

        let ui_start_date = $("input[name='start_date']")
        let ui_x_step = $("input[name='x_step']")
        let ui_x_size = $("input[name='x_size']")
        let ui_x_start = $("input[name='x_start']")
        let ui_x_length = $("input[name='x_length']")

        const setUIValue = () => {
            let start_date = localStorage.getItem('start_date') || new Date()
            let x_step = localStorage.getItem('x_step') || 30
            let x_size = localStorage.getItem('x_size') || 24
            let x_start = localStorage.getItem('x_start') || 16
            let x_length = localStorage.getItem('x_length') || 48
            ui_start_date.val(start_date)
            $('#out_x_step').text(x_step)
            ui_x_step.val(x_step)
            $('#out_x_size').text(x_size)
            ui_x_size.val(x_size)
            $('#out_x_start').text(x_start)
            ui_x_start.val(x_start)
            $('#out_x_length').text(x_length)
            ui_x_length.val(x_length)
        }

        setUIValue()
        
        $('#btn-reset-settigs').click(e => {
            alert('Reset Success')
            localStorage.clear()
            setUIValue()
            location.reload()
        })

        ui_start_date.change(e => {
            let val = ui_start_date.val()
            localStorage.setItem('start_date', val)
        })

        ui_x_step.change(e => {
            let val = ui_x_step.val() ;
            localStorage.setItem('x_step', val)
            $('#out_x_step').text(val)
        })
        ui_x_size.change(e => {
            let val = ui_x_size.val() 
            localStorage.setItem('x_size',  val)
            $('#out_x_size').text(val)
        })
        ui_x_start.change(e => {
            let val = ui_x_start.val()
            localStorage.setItem('x_start',  val)
            $('#out_x_start').text(val)
        })
        ui_x_length.change(e => {
            let val = ui_x_length.val()
            localStorage.setItem('x_length', val )
            $('#out_x_length').text(val)
        })

        $('#btn-save-settigs').click(e => {
            localStorage.setItem('x_step', ui_x_step.val() )
            localStorage.setItem('x_size', ui_x_size.val() )
            localStorage.setItem('x_start', ui_x_start.val() )
            localStorage.setItem('x_length', ui_x_length.val() )
            alert('Saving')
            location.reload()
        })

    </script>
    <script>

        let fullscreen = document.getElementsByName('fullscreen').item(0)
        fullscreen.onclick = function (event) {
            if (document.fullscreenElement) {
                fullscreen.value = 'Fullscreen'
                document.exitFullscreen()
                .then(() => console.log("Document Exited form Full screen mode"))
                .catch((err) => console.error(err))
            } else {
                fullscreen.value = 'Default'
                document.documentElement.requestFullscreen();
            } 
        }
        
        let handelIntervalMsgError = setInterval(() => {
            try {
                var msgError = document.getElementsByClassName('dhtmlx_message_area').item(0)
                msgError.style.display = "none";
                clearInterval(handelIntervalMsgError)
            } catch (error) {
                
            }
        }, 10)
    </script>
</body>
</html>