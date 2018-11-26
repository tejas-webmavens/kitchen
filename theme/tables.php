<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "head.php";  ?>
    <title>Table Elements | KitchenKraze</title>
<body>
    <div>
        <!-- Navigation, Sidebar and Menues -->
        <?php include "menu.php";  ?>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Tables</h4>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="#">Home</a></li>
                            <li class="active">Tables</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

                <!-- .row -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="white-box">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 class="box-title table-search-input-title">Table with Search & Pagination</h3>        
                                </div>
                                <div class="col-md-6">
                                    <form method="post">
                                        <div class="form-group table-search-input">
                                            <input type="search" class="form-control" placeholder="Search Here" name="">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Invoice</th>
                                            <th>User</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Country</th>
                                            <th class="text-nowrap">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><a href="javascript:void(0)">Order #26589</a></td>
                                            <td>Herman Beck</td>
                                            <td><span class="text-muted"><i class="fa fa-clock-o"></i> Oct 16, 2017</span> </td>
                                            <td>$45.00</td>
                                            <td>
                                                <div class="label label-table label-success">Paid</div>
                                            </td>
                                            <td>EN</td>
                                            <td class="text-nowrap">
                                                <a href="#" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                                <a href="#" data-toggle="tooltip" data-original-title="Close"> <i class="fa fa-close text-danger"></i> </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><a href="javascript:void(0)">Order #58746</a></td>
                                            <td>Mary Adams</td>
                                            <td><span class="text-muted"><i class="fa fa-clock-o"></i> Oct 12, 2017</span> </td>
                                            <td>$245.30</td>
                                            <td>
                                                <div class="label label-table label-danger">Shipped</div>
                                            </td>
                                            <td>CN</td>
                                            <td class="text-nowrap">
                                                <a href="#" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                                <a href="#" data-toggle="tooltip" data-original-title="Close"> <i class="fa fa-close text-danger"></i> </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><a href="javascript:void(0)">Order #98458</a></td>
                                            <td>Caleb Richards</td>
                                            <td><span class="text-muted"><i class="fa fa-clock-o"></i> May 18, 2017</span> </td>
                                            <td>$38.00</td>
                                            <td>
                                                <div class="label label-table label-info">Shipped</div>
                                            </td>
                                            <td>AU</td>
                                            <td class="text-nowrap">
                                                <a href="#" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                                <a href="#" data-toggle="tooltip" data-original-title="Close"> <i class="fa fa-close text-danger"></i> </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><a href="javascript:void(0)">Order #32658</a></td>
                                            <td>June Lane</td>
                                            <td><span class="text-muted"><i class="fa fa-clock-o"></i> Apr 28, 2017</span> </td>
                                            <td>$77.99</td>
                                            <td>
                                                <div class="label label-table label-success">Paid</div>
                                            </td>
                                            <td>FR</td>
                                            <td class="text-nowrap">
                                                <a href="#" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                                <a href="#" data-toggle="tooltip" data-original-title="Close"> <i class="fa fa-close text-danger"></i> </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>


                            <div class="text-center">
                                <ul class="pagination pagination-split">
                                    <li> <a href="#"><i class="fa fa-angle-left"></i></a> </li>
                                    <li class="disabled"> <a href="#">1</a> </li>
                                    <li class="active"> <a href="#">2</a> </li>
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
</body>

</html>
