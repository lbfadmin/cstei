<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html>
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>视频列表- <?=$_TPL['site_name']?></title>
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
                    <h1 class="page-title"> 视频列表
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
                                <a href="javascript:">视频管理</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="javascript:">列表</a>
                            </li>
                        </ul>
                    </div>

                    <?=render_message() ?>

                    <!-- END PAGE HEADER-->
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-dark bold">视频列表</span>
                            </div>
                            <div class="actions">
                                <a class="btn btn-circle btn-primary" href="<?=url('producer/video/video/add') ?>">
                                    <i class="fa fa-plus"> 添加视频</i>
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <form class="form-inline area-selector" style="margin-bottom: 15px">

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">视频名称</span>
                                        <input class="form-control" name="title" placeholder="视频名称" value="<?=$this->input->getString('title')?>">
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
                                    <th class="col-md-2">企业名称</th>
                                    <th class="col-md-3">视频名称</th>
                                    <th class="col-md-1">rtmp地址</th>
                                    <th class="col-md-3">hls地址</th>
                                    <th>更新时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($result->list)):?>
                                    <?php foreach ($result->list as $item):
                                        ?>
                                        <tr>
                                            <td><?=$item->id ?></td>
                                            <td>
                                                <h4 style="margin-left: 70px; font-size: 15px;"><?=$item->company_name ?></h4>

                                            </td>
                                            <td><?=$item->title ?></td>
                                            <td><p style="max-width: 300px;"><?=$item->rtmp_url ?></p></td>
                                            <td><?=$item->hls_url ?></td>
                                            <td><?=$item->time_updated ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="/producer/video/video/edit?id=<?=$item->id?>" data-toggle="tooltip" title="" class="btn btn-default btn-xs" ><i class="fa fa-edit"></i> 编辑</a>
                                                    <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-default btn-xs" data-role="delete" data-id="<?=$item->id?>"><i class="fa fa-times"></i> 删除</a>
                                                </div>
                                                <div class="btn-group">
                                                    <a href="/producer/videl/video/index?video_id=<?=$item->id?>" data-toggle="tooltip" title="" class="btn btn-primary btn-xs" ><i class="fa fa-edit"></i> 详情</a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php endif ?>
                                </tbody>
                            </table>
                            <?=$pager?>
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
                        url: '/producer/ajax/video/video/delete',
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