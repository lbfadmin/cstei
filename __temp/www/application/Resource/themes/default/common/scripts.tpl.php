<script type="text/html" id="co-login">
    <div class="mask-ctn">
        <div class="head">
            <i class="shut"></i>
            <img src="/misc/src/app/images/mask-ctn-logo.png">
            <img src="/misc/src/app/images/mask-ctn-head-text-co.png">
        </div>
        <div class="ctn">
            <form method="post" action="<?=$_CONFIG['common']['producerBaseUrl']?>account/login">
                <select name="role">
                    <option value="">请选择角色</option>
                    <option value="root@robotfish.com.cn">总经理</option>
                    <option value="yangzhi@robotfish.com.cn">养殖部门</option>
                    <option value="jiagong@robotfish.com.cn">加工部门</option>
                    <option value="zhijian@robotfish.com.cn">质检部门</option>
                    <option value="xiaoshou@robotfish.com.cn">销售部门</option>
                </select>
                <input type="hidden" name="username" value="" placeholder="">
                <input type="password" name="password" value="123456" maxlength="16" placeholder="">
                <div class="btns">
                    <button class="login">登录</button>
                    <button>查看演示</button>
                </div>
            </form>
        </div>
    </div>
</script>
<script type="text/html" id="gov-login">
    <div class="mask-ctn">
        <div class="head">
            <i class="shut"></i>
            <img src="/misc/src/app/images/mask-ctn-logo.png">
            <img src="/misc/src/app/images/mask-ctn-head-text-government.png">
        </div>
        <div class="ctn">
            <form method="post" action="<?=$_CONFIG['common']['supervisorBaseUrl']?>account/login">
                <select name="role">
                    <option value="">请选择角色</option>
                    <option value="root@robotfish.com.cn">负责人</option>
                    <option value="huanbao@robotfish.com.cn">环境保护</option>
                    <option value="shichang@robotfish.com.cn">市场管理</option>
                    <option value="anquan@robotfish.com.cn">食品安全</option>
                </select>
                <input type="hidden" name="username" value="" placeholder="">
                <input type="password" name="password" value="123456" maxlength="16" placeholder="">
                <div class="btns">
                    <button class="login">登录</button>
                    <button>查看演示</button>
                </div>
            </form>
        </div>
    </div>
</script>
<script type="text/javascript" src="/misc/src/app/js/jquery-1.11.1.min.js"></script>
<script src="/misc/src/vendor/layer/layer.js"></script>
<!--<script src="/misc/src/vendor/video.js/video.min.js"></script>
<script src="/misc/src/app/js/app.js"></script>-->
<script src="/misc/src/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script src="/misc/src/global/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js"></script>