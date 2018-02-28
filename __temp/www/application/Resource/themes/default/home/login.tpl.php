<?=$this->region('common/head')?>
<?=$this->region('common/header')?>

        <!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="/misc/src/global/css/fonts.css" rel="stylesheet" type="text/css" />
<link href="/misc/src/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="/misc/src/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="/misc/src/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
<link href="/misc/src/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />

<!-- END THEME LAYOUT STYLES -->        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="/misc/src/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="/misc/src/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="/misc/src/pages/css/login.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> 
		
        <!-- BEGIN LOGO -->
<div class="homecon center-block innercontent">
            
  
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content" style='width:400px; height:300px; margin:0 auto;'>
            <!-- BEGIN LOGIN FORM -->
           <h3 class="form-title font-green">登录平台</h3> <!---->
                        <form class="login-form" action="" method="post">
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">用户名</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="请输入用户名" name="username" /> </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">密码</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="请输入密码" name="password" /> </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-block green uppercase">登录系统</button><br>
					<a href="#">忘记密码</a>
                </div>
            </form>
            <!-- END LOGIN FORM -->
        </div>
</div>
        <!--<div class="copyright"> 2017 © 青岛罗博飞海洋技术有限公司 </div>-->
		
<?=$this->region('common/footer')?>
    </body>
</html>