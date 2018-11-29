

    <footer class="footer text-center"> 2018 &copy; kitchenkraze </footer>
    <!-- jQuery -->
    <!-- <script src="http://localhost/kitchen/Admin/public/assets/js/jquery.min.js"></script> -->
    <!-- Bootstrap Core JavaScript -->
    <script src="http://localhost/kitchen/Admin/public/assets/js/bootstrap.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="http://localhost/kitchen/Admin/public/assets/required/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="http://localhost/kitchen/Admin/public/assets/js/jquery.slimscroll.js"></script>
    <script src="http://localhost/kitchen/Admin/public/assets/js/custom.js"></script>
    <?php $action = Zend_Controller_Front::getInstance()->getRequest()->getActionName();
        if ($action == 'addnew') {?>
             <script src="http://localhost/kitchen/Admin/public/assets/js/validator.js"></script>
        <?php }
         if ($action == 'formsselecttags') {?>
            <script src="http://localhost/kitchen/Admin/public/assets/required/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
        <?php }?>

    