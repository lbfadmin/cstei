<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html>
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>孵化器管理 - <?=$_TPL['site_name']?></title>
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
                    <h1 class="page-title"> 孵化器管理
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
                                <a href="javascript:">园区管理</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="javascript:">设备管理</a>
                            </li>
                        </ul>
                    </div>

                    <?=render_message() ?>

                    <!-- END PAGE HEADER-->
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-dark bold">设备列表</span>
                            </div>
                            <div class="actions">
                                <a class="btn btn-circle btn-primary" href="<?=url('company/device/add') ?>">
                                    <i class="fa fa-plus"> 添加设备</i>
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <form class="form-inline area-selector" style="margin-bottom: 15px">

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">设备名称</span>
                                        <input class="form-control" name="device_name" placeholder="设备名称" value="<?=$this->input->getString('device_name')?>">
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
                                    <th class="col-md-3">启用时间</th>
                                    <th class="col-md-1">参数</th>
                                    <th class="col-md-2">图片</th>
                                    <th class="col-md-1">类型</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($result->list)):?>
                                    <?php foreach ($result->list as $item):
                                        ?>
                                        <tr>
                                            <td><?=$item->id ?></td>
                                            <td><?=$item->device_name?></td>
                                            <td><?=$item->time_use?>
                                            </td>
                                            <td><?=$item->canshu ?></td>
                                            <td><p style="max-width: 300px;"><img src="<?=$item->pic?>"  /></td>
                                            <td><?=$item->devicetype_name ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="/company/device/check?id=<?=$item->id?>" data-toggle="tooltip" title="" class="btn btn-default btn-xs" ><i class="fa fa-edit"></i> 查看</a>
                                                    <a href="/company/device/edit?id=<?=$item->id?>" data-toggle="tooltip" title="" class="btn btn-default btn-xs" ><i class="fa fa-edit"></i> 编辑</a>
                                                    <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-default btn-xs" data-role="delete" data-id="<?=$item->id?>"><i class="fa fa-times"></i> 删除</a>
                                                    <?php if($item->status==0):?>
                                                    <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-default btn-xs" data-role="start" data-id="<?=$item->id?>"><i class="fa fa-edit"></i> 启用</a>
                                                    <?php else:?>
                                                    <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-default btn-xs" data-role="stop" data-id="<?=$item->id?>"><i class="fa fa-edit"></i> 停用</a>
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
    <script src="/misc/src/global/scripts/selector.area.js"></script>
    <script>
        $(function () {
            $('.area-selector').areaSelector();
        });
    </script>
    <script>
        $(function () {
            $('[data-role=delete]').on('click', function () {
                var $this = $(this),
                    id = $this.attr('data-id');
                layer.confirm('您确定要删除这条记录吗？', function () {
                    $.ajax({
                        url: '/company/ajax/device/delete',
                        type: 'post',
                        data: {id: id},
                        success: function (result) {
                            layer.msg(result.message, function () {
                                window.location.reload();
                            });
                        }
                    });
                });
            });
            //启用
            $('[data-role=start]').on('click', function () {
                var $this = $(this),
                    id = $this.attr('data-id');
                layer.confirm('您确定要启用这个设备吗？', function () {
                    $.ajax({
                        url: '/company/ajax/device/start',
                        type: 'post',
                        data: {id: id},
                        success: function (result) {
                            layer.msg(result.message, function () {
                                window.location.reload();
                            });
                        }
                    });
                });
            });
            //停用
            $('[data-role=stop]').on('click', function () {
                var $this = $(this),
                    id = $this.attr('data-id');
                layer.confirm('您确定要停用这个设备吗？', function () {
                    $.ajax({
                        url: '/company/ajax/device/stop',
                        type: 'post',
                        data: {id: id},
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