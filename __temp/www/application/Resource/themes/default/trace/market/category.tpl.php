<?php
function printTree($data) {
    static $depth = 0;
    foreach ($data as $k => $item) {
        ?>
        <tr class="<?=isset($item->children)?'parent':'child'?>"
            data-id="<?=$item->id?>"
            data-item='<?=json_encode(['id' => $item->id, 'name' => $item->name, 'weight' => $item->weight, 'parent_id' => $item->parent_id, 'description' => $item->description])?>'
        >
            <td style="width: 5%"><?=$item->id?></td>
            <td style="width: 30%"><?php echo str_repeat('　　', $depth);?><span class="indent"><i class="fa <?= isset($item->children) ? 'fa-caret-down' : 'fa-caret-right'?>"></i>&nbsp;</span><?=isset($item->children)?'<strong>'.$item->name.'</strong>':$item->name; ?></td>
            <td style="width: 30%"><?=$item->description ?></td>
            <td style="width: 5%"><?=$item->weight ?></td>
            <td style="width: 10%"><?=$item->time_updated ?></td>
            <td>
                <div class="btn-group">
                    <a href="javascript:"
                       data-role="add"
                       data-id="<?=$item->id?>"
                       class="btn btn-xs btn-default">
                        <i class="fa fa-plus"> 添加子类</i>
                    </a>
                    <a href="javascript:"
                       data-toggle="tooltip"
                       data-role="edit"
                       class="btn btn-xs btn-default" data-original-title="编辑"><i class="fa fa-pencil"> 编辑</i></a>
                    <a href="javascript:"
                       data-toggle="tooltip"
                       data-role="delete"
                       data-id="<?=$item->id?>"
                       class="btn btn-xs btn-danger" data-original-title="删除"><i class="fa fa-times"> 删除</i></a>
                </div>
            </td>
        </tr>
        <?php if (isset($item->children)): ?>
            <td style="padding: 0" colspan="6">
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
        <title>养殖池分组分组管理 - <?=$_TPL['site_name']?></title>
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
                                        <h1>养殖池分组管理
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
                                                                <span class="caption-subject font-green-steel uppercase bold">养殖池分组列表</span>
                                                                <span class="caption-helper hide">weekly stats...</span>
                                                            </div>
                                                            <div class="actions">
                                                                <a href="javascript:" class="btn btn-primary btn-circle" data-role="add"><i class="fa fa-plus"> 添加养殖池分组</i></a>
                                                            </div>
                                                        </div>
                                                        <div class="portlet-body">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered table-hover">
                                                                    <thead>
                                                                    <tr>
                                                                        <th style="width: 5%">ID</th>
                                                                        <th style="width: 30%">名称</th>
                                                                        <th style="width: 30%">说明</th>
                                                                        <th style="width: 5%">排序</th>
                                                                        <th style="width: 10%">更新时间</th>
                                                                        <th>操作</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <?php printTree($categories); ?>
                                                                    </tbody>
                                                                </table>
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
            </div>
            <?=$this->region('common/footer')?>
        </div>
        <div class="modal fade" id="modal-form">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">编辑养殖池分组</h4>
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
                <input type="hidden" name="parent_id" value="<%=item.parent_id||0%>">
                <div class="form-group">
                    <label class="control-label col-md-3">名称 <span class="required">*</span></label>
                    <div class="col-md-8">
                        <input class="form-control" name="name" value="<%=item.name%>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">说明 <span class="required">&nbsp;</span></label>
                    <div class="col-md-8">
                        <textarea name="description" class="form-control" rows="8"><%=item.description%></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">排序 <span class="required">&nbsp;</span></label>
                    <div class="col-md-8">
                        <input class="form-control" name="weight" value="<%=item.weight||0%>">
                    </div>
                </div>
            </form>
        </script>
        <?=$this->region('common/scripts')?>
    <script>
        $(function () {
            var $modal = $('#modal-form');
            $('[data-role=add]').on('click', function () {
                var parentId = $(this).attr('data-id');
                $modal.find('.modal-body').html(tpl('tpl-form').render({
                    item: {parent_id: parentId}
                }));
                $modal.modal();
            });
            $('[data-role=edit]').on('click', function () {
                var item = JSON.parse($(this).parents('tr').attr('data-item'));
                $modal.find('.modal-body').html(tpl('tpl-form').render({item: item}));
                $modal.modal();
            });
            $modal.find('.ok').on('click', function () {
                var id = $modal.find('[name=id]').val();
                $.ajax({
                    url: '/farming/ajax/pool-category/' + (id ? 'update' : 'create'),
                    data: $modal.find('form').serialize(),
                    type: 'post',
                    success: function (result) {
                        layer.msg(result.message, {time: 1000}, function () {
                            window.location.reload();
                        });
                    }
                });
            });
            $('[data-role=delete]').on('click', function () {
                var id = $(this).attr('data-id');
                layer.confirm('您确定删除这条信息吗？', function () {
                    $.ajax({
                        url: '/farming/ajax/pool-category/delete?id=' + id,
                        success: function (result) {
                            layer.msg(result.message, {time: 1000}, function () {
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