<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html>
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title>鱼药信息 - <?=$_TPL['site_name']?></title>
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
                                <h1>鱼药信息
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
                                                        <span class="caption-subject font-green-steel uppercase bold">鱼药列表</span>
                                                        <span class="caption-helper hide">weekly stats...</span>
                                                    </div>
                                                    <div class="actions">
                                                        <a href="javascript:" class="btn btn-primary btn-circle" data-role="add"><i class="fa fa-plus"> 添加鱼药</i></a>
                                                    </div>
                                                </div>
                                                <div class="portlet-body">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-hover">
                                                            <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>种类</th>
                                                                <th>成分</th>
                                                                <th>适用品种</th>
                                                                <th>适用疾病</th>
                                                                <th>储藏期</th>
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
                                                                        <td><?=$item->ingredient?>
                                                                        <td><?=$item->suit?></td>
                                                                        <td><?=$item->applicable_disease?></td>
                                                                        <td><?=$item->storage_life?></td>
                                                                        <td>
                                                                            <div class="btn-group">
                                                                                <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-default btn-xs" data-role="edit">
                                                                                    <i class="fa fa-edit"></i> 编辑
                                                                                </a>
                                                                                <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-default btn-xs" data-role="delete" data-id="<?=$item->id?>"><i class="fa fa-times"></i> 删除</a>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach ?>
                                                            <?php else:?>
                                                                <tr>
                                                                    <td colspan="7" class="table-no-results">没有相关结果。</td>
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
                <h4 class="modal-title">编辑饲料</h4>
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
            <label class="control-label col-md-3">饲料种类 <span class="required">*</span></label>
            <div class="col-md-8">
                <input class="form-control" name="name" value="<%=item.name%>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">成分 <span class="required">*</span></label>
            <div class="col-md-8">
                <input class="form-control" name="ingredient" value="<%=item.ingredient%>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">适用品种 <span class="required">*</span></label>
            <div class="col-md-8">
                <input class="form-control" name="suit" value="<%=item.suit%>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">适用疾病 <span class="required">*</span></label>
            <div class="col-md-8">
                <input class="form-control" name="applicable_disease" value="<%=item.applicable_disease%>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">储藏期 <span class="required">*</span></label>
            <div class="col-md-8">
                <input class="form-control" name="storage_life" value="<%=item.storage_life%>">
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
        $('[data-role=delete]').on('click', function () {
            var $this = $(this),
                id = $this.attr('data-id');
            layer.confirm('您确定要删除这条信息吗？', function () {
                $.ajax({
                    url: '/farming/ajax/medicine/delete',
                    type: 'post',
                    data: {id: id},
                    success: function (result) {
                        layer.msg(result.message, function () {
                            window.location.reload();
                        });
                    }
                });
            });
        });
        $('[data-role=edit]').on('click', function () {
            var item = JSON.parse($(this).parents('tr').attr('data-item'));
            $modal.find('.modal-body').html(tpl('tpl-form').render({item: item}));
            $modal.modal();
        });
        $modal.find('.ok').on('click', function () {
            var id = $modal.find('[name=id]').val();
            $.ajax({
                url: '/farming/ajax/medicine/' + (id ? 'update' : 'create'),
                data: $modal.find('form').serialize(),
                type: 'post',
                success: function (result) {
                    layer.msg(result.message, function () {
                        window.location.reload();
                    });
                }
            });
        });
    });
</script>
</body>

</html>