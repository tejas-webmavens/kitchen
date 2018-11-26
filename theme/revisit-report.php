<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "head.php";  ?>
    <title>Visitor Journey | KitchenKraze</title>
    <!-- Daterange picker plugins css -->
    <link href="required/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="required/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="required/bootstrap-switch/bootstrap-switch.min.css" rel="stylesheet">

<body>
    <div>
        <!-- Navigation, Sidebar and Menues -->
        <?php include "menu.php";  ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Revisit report</h4>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

                <!-- .row -->
                <div class="row">
                    <div class="col-xs-12">
	                    <div class="white-box">
	                    	<div class="row">
	                    		<div class="col-xs-12">
	                    			<h3 class="box-title table-search-input-title">Report Description Comes Here</h3>
	                    			<div class="m-b-40"></div>
	                    		</div>
	                    	</div>
	                    	<div class="row">
	                    		<div class="col-xs-12">
	                    			<ul class="list-inline reports-filters">
	                    				<li>
	                    					<select class="form-control">
	                    						<option value="" selected>UTM Campaign</option>
	                    					</select>
	                    				</li>
	                    				<li>
					                        <div class="date-range-side pull-right">
					                            <div class="example">
					                                <div id="" class="form-control pull-right reportrange" role="button">
													    <i class="fa fa-calendar"></i>&nbsp;
													    <span></span> <i class="fa fa-caret-down"></i>
													</div>
					                            </div>
					                        </div>		
	                    				</li>
	                    			</ul>
	                    			<div class="m-b-40"></div>
	                    			<div class="table-responsive">
		                                <table class="table">
		                                    <thead>
		                                        <tr>
		                                            <th>Visitor Id</th>
		                                            <th>UTM Campaign</th>
		                                            <th>Acquisition Date</th>
		                                            <th>Date Last Seen</th>
		                                            <th>Revisit Count</th>
		                                        </tr>
		                                        <tr>
		                                    </thead>
		                                    <tbody>
		                                        <tr>
		                                            <td><a href="visitor-detail.php">#KitchenKraze26589IN</a></td>
		                                            <td>SummerBonanza</td>
		                                            <td>Sat Jul 23 02:16:57 2005</td>
		                                            <td>Sat Jul 23 02:16:57 2005</td>
		                                            <td>20</td>
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
    <!-- Date range Plugin JavaScript -->
    <script src="required/moment/moment.js"></script>
    <script src="required/timepicker/bootstrap-timepicker.min.js"></script>
    <script src="required/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script type="text/javascript">
		$(function() {

		    var start = moment().subtract(29, 'days');
		    var end = moment();

		    function cb(start, end) {
		        $('.reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
		    }

		    $('.reportrange').daterangepicker({
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
