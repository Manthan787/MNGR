<html ng-app="adminApp">
<head>
        <meta charset="utf-8">
        <title>Admin</title>
        <link rel="stylesheet" href="app/admin/css/bootstrap.min.css" />
        <link rel="stylesheet" href="app/admin/css/font-awesome.min.css" />
        <link rel="stylesheet" href="app/admin/css/animate/animate.min.css" />
        <link rel="stylesheet" href="app/admin/css/iCheck/all.css" />
        <link rel="stylesheet" href="app/admin/css/style.css" />

</head>
<body class="fixed"  ng-controller="AppController">
  @if(Auth::check() && Auth::user()->isAdmin())
  <!-- Header -->
  <header>
    <a href="/admin#" class="logo"><i class="fa fa-bolt"></i> <span>Acharya</span></a>
    <nav class="navbar navbar-static-top">
        <a href="#" class="navbar-btn sidebar-toggle">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>
      <div class="navbar-header">

      </div>
      <div class="navbar-right">
          <ul class="nav navbar-nav">
            <li class="dropdown widget-user">
              <a href="" class="dropdown-toggle" data-toggle="dropdown">
                  <span><?php if(Auth::check()) echo Authaid::getName(Auth::user())  ?>
                      <i class="fa fa-caret-down"></i>
                  </span>
              </a>
              <ul class="dropdown-menu">
                <li>
                	<a href="#Settings/setup"><i class="fa fa-cog"></i>Settings</a>
                </li>
                <li class="footer">
                	<a  href="" ng-click="logout()"><i class="fa fa-power-off"></i>Logout</a>
                </li>
              </ul>
            </li>
          </ul>
      </div>
    </nav>
  </header>
<!-- /.header -->
<div class="wrapper">
<div class="leftside">
<div class="sidebar">
    <div class="user-box">
        <div class="details">
            <p><?php if(Auth::check()) echo Authaid::getName(Auth::user()) ?></p>
            <span class="position"><?php if(Auth::check()) echo Authaid::getPosition(Auth::user()->role_id) ?></span>
        </div>
    </div>
    <br>
    <ul class="sidebar-menu">
        <li>
            <a href="/admin#/">
                <i class="fa fa-home"></i> <span>Dashboard</span>
            </a>
        </li>
        <li class="sub-nav">
            <a href="">
                <i class="fa fa-users"></i>
                <span>Students</span>
                <i class="fa fa-angle-right pull-right"></i>
            </a>
            <ul class="sub-menu">
                <li><a href="#/Students/search"><i class="fa fa-search"></i>Search Students</a></li>
                <li><a href="#/Students/add"><i class="fa fa-plus"></i>Add Students</a></li>
            </ul>
        </li>
        <li class="sub-nav">
            <a href="">
                <i class="fa fa-question"></i>
                    <span>Questions</span>
                    <i class="fa fa-angle-right pull-right"></i>
            </a>
            <ul class="sub-menu">
                <li><a href="#Questions/all"><i class="fa fa-search"></i>Search Questions</a></li>
                <li><a href="#Questions/add"><i class="fa fa-plus"></i>Add Questions</a></li>
            </ul>
        </li>
        <li class="sub-nav">
            <a href="">
                <i class="fa fa-file-archive-o"></i>
                    <span>Study Material</span>
                    <i class="fa fa-angle-right pull-right"></i>
            </a>
            <ul class="sub-menu">
                <li><a href="#Materials/recent"><i class="fa fa-clock-o"></i>Recently Added</a></li>
                <li><a href="#Materials/add"><i class="fa fa-plus"></i>Add Material</a></li>
                <li><a href="#Materials/search"><i class="fa fa-search"></i>Search Material</a></li>
            </ul>
        </li>
        <li class="sub-nav">
            <a href="">
                <i class="fa fa-pencil-square-o"></i>
                    <span>Tests</span>
                        <i class="fa fa-angle-right pull-right"></i>
            </a>
            <ul class="sub-menu">
                <li><a href="#/Tests/create"><i class="glyphicon glyphicon-plus"></i>Create Test</a></li>
            </ul>
        </li>
        <li>
            <a href="#Chapters">
                <i class="fa fa-book"></i>
                <span>Chapters</span>
            </a>
        </li>
        <li>
          <a href="#/Alerts/send">
              <i class="fa fa-bullhorn"></i>
              <span>SMS Alerts</span>
          </a>
        </li>

        <li class="sub-nav">
            <a href="">
                <i class="fa fa-cogs"></i>
                <span>Settings</span>
                <i class="fa fa-angle-right pull-right"></i>
            </a>
            <ul class="sub-menu">
                <li><a href="#/Settings/setup"><i class="glyphicon glyphicon-wrench"></i>Set Up</a></li>
                <li><a href="#/Settings/staff"><i class="glyphicon glyphicon-user"></i>Staff Management</a></li>
                <li><a href="#/Settings/financial-year"><i class="glyphicon glyphicon-calendar"></i>Financial Year</a></li>
                <li><a href="#/Settings/batches"><i class="glyphicon glyphicon-bookmark"></i>Batches</a></li>
            </ul>
        </li>
    </ul>

</div>
</div>
@endif
<div ng-view></div>
</div>


        <!-- Interface -->

        <script src="app/admin/js/plugins/jquery/jquery-1.10.2.min.js" type="text/javascript"></script>
        <script src="app/admin/js/plugins/jquery-ui/jquery-ui-1.10.4.min.js" type="text/javascript"></script>
        <script src="app/admin/js/plugins/jquery-countTo/jquery.countTo.js"></script>

        <script src="app/admin/js/plugins/bootstrap/bootstrap.min.js" type="text/javascript"></script>

        <script src="app/admin/js/plugins/pace/pace.min.js" type="text/javascript"></script>
        <script src="app/admin/js/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="app/admin/js/custom.js" type="text/javascript"></script>


        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/1.3.5/angular.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.3.5/angular-sanitize.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.25/angular-route.js"></script>
        <script src="app/app.js"> </script>
        <script src="app/AppController.js"> </script>
        <script src="app/Questions/Questions.js"></script>
        <script src="app/Questions/Questions.factory.js"></script>
        <script src="app/Materials/Materials.js"></script>
        <script src="app/Students/Students.js"></script>
        <script src="app/Students/Students.factory.js"></script>
        <script src="app/Services/SchoolFinder.js"></script>
        <script src="app/SMS/SMS.js"></script>
        <script src="app/Settings/Settings.js"></script>
        <script src="app/Settings/StandardService.js"></script>
        <script src="app/Settings/StaffController.js"></script>
        <script src="app/Settings/YearController.js"></script>
        <script src="app/Settings/BatchController.js"></script>
        <script src="app/User/User.js"></script>
        <script src="app/Students/FormHelper.js"></script>
        <script src="app/Auth/AuthService.js"></script>
        <script src="app/HomeController.js"></script>
        <script src="app/Chapters/Chapters.js"></script>
        <script src="app/Tests/Tests.js"></script>
        <script src="app/admin/ckeditor/ckeditor.js"></script>




</body>
</html>
