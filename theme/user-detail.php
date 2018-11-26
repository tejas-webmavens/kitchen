<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "head.php";  ?>
    <title>User Detail | KitchenKraze</title>
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
                        <h4 class="page-title">User #KitchenKraze26589IN Overview</h4>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    	<a href="add-user.php" class="btn btn-danger pull-right m-l-20 btn-rounded btn-outline hidden-xs hidden-sm">Add New User</a>
                    	<a href="edit-user.php" class="btn btn-danger pull-right m-l-20 btn-rounded btn-outline hidden-xs hidden-sm">Edit User</a>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

                <div class="row">
                    <div class="col-md-2 col-xs-12 col-sm-6">
                        <div class="white-box text-right bg-warning" title="Games played by user in total" data-toggle="tooltip" data-placement="bottom">
                        	<p class="text-white text-left"><i class="ti-video-clapper fa-2x"></i></p>
                            <h1 class="text-white counter">23</h1>
                            <p class="text-white">Games</p>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12 col-sm-6">
                        <div class="white-box text-right bg-info" title="Quality of the results from the image search engine in total" data-toggle="tooltip" data-placement="bottom">
                        	<p class="text-white text-left"><i class="ti-cup fa-2x"></i></p>
                            <h1 class="text-white counter">50</h1>
                            <p class="text-white">Quality</p>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12 col-sm-6">
                        <div class="white-box text-right" title="Time spent overall" data-toggle="tooltip" data-placement="bottom">
                        	<p class="text-muted text-left"><i class="ti-time fa-2x"></i></p>
                            <h1 class="counter">06:29:35</h1>
                            <p class="text-muted">Duration</p>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12 col-sm-6">
                        <div class="white-box text-right bg-success" title="How often do users return to the game in total" data-toggle="tooltip" data-placement="bottom">
                        	<p class="text-white text-left"><i class="ti-mouse-alt fa-2x"></i></p>
                            <h1 class="text-white counter">50</h1>
                            <p class="text-white">Retention</p>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12 col-sm-6">
                        <div class="white-box text-right bg-theme-dark" title="# of images viewed in total" data-toggle="tooltip" data-placement="bottom">
                        	<p class="text-white text-left"><i class="ti-image fa-2x"></i></p>
                            <h1 class="text-white counter">157</h1>
                            <p class="text-white">Images</p>
                        </div>
                    </div>
                    <div class="col-md-2 col-xs-12 col-sm-6">
                        <div class="white-box text-right bg-primary" title="# of shares in total" data-toggle="tooltip" data-placement="bottom">
                        	<p class="text-white text-left"><i class="ti-share fa-2x"></i></p>
                            <h1 class="text-white counter">10</h1>
                            <p class="text-white">Shares</p>
                        </div>
                    </div>
                </div>

                <!-- .row -->
                <div class="row">
                    <div class="col-xs-12">
                        <div class="white-box">
                        	<div class="visitor-box">
                        		<div class="row">
                        			<div class="col-xs-12">  
                        			</div>
                        		</div>
		                        <div class="row">
									<div class="flex-grid">
										<div class="visitor-general-details-list flex-col">
											<div class="row">
												<div class="col-xs-12">		                        				
									        		<ul class="list-unstyled">
									        			<li><strong>User Id:</strong> #KitchenKraze26589IN</li>
									        			<li><strong>Email:</strong> john@company.com</li>									        			
									        		</ul>	
												</div>
											</div>
										</div>
										<div class="visitor-details-box flex-col">
											<div class="row">
												<div class="col-xs-12">
													<div class="panel-group visitor-accordian" id="accordion" role="tablist">
													    <div class="panel panel-default">
													        <div class="panel-heading">
													            <h4 class="panel-title">
													                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_1" aria-expanded="true" aria-controls="collapse_1" class="collapsed">
													                	15 Aug, 2018 <span class="pull-right">4 Games <small>(010:00:00)</small></span>
													                </a>
													            </h4>
													        </div>
													        <div id="collapse_1" class="panel-collapse collapse" role="tabpanel">
													            <div class="panel-body">
													                <table class="table">
													                	<thead>
													                		<tr>
													                			<th>Time</th>
													                			<th>Session Time</th>
													                			<th>Rounds</th>
													                			<th>Image Views</th>
													                			<th>Retention Rate</th>
													                			<th>Shares</th>
													                		</tr>
													                	</thead>
													                	<tbody>
													                		<tr>
													                			<td><a href="game-detail.php">5:50 PM</a></td>
													                			<td>52:60:00</td>
													                			<td>1</td>
													                			<td>15</td>
													                			<td>60%</td>
													                			<td>1</td>
													                		</tr>
													                		<tr>
													                			<td><a href="game-detail.php">4:50 PM</a></td>
													                			<td>52:60:00</td>
													                			<td>3</td>
													                			<td>15</td>
													                			<td>60%</td>
													                			<td>0</td>
													                		</tr>
													                		<tr>
													                			<td><a href="game-detail.php">2:50 PM</a></td>
													                			<td>52:60:00</td>
													                			<td>5</td>
													                			<td>15</td>
													                			<td>60%</td>
													                			<td>2</td>
													                		</tr>
													                		<tr>
													                			<td><a href="game-detail.php">1:50 PM</a></td>
													                			<td>52:60:00</td>
													                			<td>15</td>
													                			<td>15</td>
													                			<td>60%</td>
													                			<td>10</td>
													                		</tr>
													                	</tbody>
													                </table>
													            </div>
													        </div>
													    </div>
													</div>			                        				
												</div>
											</div>
										</div>
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
</body>

</html>
