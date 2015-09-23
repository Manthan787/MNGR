<!DOCTYPE html>
<html ng-app="login">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Acharya - Login</title>

    <!-- Maniac stylesheets -->
    <link rel="stylesheet" href="{{URL::asset("app/admin/css/bootstrap.min.css")}}" />
    <link rel="stylesheet" href="{{URL::asset("app/admin/css/font-awesome.min.css")}}" />
    <link rel="stylesheet" href="{{URL::asset("app/admin/css/animate/animate.min.css")}}" />
    <link rel="stylesheet" href="{{URL::asset("app/admin/css/bootstrapValidator/bootstrapValidator.min.css")}}" />
    <link rel="stylesheet" href="{{URL::asset("app/admin/css/iCheck/all.css")}}" />
    <link rel="stylesheet" href="{{URL::asset("app/admin/css/style.css")}}" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="login fixed">
<div class="wrapper animated flipInY">
    <div class="logo"><a href="#">
      <i class="fa fa-bolt"></i>
        <span>Acharya</span>
      </a>
    </div>

    <div class="box">

        <div class="header clearfix">
            <div class="pull-left"><i class="fa fa-sign-in"></i> Sign In</div>

        </div>
        <form ng-controller="LoginController" ng-submit="login()">
          <div align="center" ng-show="loading">
              <img src="{{URL::asset("app/admin/img/loader.gif")}}" height="45" width="45">
          </div>
            <div class="alert alert-warning no-radius no-margin padding-sm" ng-if="msg">
              <i class="fa fa-info-circle"></i>
              @{{msg}}
            </div>
            <div class="box-body padding-md">
                <div class="form-group">
                    <input type="text" name="username" ng-model="email" class="form-control" placeholder="Username"/>
                </div>
                <div class="form-group">
                    <input type="password" name="password" ng-model="password" class="form-control" placeholder="Password"/>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-success btn-block">Sign in</button>
                </div>
            </div>
        </form>
    </div>
    <div class="box-extra clearfix">
        <a href="#" class="pull-left btn btn-xs">Forgotten Password?</a>
    </div>

    <footer>
        <a href="http://www.acharyapp.com">Powered By Acharya</a>
    </footer>
</div>

<!-- Javascript -->
<script src="{{URL::asset("app/admin/js/plugins/jquery/jquery-1.10.2.min.js")}}" type="text/javascript"></script>
<script src="{{URL::asset("app/admin/js/plugins/jquery-ui/jquery-ui-1.10.4.min.js")}}" type="text/javascript"></script>

<!-- Bootstrap -->
<script src="{{URL::asset("app/admin/js/plugins/bootstrap/bootstrap.min.js")}}" type="text/javascript"></script>

<!-- Interface -->
<script src="{{URL::asset("app/admin/js/plugins/pace/pace.min.js")}}" type="text/javascript"></script>

<!-- Forms -->
<script src="{{URL::asset("app/admin/js/plugins/bootstrapValidator/bootstrapValidator.min.js")}}" type="text/javascript"></script>
<script src="{{URL::asset("app/admin/js/plugins/iCheck/icheck.min.js")}}" type="text/javascript"></script>
<!-- Angular -->
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/1.3.5/angular.min.js"></script>
<script src="{{URL::asset("LoginApp/app.js")}}"></script>

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
