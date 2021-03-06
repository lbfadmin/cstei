<?php
function printTree($data) {
    static $depth = 0;
    foreach ($data as $k => $item) {
        ?>
        <tr class="<?=isset($item->children)?'parent':'child'?>"
            data-id="<?=$item->id?>"
            data-item='<?=json_encode(['id' => $item->id, 'name' => $item->name, 'weight' => $item->weight, 'parent_id' => $item->parent_id])?>'
        >
            <td style="width: 5%"><?=$item->id?></td>
            <td style="width: 50%"><?php echo str_repeat('　　', $depth);?><span class="indent"><i class="fa <?= isset($item->children) ? 'fa-caret-down' : 'fa-caret-right'?>"></i>&nbsp;</span><?=isset($item->children)?'<strong>'.$item->name.'</strong>':$item->name; ?></td>
            <td style="width: 20%"><?=$item->weight ?></td>
            <td style="width: 20%">
                <div class="btn-group">
                    <a href="javascript:"
                       data-role="add-category"
                       class="btn btn-xs btn-default">
                        <i class="fa fa-plus"> 添加子类</i>
                    </a>
                    <a href="javascript:"
                       data-toggle="tooltip"
                       data-role="edit-category"
                       class="btn btn-xs btn-default" data-original-title="编辑"><i class="fa fa-pencil"> 编辑</i></a>
                    <a href="javascript:"
                       data-toggle="tooltip"
                       data-role="delete-category"
                       class="btn btn-xs btn-danger" data-original-title="删除"><i class="fa fa-times"> 删除</i></a>
                </div>
            </td>
        </tr>
        <?php if (isset($item->children)): ?>
            <td style="padding: 0" colspan="4">
                <table class="table nested table-striped table-bordered table-hover" style="border: none;margin-bottom:0">
                    <?php
                    if (isset($item->children)) {
                        $depth++;
                        printTree($item->children);
                    }
                    ?>
                </table>
            </td>
        <?php endif ?>
    <?php }
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
    <title>商品分类管理 - <?=$_TPL['site_name']?></title>
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
            <h1 class="page-title"> 商品分类管理
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
                        <a href="javascript:">消费者端</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <i class="fa fa-book"></i>
                        <a href="javascript:">商品</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <i class="fa fa-list"></i>
                        <a href="javascript:">分类</a>
                    </li>
                </ul>
            </div>

            <?=render_message() ?>
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject font-dark bold">分类列表</span>
                    </div>
                    <div class="actions">
                        <a class="btn btn-circle btn-primary" href="javascript:" data-role="add-category" data-item='<?=json_encode(['id' => 0])?>'>
                            <i class="fa fa-plus"> 添加分类</i>
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th width="5%">ID</th>
                            <th>名称</th>
                            <th>权重</th>
                            <th width="10%">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php printTree($categories); ?>
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
                <h4 class="modal-title">编辑类目</h4>
            </div>
            <div class="modal-body">
                <form class="form form-horizontal" method="post">
                    <input type="hidden" name="id">
                    <input type="hidden" name="parent_id">
                    <div class="form-group">
                        <label class="control-label col-md-3">类目名称 <span class="required">*</span></label>
                        <div class="col-md-8">
                            <input class="form-control" name="name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">排序 <span class="">&nbsp;</span></label>
                        <div class="col-md-8">
                            <input class="form-control" name="weight" value="0">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary ok">保存</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<?=$this->region('common/footer')?>
<?=$this->region('common/scripts')?>
<script>
    $(function () {
        var $modalForm = $('#modal-form');
        // 修改类目
        $('[data-role=edit-category]').on('click', function () {
            var $this = $(this),
                $tr = $this.parents('tr'),
                category = JSON.parse($tr.attr('data-item'));
            $modalForm.find('[name=id]').val(category.id);
            $modalForm.find('[name=name]').val(category.name);
            $modalForm.find('[name=weight]').val(category.weight);
            $modalForm.find('[name=parent_id]').val(category.parent_id).attr('disabled', true);
            $modalForm.modal();
            $modalForm.data('action', 'update');
        });
        // 添加类目
        $('[data-role=add-category]').on('click', function () {
            var $this = $(this),
                $tr = $this.parents('tr');
            var category = $tr.length ? JSON.parse($tr.attr('data-item')) : {};
            $modalForm.find('[name=parent_id]').val(category.id).attr('disabled', false);
            $modalForm.find('[name=id]').val('');
            $modalForm.find('[name=name]').val('');
            $modalForm.find('[name=weight]').val(0);
            $modalForm.modal();
            $modalForm.data('action', 'add');
        });
        $modalForm.find('.ok').on('click', function () {
            var action = $modalForm.data('action');
            if (action == 'add') {
                $.ajax({
                    url: '/consumer/ajax/goods/category/add',
                    type: 'post',
                    data: $modalForm.find('form').serialize(),
                    success: function (result) {
                        $modalForm.modal('hide');
                        layer.msg(result.message, function () {
                            window.location.reload();
                        });
                    }
                });
            }
            if (action === 'update') {
                $.ajax({
                    url: '/consumer/ajax/goods/category/update',
                    type: 'post',
                    data: $modalForm.find('form').serialize(),
                    success: function (result) {
                        $modalForm.modal('hide');
                        layer.msg(result.message, function () {
                            window.location.reload();
                        });
                    }
                });
            }
        });
        // 删除类目
        var $modalFormDelete = $('#modal-form-delete');
        $('[data-role=delete-category]').on('click', function () {
            var $this = $(this),
                $tr = $this.parents('tr'),
                category = JSON.parse($tr.attr('data-item'));
            layer.confirm('您确定要删除这个分类吗（如果分类下有子分类请先删除子分类）？', function () {
                $.ajax({
                    url: '/consumer/ajax/goods/category/delete',
                    type: 'post',
                    data: {id: category.id},
                    success: function (result) {
                        $modalFormDelete.modal('hide');
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