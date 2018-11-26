<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "head.php";  ?>
    <title>Most visited pages | KitchenKraze</title>
    <!-- Daterange picker plugins css -->
    <link href="required/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="required/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
<body>
    <div>
        <!-- Navigation, Sidebar and Menues -->
        <?php include "menu.php";  ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <h4 class="page-title">Most visited pages <span class="label label-warning">160</span></h4>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="date-range-side pull-right">
                            <div class="example">
                                <div id="reportrange" class="form-control pull-right" role="button">
								    <i class="fa fa-calendar"></i>&nbsp;
								    <span></span> <i class="fa fa-caret-down"></i>
								</div>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

                <!-- .row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="white-box">
                            <div class="row">
                                <div class="col-md-12">
                                    <h3 class="box-title table-search-input-title">Pages which are visited multiple times comes here.</h3>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Name </th>
                                            <th>URL</th>
                                            <th>Count</th>
                                            <th>Bounce Rate</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<tr>
                                    		<td>Home</td>
                                    		<td><a href="#">/index</a> </td>
                                    		<td>10</td>
                                    		<td>60%</td>
                                    	</tr>
                                    </tbody>
                                </table>
                            </div>


                            <div class="text-center">
                                <ul class="pagination pagination-split">
                                    <li> <a href="#"><i class="fa fa-angle-left"></i></a> </li>
                                    <li class="active"> <a href="#">1</a> </li>
                                    <li> <a href="#">2</a> </li>
                                    <li> <a href="#">3</a> </li>
                                    <li> <a href="#">4</a> </li>
                                    <li> <a href="#">5</a> </li>
                                    <li> <a href="#"><i class="fa fa-angle-right"></i></a> </li>
                                </ul>
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
    <script src="required/moment/moment.js"></script>
    <script src="required/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="required/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script type="text/javascript">
		$(function() {

		    var start = moment().subtract(29, 'days');
		    var end = moment();

		    function cb(start, end) {
		        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
		    }

		    $('#reportrange').daterangepicker({
		        startDate: start,
		        endDate: end,
		        ranges: {
		           'Today': [moment(), moment()],
		           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
		           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
		           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
		           'This Month': [moment().startOf('month'), moment().endOf('month')],
		           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
		        }
		    }, cb);

		    cb(start, end);

		});
	</script>
</body>

</html>
