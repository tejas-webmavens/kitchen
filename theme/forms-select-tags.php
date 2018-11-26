<!DOCTYPE html>
<html lang="en">

<head>
    <link href="required/bootstrap-tagsinput/dist/bootstrap-tagsinput.css" rel="stylesheet" />
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
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label">Input Tags</label>
                                            <div class="tags-default">
                                                <input type="text" value="Amsterdam,Washington,Sydney" data-role="tagsinput" placeholder="add tags" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">                                    
                                    <div class="col-xs-12">
                                        <div class="form-group">
                                            <label class="control-label">Select Tags</label>
                                            <select multiple data-role="tagsinput">
                                                <option value="Amsterdam">Amsterdam</option>
                                                <option value="Washington">Washington</option>
                                                <option value="Sydney">Sydney</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
    <script src="required/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
</body>

</html>
