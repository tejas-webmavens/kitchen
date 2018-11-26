<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "head.php";  ?>
    <title>Dashboard | KitchenKraze</title>
    <!-- Daterange picker plugins css -->
    <link href="required/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="required/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="required/malihu-custom-scrollbar/jquery.mCustomScrollbar.min.css">
<body class="content-wrapper">
    <div>
        <!-- Navigation, Sidebar and Menues -->
        <?php include "menu.php";  ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Dashboard</h4>
                    </div>
                    <!-- <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <div class="date-range-side pull-right">
                            <div class="example">
                                <div id="reportrange" class="form-control pull-right" role="button">
								    <i class="fa fa-calendar"></i>&nbsp;
								    <span></span> <i class="fa fa-caret-down"></i>
								</div>
                            </div>
                        </div>	
                    </div> -->
                    <!-- /.col-lg-12 -->
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="white-box">
                            <h3 class="box-title"><i class="ti-user text-success"></i> Users</h3>
                            <div class="text-right"> <span class="text-muted">Today's Users</span>
                                <h1><sup><i class="ti-arrow-up text-success"></i></sup> 120</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="white-box">
                            <h3 class="box-title"><i class="ti-star text-warning"></i> Ratings</h3>
                            <div class="text-right"> <span class="text-muted">Today's Ratings</span>
                                <h1><sup><i class="ti-arrow-up text-warning"></i></sup> 103</h1>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="white-box">
                            <h3 class="box-title"><i class="ti-check text-danger"></i> Leads</h3>
                            <div class="text-right"> <span class="text-muted">Today's Leads</span>
                                <h1><sup><i class="ti-arrow-down text-danger"></i></sup> 25</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="white-box">
                            <h3 class="box-title"><i class="ti-pulse text-info"></i> Bounce Rate</h3>
                            <div class="text-right"> <span class="text-muted">Weekly Rate</span>
                                <h1><sup><i class="ti-arrow-up text-info"></i></sup> 60%</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                        <div class="white-box">
                            <h3 class="box-title"><i class="ti-announcement text-warning"></i> Most visited pages</h3>
                            <div class="text-right"> <span class="text-muted">Count</span>
                                <h1><sup><i class="ti-arrow-up text-inverse"></i></sup> 150</h1>
                            </div>
                        </div>
                    </div> -->
                </div>

                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">Daily Users List <a href="active-users.php" class="btn btn-default pull-right m-l-20 btn-outline ">View All</a></h3>
                            <p class="text-muted">Today's Users list comes here.</p>
                    		<div class="scroll-bar">     
                            	<div class="table-responsive">                           
	                                <table class="table">
	                                    <thead>
	                                        <tr>
	                                            <th>Visitor Id</th>
	                                            <th>Email</th>
	                                            <th>Rounds played</th>
	                                            <th>Total time spent</th>
	                                        </tr>
	                                    </thead>
	                                    <tbody>
	                                        <tr>
	                                            <td><a href="user-detail.php">#KK26589IN</a></td>
	                                            <td>john@company.com</td>
	                                            <td>15</td>
	                                            <td>06:29:35</td>
	                                        </tr>
	                                    </tbody>
	                                </table>
	                            </div>
	                        </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">Daily Ratings List <a href="ratings.php" class="btn btn-default pull-right m-l-20 btn-outline ">View All</a></h3>
                            <p class="text-muted">Today's Users Ratings' list comes here.</p>
                    		<div class="scroll-bar">     
                            	<div class="table-responsive">                           
	                                <table class="table">
	                                    <thead>
	                                        <tr>
	                                            <th>Id</th>
	                                            <th>Email</th>
	                                            <th>Ratings</th>
	                                            <th class="comment">Comments</th>
	                                        </tr>
	                                    </thead>
	                                    <tbody>
	                                        <tr>
	                                            <td><a href="user-detail.php">#KK26589IN</a></td>
	                                            <td>john@company.com</td>
	                                            <td>0.9</td>
	                                            <td>
	                                            	Lorem ipsum dolor sit amet, consectetur adipisicing elit
	                                            </td>
	                                        </tr>
	                                    </tbody>
	                                </table>
	                            </div>
	                        </div>
                        </div>
                    </div>
                </div>
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
	<script src="required/malihu-custom-scrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
	<script>
	    (function($){
	        $(window).on("load",function(){
	            $(".scroll-bar").mCustomScrollbar({
	            	setHeight: 300,
	            	theme:"dark-3",
        			autoHideScrollbar: false
	            });
	        });
	    })(jQuery);
	</script>
</body>

</html>
