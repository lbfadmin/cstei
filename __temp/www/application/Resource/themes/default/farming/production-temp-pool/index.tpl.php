<?php
$status_names = [
    0 => '空置',
    1 => '正常',
    2 => '异常'
];
$status_classes = [
    0 => 'warning',
    1 => '',
    2 => 'danger'
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
    <title>暂养池管理 - <?=$_TPL['site_name']?></title>
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
                                <h1>暂养池管理
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
                                                        <span class="caption-subject font-green-steel uppercase bold">暂养池列表</span>
                                                        <span class="caption-helper hide">weekly stats...</span>
                                                    </div>
                                                    <div class="actions">
                                                        <a href="javascript:" class="btn btn-primary btn-circle" data-role="add"><i class="fa fa-plus"> 添加暂养池</i></a>
                                                    </div>
                                                </div>
                                                <div class="portlet-body">
                                                    <form class="form-inline" style="margin-bottom: 15px">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">产品类型</span>
                                                                <select class="form-control" name="product_type_id">
                                                                    <option value="">请选择</option>
                                                                    <?php if (!empty($product_types)):?>
                                                                        <?php foreach ($product_types as $product_type):?>
                                                                            <option value="<?=$product_type->id?>" <?php if ($_GET['product_type_id']==$product_type->id):?>selected<?php endif ?>><?=$product_type->name?></option>
                                                                        <?php endforeach;?>
                                                                    <?php endif ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">状态</span>
                                                                <select class="form-control" name="status">
                                                                    <option value="">请选择</option>
                                                                    <?php foreach ($status_names as $k => $v):?>
                                                                        <option value="<?=$k?>" <?php if ($_GET['status'] !== '' && $_GET['status']==$k):?>selected<?php endif ?>><?=$v?></option>
                                                                    <?php endforeach;?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">ID</span>
                                                                <input class="form-control" name="id" placeholder="养殖池ID" style="width: 100px" value="<?=$this->input->getString('id')?>">
                                                            </div>

                                                        </div>
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">名称</span>
                                                                <input class="form-control" name="name" placeholder="养殖池名称" value="<?=$this->input->getString('name')?>">
                                                            </div>

                                                        </div>
                                                        <button class="btn btn-primary">查询</button>
                                                        <button type="reset" onclick="window.location.href='/farming/temp-pool/index'" class="btn btn-default">重置</button>
                                                        <span class="pull-right btn">共 <?=$result->total?> 条结果</span>
                                                    </form>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-hover">
                                                            <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>名称</th>
                                                                <th>产品类型</th>
                                                                <th style="width: 30%">说明</th>
                                                                <th>开始时间</th>
                                                                <th>结束时间</th>
                                                                <th>状态</th>
                                                                <th>操作</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php if (!empty($result->list)):?>
                                                                <?php foreach ($result->list as $item):
                                                                    ?>
                                                                    <tr data-item='<?=html_attr_json($item)?>'>
                                                                        <td><?=$item->id ?></td>
                                                                        <td><?=$item->name ?></td>
                                                                        <td><?=$item->product_type_name?></td>
                                                                        <td><?=$item->description?>
                                                                        <td><?=$item->time_start?>
                                                                        <td><?=$item->time_end?>
                                                                        <td class="<?=$status_classes[$item->status]?>"><?=$status_names[$item->status]?></td>
                                                                        <td>
                                                                            <div class="btn-group">
                                                                                <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-default btn-xs" data-role="edit"><i class="fa fa-edit"></i> 编辑</a>
                                                                                <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-default btn-xs" data-role="delete" data-id="<?=$item->id?>"><i class="fa fa-times"></i> 删除</a>
                                                                                <a href="/farming/temp-pool-env/index?pool_id=<?=$item->id?>" data-toggle="tooltip" title="" class="btn btn-default btn-xs" data-role="add-maintenance"><i class="fa fa-edit"></i> 环境</a>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach ?>
                                                            <?php else:?>
                                                                <tr>
                                                                    <td colspan="8" class="table-no-results">没有相关结果。</td>
                                                                </tr>
                                                            <?php endif ?>
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
                <h4 class="modal-title">编辑暂养池</h4>
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
            <label class="control-label col-md-3">名称 <span class="required">*</span></label>
            <div class="col-md-8">
                <input class="form-control" name="name" value="<%=item.name%>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">开始时间 <span class="required">*</span></label>
            <div class="col-md-8">
                <input class="form-control" name="time_start" value="<%=item.time_start%>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">结束时间 <span class="required">*</span></label>
            <div class="col-md-8">
                <input class="form-control" name="time_end" value="<%=item.time_end%>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">状态 <span class="required">*</span></label>
            <div class="col-md-8">
                <select class="form-control" name="status">
                    <?php foreach ($status_names as $k => $status):?>
                        <option value="<?=$k?>" <% if (item.status==<?=$k?>) { %>selected<% } %>><?=$status?></option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">产品种类 <span class="required">*</span></label>
            <div class="col-md-8">
                <select class="form-control" name="product_type_id">
                    <?php foreach ($product_types as $type):?>
                        <option value="<?=$type->id?>" <% if (item.product_type_id==<?=$type->id?>) { %>selected<% } %>><?=$type->name?></option>
                    <?php endforeach;?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3">说明 <span class="required">&nbsp;</span></label>
            <div class="col-md-8">
                <textarea name="description" class="form-control" rows="8"><%=item.description%></textarea>
            </div>
        </div>


    </form>
</script>
<?=$this->region('common/scripts')?>
<script>
    $(function () {
        var $modal = $('#modal-form');
        $('[data-role=add]').on('click', function () {
            $modal.find('.modal-body').html(tpl('tpl-form').render({item: {}}));
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
                url: '/farming/ajax/temp-pool/' + (id ? 'update' : 'create'),
                data: $modal.find('form').serialize(),
                type: 'post',
                success: function (result) {
                    layer.msg(result.message, function () {
                        window.location.reload();
                    });
                }
            });
        });
        $('[data-role=delete]').on('click', function () {
            var id = $(this).attr('data-id');
            layer.confirm('您确定删除这条信息吗？', function () {
                $.ajax({
                    url: '/farming/ajax/temp-pool/delete?id=' + id,
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