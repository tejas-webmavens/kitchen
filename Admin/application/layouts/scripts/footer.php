

    <footer class="footer text-center"><?php echo date("Y"); ?> &copy; kitchenkraze </footer>
    <!-- jQuery -->
    <!-- <script src="js/jquery.min.js"></script> -->
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="required/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <script src="js/custom.js"></script>
    <?php $action = Zend_Controller_Front::getInstance()->getRequest()->getActionName();
        if ($action == 'addnew') {?>
             <script src="js/validator.js"></script>
        <?php }
         if ($action == 'formsselecttags') {?>
            <script src="required/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
        <?php }?>

    