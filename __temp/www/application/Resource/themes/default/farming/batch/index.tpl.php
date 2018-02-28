<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html>
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>批次管理 - <?=$_TPL['site_name']?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <?=$this->region('common/styles')?>
        <link rel="shortcut icon" href="favicon.ico" />
        <style>
            .qr-wrapper {position: relative}
            .qr-wrapper img {position: absolute; left: -10px; top: 20px; display: none; z-index: 10; border: 1px solid #ddd}
        </style>
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
                                        <h1>批次管理
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
                                                                <span class="caption-subject font-green-steel uppercase bold">批次列表</span>
                                                                <span class="caption-helper hide">weekly stats...</span>
                                                            </div>
                                                            <div class="actions">
                                                                <a href="javascript:" class="btn btn-primary btn-circle" data-role="add-batch"><i class="fa fa-plus"> 添加批次</i></a>
                                                            </div>
                                                        </div>
                                                        <div class="portlet-body">
                                                            <form class="form-inline" style="margin-bottom: 15px">
                                                                <div class="form-group">
                                                                    <select class="form-control" name="product_type_id">
                                                                        <option value="">产品种类</option>
                                                                        <?php if (!empty($product_types)):?>
                                                                            <?php foreach ($product_types as $product_type):?>
                                                                                <option value="<?=$product_type->id?>" <?php if ($_GET['product_type_id']==$product_type->id):?>selected<?php endif ?>><?=$product_type->name?></option>
                                                                            <?php endforeach;?>
                                                                        <?php endif ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">批次号</span>
                                                                        <input class="form-control" name="sn" placeholder="请输入批次号" value="<?=$_GET['sn']?>">
                                                                    </div>

                                                                </div>
                                                                <button class="btn btn-primary">查询</button>
                                                                <button type="reset" onclick="window.location.href='/farming/batch/index'" class="btn btn-default">重置</button>
                                                                <span class="pull-right btn">共 <?=$result->total?> 条结果</span>
                                                            </form>
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered table-hover">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>ID</th>
                                                                        <th>批次号</th>
                                                                        <th>产品种类</th>
                                                                        <th>投放数量</th>
                                                                        <th>预计产量</th>
                                                                        <th>预计收获质量</th>
                                                                        <th>开始时间</th>
                                                                        <th>预计收获时间</th>
                                                                        <th>操作</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <?php if (!empty($result->list)):?>
                                                                        <?php foreach ($result->list as $item):
                                                                            ?>
                                                                            <tr data-item='<?=html_attr_json($item)?>'>
                                                                                <td><?=$item->id ?></td>
                                                                                <td><?=$item->sn ?></td>
                                                                                <td><?=$item->product_type_name ?></td>
                                                                                <td><?=$item->amount?></td>
                                                                                <td><?=$item->expect_amount?></td>
                                                                                <td><?=$item->expect_weight?></td>
                                                                                <td><?=$item->date_start?></td>
                                                                                <td><?=$item->date_end?></td>
                                                                                <td>
                                                                                    <?php $url = url('farming/batch/trace?sn=' . $item->sn, ['absolute' => true]); ?>
                                                                                    <a href="<?=$url?>" class="btn btn-link btn-xs qr-wrapper"><i class="fa fa-qrcode"> 追溯</i><img src="/common/qr-code/make?text=<?=$url?>"></a>
                                                                                    <div class="btn-group">
                                                                                        <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-default btn-xs" data-role="edit"><i class="fa fa-edit"></i> 编辑</a>
                                                                                        <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-default btn-xs" data-role="delete" data-id="<?=$item->id?>"><i class="fa fa-times"></i> 删除</a>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        <?php endforeach ?>
                                                                    <?php else:?>
                                                                        <tr>
                                                                            <td colspan="6" class="table-no-results">没有相关结果。</td>
                                                                        </tr>
                                                                    <?php endif ?>
                                                                    </tbody>
                                                                </table>
                                                                <?=$pager?>
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
                        <h4 class="modal-title">编辑批次</h4>
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
                    <label class="control-label col-md-3">批次号 <span class="required">*</span></label>
                    <div class="col-md-8">
                        <input class="form-control" name="sn" value="<%=item.sn%>">
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
                    <label class="control-label col-md-3">养殖池 <span class="required">*</span></label>
                    <div class="col-md-8">
                        <select class="form-control select2-multiple" multiple name="pool_id[]" style="width: 100%">
                            <?php foreach ($pools as $pool):?>
                                <option value="<?=$pool->id?>" <% if ($.inArray('<?=$pool->id?>', item.pools) !== -1) { %>selected<% } %>><?=$pool->name?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">投放数量 <span class="required">*</span></label>
                    <div class="col-md-8">
                        <input class="form-control" name="amount" value="<%=item.amount%>" placeholder="如：1000">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">预期产量 <span class="required">*</span></label>
                    <div class="col-md-8">
                        <input class="form-control" name="expect_amount" value="<%=item.expect_amount%>" placeholder="如：900">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">预期收获质量 <span class="required">*</span></label>
                    <div class="col-md-8">
                        <input class="form-control" name="expect_weight" value="<%=item.expect_weight%>" placeholder="如：5000">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">开始养殖时间 <span class="required">*</span></label>
                    <div class="col-md-8">
                        <input class="form-control date" name="date_start" value="<%=item.date_start%>" placeholder="如：2016-10-01">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">预计收获时间 <span class="required">*</span></label>
                    <div class="col-md-8">
                        <input class="form-control date" name="date_end" value="<%=item.date_end%>" placeholder="如：2017-02-01">
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
            var initModal = function () {
                $modal.find('.select2-multiple').select2();
                $modal.find('.date').datetimepicker({
                    minView: 'month',
                    format: 'yyyy-mm-dd',
                    language: 'zh-CN',
                    autoclose: true
                });
            };
            $('[data-role=add-batch]').on('click', function () {
                $modal.find('.modal-body').html(tpl('tpl-form').render({item: {}}));
                initModal($modal);
                $modal.modal();
            });
            $('[data-role=edit]').on('click', function () {
                var item = JSON.parse($(this).parents('tr').attr('data-item'));
                $modal.find('.modal-body').html(tpl('tpl-form').render({item: item}));
                initModal($modal);
                $modal.modal();
            });
            $modal.find('.ok').on('click', function () {
                var id = $modal.find('[name=id]').val();
                $.ajax({
                    url: '/farming/ajax/batch/' + (id ? 'update' : 'create'),
                    data: $modal.find('form').serialize(),
                    type: 'post',
                    success: function (result) {
                        if (result.code !== 'OK') {
                            layer.msg(result.message);
                            return;
                        }
                        layer.msg('保存成功', {time: 1000}, function () {
                            window.location.reload();
                        });
                    }
                });
            });
            $('[data-role=delete]').on('click', function () {
                var id = $(this).attr('data-id');
                layer.confirm('您确定删除这条信息吗？', function () {
                    $.ajax({
                        url: '/farming/ajax/batch/delete?id=' + id,
                        success: function (result) {
                            layer.msg(result.message, {time: 1000}, function () {
                                window.location.reload();
                            });
                        }
                    });
                });
            });
            $('.qr-wrapper').on('mouseenter', function () {
                $(this).find('img').show();
            }).on('mouseleave', function () {
                $(this).find('img').hide();
            });
        });
    </script>
    </body>

</html>