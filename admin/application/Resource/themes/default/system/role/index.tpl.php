<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html>
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>角色管理 - <?=$_TPL['site_name']?></title>
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
                    <h1 class="page-title"> 角色管理
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
                                <span>角色管理</span>
                            </li>
                        </ul>
                    </div>

                    <?=render_message() ?>

                    <!-- END PAGE HEADER-->
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-dark bold">角色列表</span>
                            </div>
                            <div class="actions">
                                <a class="btn btn-circle btn-primary" data-role="add" href="javascript:">
                                    <i class="fa fa-plus"></i> 添加角色
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>名称</th>
                                        <th>描述</th>
                                        <th>添加时间</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if ($roles): ?>
                                        <?php foreach ($roles as $item): ?>
                                            <tr>
                                                <td><?=$item->name ?></td>
                                                <td><?=$item->description ?></td>
                                                <td><?=date('Y-m-d H:i:s', $item->timeCreated); ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="<?=url('system/role-permission/edit', array('query' => array('roleId' => $item->id))) ?>" data-toggle="tooltip" title="" class="btn btn-sm btn-info" data-original-title="编辑权限"><i class="fa fa-lock"> 编辑权限</i>
                                                        </a>
                                                    </div>
                                                    <div class="btn-group">
                                                        <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-sm btn-default" data-original-title="编辑" data-role="edit" data-item='<?=html_attr_json($item)?>'><i class="fa fa-pencil"> 编辑</i>
                                                        </a>
                                                        <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-sm btn-danger" data-original-title="删除" data-role="delete" data-id="<?=$item->id?>"><i class="fa fa-times"> 删除</i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                    </tbody>
                                </table>
                            </div>
                            <div><?=$pager?></div>
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
                    <h4 class="modal-title">编辑角色项</h4>
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
            <input type="hidden" name="action" value="<%=action%>">
            <input type="hidden" name="id" value="<%=item.id%>">
            <div class="form-group">
                <label class="control-label col-md-3">角色名称 <span class="required">*</span></label>
                <div class="col-md-8">
                    <input class="form-control" name="name" value="<%=item.name%>" placeholder="">
                    <div class="help-block">30字以内</div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">角色说明 <span class="required">&nbsp;</span></label>
                <div class="col-md-8">
                    <textarea name="description" class="form-control" rows="8"><%=item.description%></textarea>
                </div>
            </div>
        </form>
    </script>
        <?=$this->region('common/footer')?>
        <?=$this->region('common/scripts')?>
    <script>
        $(function () {
            var $modal = $('#modal-form');
            $('[data-role=add]').on('click', function () {
                $modal.find('.modal-body').html(tpl('tpl-form').render({
                    item: {parent: $(this).attr('data-name')},
                    action: 'create'
                }));
                $modal.modal();
            });
            $('[data-role=edit]').on('click', function () {
                var item = JSON.parse($(this).attr('data-item'));
                $modal.find('.modal-body').html(tpl('tpl-form').render({
                    item: item,
                    action: 'update'
                }));
                $modal.modal();
            });
            $modal.find('.ok').on('click', function () {
                var action = $modal.find('[name=action]').val();
                $.ajax({
                    url: '/system/ajax/role/' + action,
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
            $('[data-role=delete]').on('click', function () {
                var id = $(this).attr('data-id');
                layer.confirm('您确定删除该角色吗？', function () {
                    $.ajax({
                        url: '/system/ajax/role/delete?id=' + id,
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