<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
        <!-- BEGIN LOGO -->
        <div class="page-logo">
           <!-- <h5>孵化器物管平台</h4>-->
                <!--<img src="/misc/src/pages/img/logo_full.png" alt="logo" class="logo-default" style="width:70px;margin-top:0px" />--> <a href="<?=url('dashboard')?>"></a>
            <div class="menu-toggler sidebar-toggler">
            </div>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
        <!-- END RESPONSIVE MENU TOGGLER -->
        <!-- BEGIN PAGE ACTIONS -->
        <div class="page-actions">
            <div class="btn-group">
                <button type="button" class="btn btn-circle green dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-globe"></i>&nbsp;
                    <span class="hidden-sm hidden-xs">快速访问&nbsp;</span>&nbsp;
                    <i class="fa fa-angle-down"></i>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li>
                        <a href="http://www.robotfish.com.cn/" target="_blank">
                            <i class="fa fa-external-link"></i> 罗博飞官网 </a>
                    </li>
                    <li>
                        <a href="" target="_blank">
                            <i class="fa fa-external-link"></i> 政府端 </a>
                    </li>
                    <li>
                        <a href="" target="_blank">
                            <i class="fa fa-external-link"></i> 企业端 </a>
                    </li>
                    <li>
                        <a href="" target="_blank">
                            <i class="fa fa-external-link"></i> 消费者端 </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- END PAGE ACTIONS -->
        <!-- BEGIN PAGE TOP -->
        <div class="page-top">
            <!-- BEGIN TOP NAVIGATION MENU -->
            <div class="top-menu">
                <ul class="nav navbar-nav pull-right">
                    <!-- BEGIN USER LOGIN DROPDOWN -->
                    <li class="dropdown dropdown-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                            <img alt="" class="img-circle" src="/misc/src/layouts/layout2/img/avatar.png" />
                            <span class="username username-hide-on-mobile"> <?=$_USER->name?> </span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-default">
                            <li>
                                <a href="<?=url('account/logout')?>">
                                    <i class="icon-key"></i> 退出登录 </a>
                            </li>
                        </ul>
                    </li>
                    <!-- END USER LOGIN DROPDOWN -->
                </ul>
            </div>
            <!-- END TOP NAVIGATION MENU -->
        </div>
        <!-- END PAGE TOP -->
    </div>
    <!-- END HEADER INNER -->
</div>
<!-- END HEADER -->