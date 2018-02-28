<!DOCTYPE html>
<html lang="zh">
<head>
    <title>政府端登录 - 智慧海洋平台</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <?=$this->region('common/styles')?>
    <link rel="stylesheet" href="<?=$this->misc('app/css/login.css')?>">
</head>
<body class="supervisor-login">
<?=$this->region('common/header')?>
<div class="banner">
    <div class="banner-content"><span class="text">
            政府端登录<br>Login
        </span></div>
</div>
<div class="body">
    <div class="body-main">
        <div class="wrapper">
            <div class="body-content">
                <form name="form-login" method="post" action="<?=$_CONFIG['common']['supervisorBaseUrl']?>account/login">
                    <div class="form-group">
                        <select name="role" class="form-control">
                            <option value="">请选择角色</option>
                            <option value="root@robotfish.com.cn">负责人</option>
                            <option value="huanbao@robotfish.com.cn">环境保护</option>
                            <option value="shichang@robotfish.com.cn">市场管理</option>
                            <option value="anquan@robotfish.com.cn">食品安全</option>
                        </select>
                        <input type="hidden" name="username" value="" placeholder="">
                    </div>
                    <div class="form-group">
                        <input class="form-control" name="password" type="password" value="123456" maxlength="16" placeholder="请输入密码">
                    </div>

                    <div class="btns">
                        <button class="btn btn-block" data-role="login">登录</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?=$this->region('common/footer')?>
<?=$this->region('common/scripts')?>
<script>
    var $form = $('form[name=form-login]');
    $form.find('[name=role]').on('change', function () {
        $form.find('[name=username]').val($(this).val());
    });
    $form.on('submit', function () {
        if ($.trim($form.find('[name=username]').val()) === '') {
            layer.msg('请选择一个角色');
            return false;
        }
    });
</script>
</body>
</html>