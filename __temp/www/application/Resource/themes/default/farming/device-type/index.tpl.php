<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html>
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title>设备类型管理 - <?=$_TPL['site_name']?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <?=$this->region('common/styles')?>
    <link rel="shortcut icon" href="favicon.ico" />
</head>
<!-- END HEAD -->

<body class="page-header-menu-fixed page-sidebar-closed-hide-logo page-container-bg-solid">
<div class="page-wrapper">
    <?=$this->region('common/top')?>
    <div class="page-wrapper-row full-height">
        <div class="page-wrapper-middle">
            <div class="page-container">
                <div class="page-content-wrapper">
                    <div class="page-head">
                        <div class="container-fluid">
                            <!-- BEGIN PAGE TITLE -->
                            <div class="page-title">
                                <h1>设备类型管理
                                </h1>
                            </div>
                            <!-- END PAGE TITLE -->
                        </div>
                    </div>
                    <div class="page-content">
                        <div class="container-fluid">
                            <div class="page-content-inner">
                                <div class="mt-content-body">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="portlet light ">
                                                <div class="portlet-title">
                                                    <div class="caption caption-md">
                                                        <i class="icon-bar-chart font-dark hide"></i>
                                                        <span class="caption-subject font-green-steel uppercase bold">设备类型列表</span>
                                                    </div>
                                                    <div class="actions">
                                                        <a href="javascript:" class="btn btn-primary btn-circle" data-role="add"><i class="fa fa-plus"> 添加类型</i></a>
                                                    </div>
                                                </div>
                                                <div class="portlet-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-hover">
                                                            <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>分组名称</th>
                                                                <th>设备类型名称</th>
                                                                <th>设备图片</th>
                                                                <th>控制操作</th>
                                                                <th>创建时间</th>
                                                                <th>操作</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php if (!empty($result->list)):?>
                                                                <?php foreach ($result->list as $item):
                                                                    ?>
                                                                    <tr data-item='<?=html_attr_json($item)?>'>
                                                                        <td><?=$item->id ?></td>
                                                                        <td><?=$categorys->{$item->category_id}->name?></td>
                                                                        <td><?=$item->name?></td>
                                                                        <td><div style="width: 100px;height: 100px;background-image: url(<?=$item->picture?>);background-size: cover;background-position: center;background-color: #ddd;background-repeat: no-repeat"></div></td>
                                                                        <td>
                                                                        <?php if (!empty($item->controllers)):?>
                                                                            <?php foreach ($item->controllers as $controller):?>
                                                                            <div class="btn-group btn-block">
                                                                                <button class="btn btn-sm btn-default"><?=$controller->name?></button>
                                                                                <button class="btn btn-sm btn-info"><?=$controller->action?></button>
                                                                            </div>
                                                                            <?php endforeach;?>
                                                                        <?php endif ?>
                                                                        </td>
                                                                        <td><?=$item->time_created?></td>
                                                                        <td>
                                                                            <div class="btn-group">
                                                                                <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-default btn-xs" data-role="edit"><i class="fa fa-edit"></i> 编辑</a>
                                                                                <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-default btn-xs" data-role="delete" data-id="<?=$item->id?>"><i class="fa fa-times"></i> 删除</a>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach ?>
                                                            <?php else:?>
                                                                <tr>
                                                                    <td colspan="5" class="table-no-results">没有相关结果。</td>
                                                                </tr>
                                                            <?php endif ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div><?=$pager?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?=$this->region('common/footer')?>
</div>
<div class="modal fade" id="modal-form">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">编辑设备类型</h4>
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
            <label class="control-label col-md-3">分组 <span class="required">*</span></label>
            <div class="col-md-8">
                <select class="form-control" name="category_id">
                    <?php foreach ($categorys as $k => $value):?>
                        <option value="<?=$k?>" <% if (item.category_id==<?=$k?>) { %>selected<% } %>><?=$value->name?></option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">名字 <span class="required">*</span></label>
            <div class="col-md-8">
                <input class="form-control" name="name" value="<%=item.name%>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">图片 <span class="required">*</span></label>
            <div class="col-md-8">
                <input type="file" name="picture">
                <% if (item.picture) { %>
                <img src="<%=item.picture%>" style="height:160px;margin-top: 0.5rem;border:1px solid #ddd">
                <% } %>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">控制器 <span class="required">*</span></label>
            <div class="col-md-8">
                <table class="table table-bordered table-light">
                    <thead>
                    <tr>
                        <th>控制器名称</th>
                        <th>操作名称</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <%
                    if (!item.controllers || item.controllers.length === 0) {
                        item.controllers = [{name: '', action: ''}];
                    }
                    %>
                    <% $.each(item.controllers, function(k, v) { %>
                    <tr>
                        <td><input class="form-control" name="controller_name[]" value="<%=v.name%>"></td>
                        <td><input class="form-control" name="controller_action[]" value="<%=v.action%>"></td>
                        <td>
                            <a href="javascript:" class="btn btn-default btn-xs btn-circle" data-role="remove-controller"><i class="fa fa-minus"></i></a>
                            <a href="javascript:" class="btn btn-primary btn-xs btn-circle" data-role="add-controller"><i class="fa fa-plus"></i></a>
                        </td>
                    </tr>
                    <% }); %>
                    </tbody>
                </table>
            </div>
        </div>
    </form>
</script>
<?=$this->region('common/scripts')?>
<script>
    $(function () {
        var $modal = $('#modal-form');
        var initForm = function () {
            $modal.find('[data-role=add-controller]').on('click', function () {
                var $tr = $(this).parents('tr');
                var $new = $tr.clone(true);
                $new.find('input').val('');
                $tr.after($new);
            });
            $modal.find('[data-role=remove-controller]').on('click', function () {
                var $tr = $(this).parents('tr');
                if ($tr.siblings().length === 0) return;
                $tr.remove();
            });
        };
        $('[data-role=add]').on('click', function () {
            $modal.find('.modal-body').html(tpl('tpl-form').render({item: {}}));
            initForm();
            $modal.modal();
        });
        $('[data-role=edit]').on('click', function () {
            var item = JSON.parse($(this).parents('tr').attr('data-item'));
            $modal.find('.modal-body').html(tpl('tpl-form').render({item: item}));
            initForm();
            $modal.modal();
        });
        $modal.find('.ok').on('click', function () {
            var id = $modal.find('[name=id]').val();
            $.ajax({
                url: '/farming/ajax/device-type/' + (id ? 'update' : 'create'),
                data: new FormData($modal.find('form')[0]),
                type: 'post',
                contentType: false,
                processData: false,
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
            layer.confirm('您确定删除这条信息吗？', function () {
                $.ajax({
                    url: '/farming/ajax/device-type/delete?id=' + id,
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