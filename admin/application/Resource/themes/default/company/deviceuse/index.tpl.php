<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html>
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>设备申请管理 - <?=$_TPL['site_name']?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <?=$this->region('common/styles')?>
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="/misc/src/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <link rel="shortcut icon" href="favicon.ico" />
    </head>
    <!-- END HEAD -->

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid">
    <?=$this->region('common/header')?>
        <!-- BEGIN HEADER & CONTENT DIVIDER -->
        <div class="clearfix"> </div>
        <!-- END HEADER & CONTENT DIVIDER -->
        <!-- BEGIN CONTAINER -->
        <div class="page-container">
            <?=$this->region('common/sidebar')?>
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    <h1 class="page-title"> 设备申请管理
                        <small></small>
                    </h1>
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a href="<?=url('dashboard')?>">首页</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <i class="fa fa-industry"></i>
                                <a href="javascript:">设备列表</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="javascript:">设备申请管理</a>
                            </li>
                        </ul>
                    </div>

                    <?=render_message() ?>

                    <!-- END PAGE HEADER-->
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-dark bold">申请列表</span>
                            </div>

                        </div>
                        <div class="portlet-body">
                            <form class="form-inline area-selector" style="margin-bottom: 15px">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">状态</div>
                                        <select name="status" class="form-control provinces">

                                            <option value="" selected>--请选择状态--</option>
                                            <?php foreach($status as $k=>$v):?>
                                                <option  value="<?=$k?>"><?=$v?></option>
                                            <?php endforeach?>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">设备名称</span>
                                        <select name="device_id" class="form-control provinces  ">
                                            <option value="" selected>--请选择设备--</option>
                                            <?php foreach($device as $k=>$v):?>
                                                <option  value="<?=$k?>"><?=$v?></option>
                                            <?php endforeach?>
                                        </select>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">公司名称</span>
                                        <select name="company_id" class="form-control provinces  ">
                                            <option value="" selected>--请选择公司--</option>
                                            <?php foreach($company as $k=>$v):?>
                                                <option  value="<?=$k?>"><?=$v?></option>
                                            <?php endforeach?>
                                        </select>
                                    </div>

                                </div>
                                <button class="btn btn-primary">查询</button>
                                <button type="reset" onclick="window.location.href=window.location.pathname" class="btn btn-default">重置</button>
                                <span class="pull-right btn">共 <?=$result->total?> 条结果</span>
                            </form>
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th class="col-md-2">设备名称</th>
                                    <th class="col-md-2">申请公司</th>
                                    <th class="col-md-1">申请时间</th>
                                    <th class="col-md-1">申请使用时间</th>
                                    <th class="col-md-1">申请归还时间</th>
                                    <th class="col-md-2">用途</th>
                                    <th class="col-md-1">状态</th>
                                    <th class="col-md-2">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($result->list)):?>
                                    <?php foreach ($result->list as $item):
                                        ?>
                                        <tr>
                                            <td><?=$item->id ?></td>
                                            <td><?=$item->device_name?></td>
                                            <td><?=$item->company_name?></td>
                                            <td>
                                                <?=$item->time_apply?>
                                            </td>
                                            <td><?=$item->time_start ?></td>
                                            <td><p style="max-width: 300px;"><?=$item->time_end ?></p></td>
                                            <td><?=mb_substr($item->yongtu, 0, 100)?></td>
                                            <td>
                                                <?php foreach($status as $k=>$v):
                                                    if($k==$item->status):?>
                                                    <?=$v?>
                                                <?php endif;  endforeach ?>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <?php if($item->status==0):?>
                                                        <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-default btn-xs" data-role="yes" data-id="<?=$item->id?>"><i class="fa fa-edit"></i> 通过</a>
                                                        <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-default btn-xs" data-role="no" data-id="<?=$item->id?>"><i class="fa fa-times"></i> 拒绝</a>
                                                    <?php endif ?>
                                                    <?php if($item->status==1):?>
                                                        <a href="#" data-toggle="tooltip" title="" class="btn btn-default btn-xs" ><i class="fa fa-edit"></i> 正在使用</a>
                                                    <?php endif ?>
                                                    <?php if($item->status==2):?>
                                                        <a href="#" data-toggle="tooltip" title="" class="btn btn-default btn-xs" ><i class="fa fa-edit"></i> 已拒绝</a>
                                                    <?php endif ?>
                                                    <?php if($item->status==4):?>
                                                        <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-default btn-xs" data-role="finish" data-id="<?=$item->id?>"><i class="fa fa-edit"></i> 完成</a>
                                                    <?php endif ?>
                                                    <?php if($item->status==5):?>
                                                        <a href="#" data-toggle="tooltip" title="" class="btn btn-default btn-xs" ><i class="fa fa-edit"></i> 已完成</a>
                                                    <?php endif ?>

                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php endif ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->
        <?=$this->region('common/footer')?>
        <?=$this->region('common/scripts')?>

    <script>
        $(function () {
            $('[data-role=yes]').on('click', function () {
                var $this = $(this),
                    id = $this.attr('data-id');
                var status=1;
                layer.confirm('您确定要通过这个申请吗？', function () {
                    $.ajax({
                        url: '/company/ajax/device-use/usestatus',
                        type: 'post',
                        data: {id: id,status: status},
                        success: function (result) {
                            layer.msg(result.message, function () {
                                window.location.reload();
                            });
                        }
                    });
                });
            });
            $('[data-role=no]').on('click', function () {
                var $this = $(this),
                    id = $this.attr('data-id');
                var status=2;
                layer.confirm('您确定要拒绝这个申请吗？', function () {
                    $.ajax({
                        url: '/company/ajax/device-use/usestatus',
                        type: 'post',
                        data: {id: id,status:status},
                        success: function (result) {
                            layer.msg(result.message, function () {
                                window.location.reload();
                            });
                        }
                    });
                });
            });
            $('[data-role=finish]').on('click', function () {
                var $this = $(this),
                    id = $this.attr('data-id');
                var status =5;
                layer.confirm('您确定要完成这个记录吗？', function () {
                    $.ajax({
                        url: '/company/ajax/device-use/usestatus',
                        type: 'post',
                        data: {id: id,status:status},
                        success: function (result) {
                            layer.msg(result.message, function () {
                                window.location.reload();
                            });
                        }
                    });
                });
            });
        });
    </script>
    </body>

</html>