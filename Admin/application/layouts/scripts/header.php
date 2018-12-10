
<html lang="en">

<head>
    <base href="http://localhost/kitchen/Admin/public/" target="">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="assets/images/favicon.png" sizes="16x16" />
    <!-- Bootstrap Core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/required/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="assets/required/sidebar-nav/dist/sidebar-nav.css" rel="stylesheet">
    <!-- animation CSS -->
    <link href="assets/css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/css/style.css" rel="stylesheet">
   
    <!-- <title>Login | KitchenKraze</title> -->

   <script type="text/javascript" src="assets/js/jquery.min.js"></script>
   <?php $action = Zend_Controller_Front::getInstance()->getRequest()->getActionName();
        if ($action == 'userdetail') {?>
             <title>User Detail | KitchenKraze</title>
             <link href="assets/required/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
            <link href="assets/required/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
            <?php }?>
      <?php  if ($action == 'edituser') {?>
             <title>Edit User | KitchenKraze</title>
            <?php }?>
            <?php  if ($action == 'addnew') {?>
             <title>Add User | KitchenKraze</title>
            <?php }?>
             <?php  if ($action == 'userdetails') {?>
             <title>User Detail | KitchenKraze</title>
            <?php }?>
             <?php  if ($action == 'login') {?>
             <title>Log-in | KitchenKraze</title>

            <?php }?>
            <?php  if ($action == 'forms') {?>
             <title>Form Elements | KitchenKraze</title>

            <?php }?>
            <?php  if ($action == 'faq') {?>
             <title>FAQs | KitchenKraze</title>

            <?php }?>
            <?php  if ($action == 'alerts') {?>
             <title>Form Elements | KitchenKraze</title>

            <?php }?>
            <?php  if ($action == 'formsselecttags') {?>
             <title>Form Elements | KitchenKraze</title>

            <?php }?>
             <?php  if ($action == 'conversationreports') {?>
             <title>Visitor Journey | KitchenKraze</title>
             <link href="assets/required/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
            <link href="assets/required/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
            <link href="assets/required/bootstrap-switch/bootstrap-switch.min.css" rel="stylesheet">


            <?php }?>
             <?php  if ($action == 'campaigns') {?>
             <title>Campaigns | KitchenKraze</title>
             <link href="assets/required/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
            <link href="assets/required/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
            <?php }?>
            <?php  if ($action == 'formsdatepicker') {?>
                 <link href="assets/required/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">
                <!-- Date picker plugins css -->
                <link href="assets/required/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
                <!-- Daterange picker plugins css -->
                <link href="assets/required/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
                <link href="assets/required/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
             <title>Form Elements | KitchenKraze</title>

            <?php }?>
            <?php  if ($action == 'formsfileupload') {?>
                <link rel="stylesheet" href="assets/required/dropify/dist/css/dropify.min.css">
             <title>Form Elements | KitchenKraze</title>

            <?php }?>
            <?php  if ($action == 'register') {?>
             <title>Register | KitchenKraze</title>

             <link rel="icon" type="image/png" sizes="16x16" href="assets/plugins/images/favicon.png">
            <?php }?>
             <?php  if ($action == 'gamedetail') {?>
             <title>Game Detail | KitchenKraze</title>
              <link href="assets/required/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
            <link href="assets/required/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
            <?php }?>
            <?php  if ($action == 'deactiveuser') {?>
                <title>Deactivated Users | KitchenKraze</title>
                <link href="assets/required/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
                <link href="assets/required/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
            <?php }?>
             <?php  if ($action == 'activeuser') {?>
             <title>Active Users | KitchenKraze</title>
             <link href="assets/required/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
             <link href="assets/required/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
            <?php }?>
            <?php  if ($action == 'deleteduser') {?>
             <title>Deleted Users | KitchenKraze</title>
             <link href="assets/required/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
             <link href="assets/required/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
            <?php }?>
            <?php  if ($action == 'blockeduser') {?>
             <title>Blocked Users | KitchenKraze</title>
             <link href="assets/required/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
             <link href="assets/required/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
            <?php }?>
             <?php  if ($action == 'Ratings') {?>
             <title>Ratings | KitchenKraze</title>
             <link href="assets/required/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
            <link href="assets/required/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
            <?php }?>
             <?php  if ($action == 'index') {?>
             <title>Dashboard | KitchenKraze</title>
              <link href="assets/required/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
             <link href="assets/required/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
                <link rel="stylesheet" type="text/css" href="assets/required/malihu-custom-scrollbar/jquery.mCustomScrollbar.min.css">
            <?php }?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
