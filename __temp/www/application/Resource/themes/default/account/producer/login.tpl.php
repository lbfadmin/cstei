<!DOCTYPE html>
<html lang="zh">
<head>
    <title>企业端登录 - 智慧海洋平台</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <?=$this->region('common/styles')?>
    <link rel="stylesheet" href="<?=$this->misc('app/css/login.css')?>">
</head>
<body class="producer-login">
<?=$this->region('common/header')?>
<div class="banner">
    <div class="banner-content"><span class="text">
            企业端登录<br>Login
        </span></div>
</div>
<div class="body">
    <div class="body-main">
        <div class="wrapper">
            <div class="body-content">
                <form name="form-login" method="post" action="<?=$_CONFIG['common']['producerBaseUrl']?>account/login">
                    <div class="form-group">
                        <select name="role" class="form-control">
                            <option value="">请选择角色</option>
                            <option value="root@robotfish.com.cn">总经理</option>
                            <option value="yangzhi@robotfish.com.cn">养殖部门</option>
                            <option value="jiagong@robotfish.com.cn">加工部门</option>
                            <option value="zhijian@robotfish.com.cn">质检部门</option>
                            <option value="xiaoshou@robotfish.com.cn">销售部门</option>
                        </select>
                        <input type="hidden" name="username" value="" placeholder="">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" value="123456" maxlength="16" placeholder="">
                    </div>

                    <div class="btns">
                        <button class="login btn btn-block" data-role="login">登录</button>
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