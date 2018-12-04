
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header"> 
                <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="ti-menu"></i></a>
                <a href="/" class="site-main-logo pull-left"><img src="http://localhost/kitchen/Admin/public/assets/images/eliteadmin-logo.png" height="60"></a>
                <ul class="nav navbar-top-links navbar-left hidden-xs">
                    <li><a href="javascript:void(0)" class="open-close hidden-xs waves-effect waves-light"><i class="icon-menu ti-align-left"></i></a></li>
                    <li>
                        
                    </li>
                </ul>
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <li class="dropdown">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false"> <img src="http://localhost/kitchen/Admin/public/assets/images/users/1.jpg" alt="user-img" width="36" class="img-circle"><b class="hidden-xs">Admin </b> &nbsp; <span class="ti-angle-down"></span> </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="login"><i class="fa fa-power-off"></i>  Logout</a></li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                </ul>
            </div>
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->

        </nav>
        <!-- Left navbar-header -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse slimscrollsidebar">               
                <ul class="nav" id="side-menu">                    
                    <li class="nav-small-cap m-t-10">--- Main Menu</li>

                    <li> <a href="http://localhost/kitchen/Admin/public/index/index"><i class="linea-icon linea-basic fa-fw" data-icon="c"></i> <span class="hide-menu"> Dashboard</a>
                    </li>

                    <li> <a href="http://localhost/kitchen/Admin/public/index/Ratings"><i class="ti-star fa-fw"></i> <span class="hide-menu"> Ratings</a>
                    </li>

                	<li class="active"> <a href="javascript:void(0);" class="waves-effect"><i class="ti-user fa-fw"></i> <span class="hide-menu">Users <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse in" aria-expanded="true" style="">
                    	<li> <a href="http://localhost/kitchen/Admin/public/users/addnew">Add new user</a> </li>
                        <li> <a href="http://localhost/kitchen/Admin/public/users/activeuser">Active <span class="label label-rouded label-info pull-right"><?php echo $this->activeCount ?></span></a> </li>
                        <li> <a href="http://localhost/kitchen/Admin/public/users/deactiveuser">Deactivated <span class="label label-warning label-info pull-right"><?php echo $this->deactiveCount ?></span></a> </li>
                    </ul>
                </li>

                    </li>
                    <li><a href="login"><i class="icon-logout fa-fw"></i> <span class="hide-menu">Log out</span></a></li>
                </ul>
            </div>
        </div>
        <!-- Left navbar-header end -->