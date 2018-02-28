<?php
$statuses = [
    'DRAFT' => '草稿',
    'PUBLISHED' => '已发布',
    'OFFLINE' => '已下线',
    'CREATED' => '待审核'
];
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html>
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>页面管理 - <?=$_TPL['site_name']?></title>
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
                    <h1 class="page-title"> 页面管理
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
                                <i class="fa fa-pencil-square-o"></i>
                                <a href="javascript:">内容管理</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <i class="fa fa-book"></i>
                                <a href="javascript:">页面管理</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <i class="fa fa-list"></i>
                                <a href="javascript:">列表</a>
                            </li>
                        </ul>
                    </div>

                    <?=render_message() ?>
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-dark bold">页面列表</span>
                            </div>
                            <div class="actions">
                                <a class="btn btn-circle btn-primary" href="<?=url('content/page/add') ?>">
                                    <i class="fa fa-plus"> 添加页面</i>
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="40%">摘要</th>
                                    <th width="10%">发布时间</th>
                                    <th width="10%">状态</th>
                                    <th width="10%">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($result->list)):?>
                                    <?php foreach ($result->list as $item):
                                        $classes = [
                                            'DRAFT' => 'warning',
                                            'PUBLISHED' => 'info',
                                            'OFFLINE' => 'default'
                                        ];
                                        ?>
                                        <tr>
                                            <td><?=$item->id ?></td>
                                            <td>
                                                <h4 style="font-size: 15px;"><?=$item->title ?></h4>
                                                <div style="color:#999; font-size: 12px;"><?=mb_substr($item->summary, 0, 100)?></div>
                                            </td>
                                            <td><?=$item->time_published ?></td>
                                            <td><span><?=$statuses[$item->status]?></span></td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="/content/page/edit?id=<?=$item->id?>" data-toggle="tooltip" title="" class="btn btn-default btn-xs" ><i class="fa fa-edit"></i> 编辑</a>
                                                    <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-default btn-xs" data-role="delete" data-id="<?=$item->id?>"><i class="fa fa-times"></i> 删除</a>
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
            $('[data-role=delete]').on('click', function () {
                var id = $(this).attr('data-id');
                layer.confirm('您确定要删除这个页面吗？', function () {
                    $.ajax({
                        url: '/content/ajax/page/delete',
                        data: {id: id},
                        success: function (result) {
                            if (result.code === 'OK') {
                                layer.msg('删除成功', function () {
                                    window.location.reload();
                                });
                            } else {
                                layer.msg(result.message);
                            }
                        }
                    });
                });
            });
        });
    </script>
    </body>

</html>