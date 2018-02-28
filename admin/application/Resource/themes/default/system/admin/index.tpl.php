<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html>
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>用户管理 - <?=$_TPL['site_name']?></title>
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
                    <h1 class="page-title"> 管理员管理
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
                                <i class="fa fa-users"></i>
                                <a href="javascript:">管理员管理</a>
                            </li>
                        </ul>
                    </div>

                    <?=render_message() ?>
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-dark bold">管理员列表</span>
                            </div>
                            <div class="actions">
                                <a href="javascript:" class="btn btn-primary btn-circle" data-role="add"><i class="fa fa-plus"> 添加管理员</i></a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>用户名</th>
                                        <th>邮箱</th>
                                        <th>角色</th>
                                        <th>状态</th>
                                        <th>添加时间</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if ($admins): ?>
                                        <?php foreach ($admins as $item): ?>
                                            <tr>
                                                <td><?=$item->name ?></td>
                                                <td><?=$item->email ?></td>
                                                <td><?=$item->uid == 1 ? '超级管理员' : $item->roleName?></td>
                                                <td><?=$item->status ? '正常' : '禁用' ?></td>
                                                <td><?=date('Y-m-d H:i:s', $item->timeCreated); ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-sm btn-default" data-original-title="编辑" data-role="edit" data-item='<?=html_attr_json($item)?>'><i class="fa fa-pencil"> 编辑</i></a>
                                                        <?php if ($item->status):?>
                                                            <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-sm btn-danger <?php if ($item->uid == 1):?>disabled<?php endif ?>" data-original-title="禁用" data-role="block" data-uid="<?=$item->uid?>"><i class="fa fa-minus-circle"> 禁用</i></a>
                                                        <?php else:?>
                                                            <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-sm btn-info" data-original-title="启用" data-role="unblock" data-uid="<?=$item->uid?>"><i class="fa fa-check-circle"> 启用</i></a>
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
                    <h4 class="modal-title">编辑管理员</h4>
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
            <input type="hidden" name="uid" value="<%=item.uid%>">
            <div class="form-group">
                <label class="control-label col-md-3">角色 <span class="required">*</span></label>
                <div class="col-md-8">
                    <select name="roleId" class="form-control" style="width: 100%">
                        <?php foreach ($roles as & $role): ?>
                            <option value="<?=$role->id?>" <% if (item.roleId=='<?=$role->id?>') { %>selected<% } %>><?=$role->name ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label" for="example-text-input">用户名 <span class="text-danger">*</span></label>
                <div class="col-md-8">
                    <input type="text" name="name" class="form-control" placeholder="名称" value="<%=item.name%>">
                    <span class="help-block">必填项</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label" for="example-text-input">邮箱 <span class="text-danger">*</span></label>
                <div class="col-md-8">
                    <input type="text" name="email" class="form-control" placeholder="邮箱" value="<%=item.email%>">
                    <span class="help-block">必填项</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3 control-label" for="example-text-input">密码 <span class="text-danger">*</span></label>
                <div class="col-md-8">
                    <input type="text" name="pass" class="form-control" placeholder="密码" value="<%=item.pass%>">
                    <span class="help-block">不修改请留空</span>
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
                    item: {parent: $(this).attr('data-name')}
                }));
                $modal.modal();
            });
            $('[data-role=edit]').on('click', function () {
                var item = JSON.parse($(this).attr('data-item'));
                $modal.find('.modal-body').html(tpl('tpl-form').render({
                    item: item
                }));
                $modal.modal();
            });
            $modal.find('.ok').on('click', function () {
				//location.href='/system/ajax/admin/' + (uid !== '' ? 'update' : 'create') + "?"+$modal.find('form').serialize();
				//return;
                var uid = $modal.find('[name=uid]').val();
                $.ajax({
                    url: '/system/ajax/admin/' + (uid !== '' ? 'update' : 'create'),
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
            $('[data-role=block]').on('click', function () {
                var uid = $(this).attr('data-uid');
                layer.confirm('您确定禁用该管理员吗？', function () {
                    $.ajax({
                        url: '/system/ajax/admin/block?uid=' + uid,
                        success: function (result) {
                            layer.msg(result.message, function () {
                                window.location.reload();
                            });
                        }
                    });
                });
            });
            $('[data-role=unblock]').on('click', function () {
                var uid = $(this).attr('data-uid');
                layer.confirm('您确定启用该管理员吗？', function () {
                    $.ajax({
                        url: '/system/ajax/admin/unblock?uid=' + uid,
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