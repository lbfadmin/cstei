<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html>
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>模块管理 - <?=$_TPL['site_name']?></title>
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
                    <h1 class="page-title"> 模块管理
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
                                <i class="fa fa-wrench"></i>
                                <a href="javascript:">系统设置</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <span>模块管理</span>
                            </li>
                        </ul>
                    </div>

                    <?=render_message() ?>

                    <!-- END PAGE HEADER-->
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-dark bold">模块列表</span>
                            </div>
                            <div class="actions">
                                <a href="javascript:" class="btn btn-primary btn-circle" data-role="install"><i class="fa fa-plus"> 安装模块</i></a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>名称</th>
                                        <th>路径</th>
                                        <th>描述</th>
                                        <th>作者</th>
                                        <th>安装时间</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($modules as $item): ?>
                                        <tr>
                                            <td><?=$item->title ?></td>
                                            <td><?=$item->path ?></td>
                                            <td><?=$item->description ?></td>
                                            <td><a href="<?php echo $item->author['homepage'] ?>" target="_blank" title=""><?php echo $item->author['name'];?></a> <?php if ($item->author['email']): ?> (<?php echo $item->author['email'] ?>)<?php endif ?></td>
                                            <td><?=date('Y-m-d H:i:s', $item->timestamp); ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="<?=url('system/module/reload', array('query' => array('id' => $item->id))) ?>" data-toggle="tooltip" title="" class="btn btn-sm btn-default" data-original-title="<重新加载配置"><i class="fa fa-refresh"></i> 重载</a>
                                                    <a href="javascript:" data-toggle="tooltip" title="" data-role="uninstall" data-id="<?=$item->id?>" class="btn btn-sm btn-danger" data-original-title="卸载"><i class="fa fa-times"> 卸载</i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->
    <div class="modal fade" id="modal-form">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">编辑模块</h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary ok">保存</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <script type="text/html" id="tpl-form">
        <form class="form form-horizontal" method="post">
            <input type="hidden" name="id" value="<%=item.id%>">
            <div class="form-group">
                <label class="control-label col-md-3">模块路径 <span class="required">*</span></label>
                <div class="col-md-8">
                    <input class="form-control" name="path">
                </div>
            </div>
        </form>
    </script>
    <?=$this->region('common/footer')?>
    <?=$this->region('common/scripts')?>
    <script>
        $(function () {
            var $modal = $('#modal-form');
            $('[data-role=install]').on('click', function () {
                $modal.find('.modal-body').html(tpl('tpl-form').render({item: {}}));
                $modal.modal();
            });
            $modal.find('.ok').on('click', function () {
                var id = $modal.find('[name=id]').val();
                $.ajax({
                    url: '/system/ajax/module/install',
                    data: $modal.find('form').serialize(),
                    type: 'post',
                    success: function (result) {
                        if (result.code === 'OK') {
                            layer.msg(result.message, function () {
                                window.location.reload();
                            });
                        } else {
                            layer.msg(result.message);
                        }
                    }
                });
            });
            $('[data-role=uninstall]').on('click', function () {
                var id = $(this).attr('data-id');
                layer.confirm('您确定卸载这个模块吗？', function () {
                    window.location.href = '/system/module/uninstall?id=' + id;
                });
            });
        });
    </script>
    </body>

</html>