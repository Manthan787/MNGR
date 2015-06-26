<!DOCTYPE html>
<html ng-app="login">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>EduFocus - Login</title>

    <!-- Maniac stylesheets -->
    <link rel="stylesheet" href="app/admin/css/bootstrap.min.css" />
    <link rel="stylesheet" href="app/admin/css/font-awesome.min.css" />
    <link rel="stylesheet" href="app/admin/css/animate/animate.min.css" />
    <link rel="stylesheet" href="app/admin/css/bootstrapValidator/bootstrapValidator.min.css" />
    <link rel="stylesheet" href="app/admin/css/iCheck/all.css" />
    <link rel="stylesheet" href="app/admin/css/style.css" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="login fixed">
<div class="wrapper animated flipInY">
    <div class="logo"><a href="#"><i class="fa fa-bolt"></i> <span>EduFocus</span></a></div>
    <div class="box">
        <div class="header clearfix">
            <div class="pull-left"><i class="fa fa-sign-in"></i> Sign In</div>

        </div>
        <form id="loginform"  ng-controller="LoginController">
            <div class="alert alert-warning no-radius no-margin padding-sm"><i class="fa fa-info-circle"></i> Please sign in to maniac dashboard</div>
            <div class="box-body padding-md">
                <div class="form-group">
                    <input type="text" name="username" ng-model="email" class="form-control" placeholder="Username"/>
                </div>
                <div class="form-group">
                    <input type="password" name="password" ng-model="password" class="form-control" placeholder="Password"/>
                </div>
                <div class="form-group">
                    <input type="checkbox" /> <small>Remember me</small>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-success btn-block" ng-click="login()">Sign in</button>
                </div>
            </div>
        </form>
    </div>
    <div class="box-extra clearfix">
        <a href="#" class="pull-left btn btn-xs">Forgotten Password?</a>
    </div>

    <footer>
        Copyright &copy; 2015. Created by Manthan Thakar & Ajay Shah.

        <ul class="list-unstyled list-inline">
            <li><a href="#">Home</a></li>
            <li><a href="#">About Us</a></li>
            <li><a href="#">UI Elements</a></li>
            <li><a href="#">Charts</a></li>
            <li><a href="#">Mobile Apps</a></li>
            <li><a href="#">Contact</a></li>
        </ul>
    </footer>
</div>

<!-- Javascript -->
<script src="app/admin/js/plugins/jquery/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="app/admin/js/plugins/jquery-ui/jquery-ui-1.10.4.min.js" type="text/javascript"></script>

<!-- Bootstrap -->
<script src="app/admin/js/plugins/bootstrap/bootstrap.min.js" type="text/javascript"></script>

<!-- Interface -->
<script src="app/admin/js/plugins/pace/pace.min.js" type="text/javascript"></script>

<!-- Forms -->
<script src="app/admin/js/plugins/bootstrapValidator/bootstrapValidator.min.js" type="text/javascript"></script>
<script src="app/admin/js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
<!-- Angular -->
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/1.3.5/angular.min.js"></script>
<script src="LoginApp/app.js"></script>

<script type="text/javascript">

//iCheck
    $("input[type='checkbox'], input[type='radio']").iCheck({
        checkboxClass: 'icheckbox_minimal',
        radioClass: 'iradio_minimal'
    });

    $(document).ready(function() {
        $('#loginform').bootstrapValidator({
            message: 'This value is not valid',
            fields: {
                username: {
                    message: 'The username is not valid',
                    validators: {
                        notEmpty: {
                            message: 'The username is required and can\'t be empty'
                        }
                    }
                },
                password: {
                    validators: {
                        notEmpty: {
                            message: 'The password is required and can\'t be empty'
                        }
                    }
                }
            }
        });
    });
</script>
</body>
</html>