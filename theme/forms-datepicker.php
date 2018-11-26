<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Page plugins css -->
    <link href="required/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">
    <!-- Date picker plugins css -->
    <link href="required/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker plugins css -->
    <link href="required/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="required/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <?php include "head.php";  ?>
    <title>Form Elements | KitchenKraze</title>
<body>
    <div>
        <!-- Navigation, Sidebar and Menues -->
        <?php include "menu.php";  ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Forms</h4>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="#">Home</a></li>
                            <li class="active">Forms</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- .row -->
                <div class="row">
                    <div class="col-xs-12">
                        <div class="white-box">
                            <form method="post">
                                <h3 class="box-title"><b>DateRange Picker</b></h3>
                                <div class="form-group">
                                    <div class="example">
                                        <label class="control-label">Date Range Pick</label>
                                        <input class="form-control input-daterange-datepicker" type="text" name="daterange" value="01/01/2015 - 01/31/2015" /> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="example">
                                        <label class="control-label">Date Range With Time</label>
                                        <input type="text" class="form-control input-daterange-timepicker" name="daterange" value="01/01/2015 1:30 PM - 01/01/2015 2:00 PM" /> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="example">
                                        <label class="control-label">Limit Selectable Dates</label>
                                        <input class="form-control input-limit-datepicker" type="text" name="daterange" value="06/01/2015 - 06/07/2015" /> 
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                
                <!-- .row -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0"><b>Date Picker</b></h3>
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="example">
                                        <h5 class="box-title m-t-30">Default Datedpicker</h5>
                                        <p class="text-muted m-b-20">just add class <code>.mydatepicker</code> to create it.</p>
                                        <div class="input-group">
                                            <input type="text" class="form-control mydatepicker" placeholder="mm/dd/yyyy"> <span class="input-group-addon"><i class="icon-calender"></i></span> </div>
                                    </div>
                                    <div class="example">
                                        <h5 class="box-title m-t-30">Autoclose Datedpicker</h5>
                                        <p class="text-muted m-b-20">just add class <code>.complex-colorpicker</code> to create it.</p>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="datepicker-autoclose" placeholder="mm/dd/yyyy"> <span class="input-group-addon"><i class="icon-calender"></i></span> </div>
                                    </div>
                                    <div class="example">
                                        <h5 class="box-title m-t-30">Date Range picker</h5>
                                        <p class="text-muted m-b-20">just add id <code>#date-range</code> to create it.</p>
                                        <div class="input-daterange input-group" id="date-range">
                                            <input type="text" class="form-control" name="start" /> <span class="input-group-addon bg-info b-0 text-white">to</span>
                                            <input type="text" class="form-control" name="end" /> </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="text-center">
                                        <h5 class="box-title m-t-30">Datepicker Inline</h5>
                                        <p class="text-muted m-b-20">You also can set the datepicker to be inline and flat.</p>
                                        <center>
                                            <div id="datepicker-inline"></div>
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                <!-- .row -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title"><b>Clock Picker</b></h3>
                            <p class="text-muted">Use <code>.clockpicker</code> to create it.</p>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label class="m-t-20">Default Clock Picker</label>
                                    <div class="input-group clockpicker">
                                        <input type="text" class="form-control" value="09:30"> <span class="input-group-addon"> <span class="glyphicon glyphicon-time"></span> </span>
                                    </div>
                                    <label class="m-t-40">Auto close Clock Picker</label>
                                    <div class="input-group clockpicker " data-placement="bottom" data-align="top" data-autoclose="true">
                                        <input type="text" class="form-control" value="13:14"> <span class="input-group-addon"> <span class="glyphicon glyphicon-time"></span> </span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <label class="m-t-20">Now time</label>
                                    <div class="input-group">
                                        <input class="form-control" id="single-input" value="" placeholder="Now"> <span class="input-group-btn">
                  <button type="button" id="check-minutes" class="btn waves-effect waves-light btn-success">Check the minutes</button>
                  </span> </div>
                                    <label class="m-t-40">Left Placement</label>
                                    <div class="input-group clockpicker " data-placement="left" data-align="top" data-autoclose="true">
                                        <input type="text" class="form-control" value="13:14"> <span class="input-group-addon"> <span class="glyphicon glyphicon-time"></span> </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->

    <!-- Footer Copyright and Scripts -->
    <?php include "footer.php";  ?>
    <!-- Date Picker Plugin JavaScript -->
    <!-- Plugin JavaScript -->
    <script src="required/moment/moment.js"></script>
    <script src="required/clockpicker/dist/jquery-clockpicker.min.js"></script>
    <script src="required/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- Date range Plugin JavaScript -->
    <script src="required/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="required/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script>    
    // Clock pickers
    $('#single-input').clockpicker({
        placement: 'bottom',
        align: 'left',
        autoclose: true,
        'default': 'now'
    });
    $('.clockpicker').clockpicker({
        donetext: 'Done',
    }).find('input').change(function() {
        console.log(this.value);
    });
    $('#check-minutes').click(function(e) {
        // Have to stop propagation here
        e.stopPropagation();
        input.clockpicker('show').clockpicker('toggleView', 'minutes');
    });
    if (/mobile/i.test(navigator.userAgent)) {
        $('input').prop('readOnly', true);
    }
    // Date Picker
    jQuery('.mydatepicker, #datepicker').datepicker();
    jQuery('#datepicker-autoclose').datepicker({
        autoclose: true,
        todayHighlight: true
    });
    jQuery('#date-range').datepicker({
        toggleActive: true
    });
    jQuery('#datepicker-inline').datepicker({
        todayHighlight: true
    });
    // Daterange picker
    $('.input-daterange-datepicker').daterangepicker({
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-danger',
        cancelClass: 'btn-inverse'
    });
    $('.input-daterange-timepicker').daterangepicker({
        timePicker: true,
        format: 'MM/DD/YYYY h:mm A',
        timePickerIncrement: 30,
        timePicker12Hour: true,
        timePickerSeconds: false,
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-danger',
        cancelClass: 'btn-inverse'
    });
    $('.input-limit-datepicker').daterangepicker({
        format: 'MM/DD/YYYY',
        minDate: '06/01/2015',
        maxDate: '06/30/2015',
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-danger',
        cancelClass: 'btn-inverse',
        dateLimit: {
            days: 6
        }
    });
    </script>

</body>

</html>
