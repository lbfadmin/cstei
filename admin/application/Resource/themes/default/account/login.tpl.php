<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title><?=$_TPL['site_name']?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <?=$this->region('common/styles')?>
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="/misc/src/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="/misc/src/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="/misc/src/pages/css/login.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> </head>
    <!-- END HEAD -->

    <body class=" login">
        <!-- BEGIN LOGO -->
        <div class="logo">
            
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
            <div style='width:100%'>

            <!--<div style='float:left; width:25%;'><img src="/misc/src/pages/img/logo_full.png" alt="" style='float:left' /></div>-->
            <div style='/*float:right; width:75%;*/width:90%;'>
            <h3 class="form-title font-green" >
            孵化器管理平台</h3></div>
            </div>
            <?=render_message() ?>
            <form class="login-form" action="" method="post">
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">用户名</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="请输入用户名" name="username" /> </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">密码</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="请输入密码" name="password" /> </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-block green uppercase">登录系统</button>
                </div>
            </form>
            <!-- END LOGIN FORM -->
        </div>
        <div class="copyright"> <?=date('Y')?> © 青岛罗博飞海洋技术有限公司 </div>
    </body>
</html>