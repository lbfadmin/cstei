<?php
function printTree($data, $modules) {
    static $depth = 0;
    foreach ($data as $k => $item) {
        ?>
        <tr>
            <td><?= str_repeat('　　', $depth);?>
                <?php if ($item->icon): ?><i class="<?=$item->icon ?>"></i><?php endif ?>
                <?= $item->title; ?>
                <?php if (!empty($item->children)):?>
                <i class="fa fa-caret-down"></i>
                <?php endif ?>
            </td>
            <td><?=$item->name ?></td>
            <td><?=$item->url ?></td>
            <td><?=$modules[$item->moduleId]->title ?></td>
            <td><?=$item->permission ?></td>
            <td><?=$item->weight ?></td>
            <td>
                <div class="btn-group">
                    <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-sm btn-default" data-original-title="编辑" data-role="add" data-name="<?=$item->name?>"><i class="fa fa-plus"></i> 添加子菜单</a>
                    <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-sm btn-default" data-original-title="编辑" data-role="edit" data-item='<?=html_attr_json($item)?>'><i class="fa fa-edit"></i> 编辑</a>
                    <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-sm btn-danger" data-original-title="删除" data-role="delete" data-name="<?=$item->name?>"><i class="fa fa-times"></i> 删除</a>
                </div>
            </td>
        </tr>
        <?php
        if ($item->children) {
            $depth++;
            printTree($item->children, $modules);
        }
    }
    $depth--;
}
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
        <title>菜单管理 - <?=$_TPL['site_name']?></title>
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
                    <h1 class="page-title"> 菜单管理
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
                                <span>菜单管理</span>
                            </li>
                        </ul>
                    </div>

                    <?=render_message() ?>

                    <!-- END PAGE HEADER-->
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-dark bold">菜单列表</span>
                            </div>
                            <div class="actions">
                                <a class="btn btn-circle btn-primary" data-role="add" href="javascript:">
                                    <i class="fa fa-plus"></i> 添加菜单
                                </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>显示名</th>
                                    <th>机器名</th>
                                    <th>路径</th>
                                    <th>模块</th>
                                    <th>权限</th>
                                    <th>权重</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if ($menus): ?>
                                    <?php printTree($menus, $modules) ?>
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
    <div class="modal fade" id="modal-form">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">编辑菜单项</h4>
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
                <label class="control-label col-md-3">机器名 <span class="required">*</span></label>
                <div class="col-md-8">
                    <input class="form-control" name="name" value="<%=item.name%>" placeholder="">
                    <div class="help-block">小写字母和-短横线组成的字符，菜单项唯一标识</div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">显示名 <span class="required">*</span></label>
                <div class="col-md-8">
                    <input class="form-control" name="title" value="<%=item.title%>" placeholder="">
                    <div class="help-block">菜单显示的名称</div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">父菜单项 <span class="required">&nbsp;</span></label>
                <div class="col-md-8">
                    <input class="form-control" name="parent" value="<%=item.parent%>">
                    <div class="help-block">父菜单项机器名</div>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">图标class <span class="required">&nbsp;</span></label>
                <div class="col-md-8">
                    <input class="form-control" name="icon" value="<%=item.icon%>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">地址 <span class="required">&nbsp;</span></label>
                <div class="col-md-8">
                    <input class="form-control" name="url" value="<%=item.url%>" placeholder="">
                    <div class="help-block">内部相对路径或外部链接</div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">访问权限 <span class="required">&nbsp;</span></label>
                <div class="col-md-8">
                    <input class="form-control" name="permission" value="<%=item.permission%>" placeholder="">
                    <div class="help-block">已存在的系统权限，留空为公开权限</div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">排序权重 <span class="required">&nbsp;</span></label>
                <div class="col-md-8">
                    <input class="form-control" name="weight" value="<%=item.weight||0%>" placeholder="">
                    <div class="help-block">数值越大越靠后</div>
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
				location.href='/system/ajax/menu/'+ action + '?'+$modal.find('form').serialize();
//				alert();
				return;
                $.ajax({
                    url: '/system/ajax/menu/' + action,
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
                var name = $(this).attr('data-name');
                layer.confirm('您确定删除这条菜单吗？', function () {
                    $.ajax({
                        url: '/system/ajax/menu/delete?name=' + name,
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