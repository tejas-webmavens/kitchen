<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "head.php";  ?>
    <title>Ratings | KitchenKraze</title>
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
                        <h4 class="page-title">Ratings <span class="label label-warning">160</span></h4>
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
                        	<h3 class="box-title table-search-input-title">Users with ratings' list comes here</h3>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Email</th>
                                            <th>Ratings</th>
                                            <th class="comment">Comments</th>
                                        </tr>
                                        <tr>
                                        	<td><input type="text" class="form-control" placeholder="Id" name=""></td>
                                        	<td><input type="text" class="form-control" placeholder="Email" name=""></td>
                                        	<td><input type="text" class="form-control" placeholder="Ratings" name=""></td>
                                        	<td><input type="text" class="form-control" placeholder="Comments" name=""></td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<tr data-url="">
                                    		<td><a href="user-detail.php">#KK26589IN</a></td>
                                    		<td>john@company.com</td>
                                    		<td>0.8</td>
                                    		<td>
                                    			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                    			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                    			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                    		</td>
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
