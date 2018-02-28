<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html>
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title>养殖环境信息 - <?=$_TPL['site_name']?></title>
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
                                <h1>养殖环境信息
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
                                                        <span class="caption-subject font-green-steel uppercase bold">养殖环境列表</span>
                                                        <span class="caption-helper hide">weekly stats...</span>
                                                    </div>
                                                </div>
                                                <div class="portlet-body">
                                                    <form class="form-inline" style="margin-bottom: 15px">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">养殖池ID</span>
                                                                <input class="form-control" name="pool_id" placeholder="养殖池ID" style="width: 100px" value="<?=$this->input->getString('pool_id')?>">
                                                            </div>

                                                        </div>
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <input class="form-control datetimepicker" name="created_start" placeholder="开始时间" value="<?=$this->input->getString('created_start')?>">
                                                                <span class="input-group-addon">到</span>
                                                                <input class="form-control datetimepicker" name="created_end" placeholder="结束时间" value="<?=$this->input->getString('created_end')?>">
                                                            </div>

                                                        </div>
                                                        <button class="btn btn-primary">查询</button>
                                                        <button type="reset" onclick="window.location.href='/farming/production-env/index'" class="btn btn-default">重置</button>
                                                        <span class="pull-right btn">共 <?=$result->total?> 条结果</span>
                                                    </form>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered table-hover">
                                                            <thead>
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>养殖池</th>
                                                                <th>光照</th>
                                                                <th>水温</th>
                                                                <th>盐度</th>
                                                                <th>氨氮</th>
                                                                <th>PH</th>
                                                                <th>溶解氧</th>
                                                                <th>亚硝基氮</th>
                                                                <th>采集时间</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php if (!empty($result->list)):?>
                                                                <?php foreach ($result->list as $item):
                                                                    ?>
                                                                    <tr data-item='<?=html_attr_json($item)?>'>
                                                                        <td><?=$item->id ?></td>
                                                                        <td><a href="/farming/pool/index?id=<?=$item->pool_id?>"><?=$item->pool_name ?> (#<?=$item->pool_id?>)</a> </td>
                                                                        <td><?=$item->light?></td>
                                                                        <td><?=$item->temperature?></td>
                                                                        <td><?=$item->salt?>
                                                                        <td><?=$item->an?></td>
                                                                        <td><?=$item->ph?></td>
                                                                        <td><?=$item->oxy?></td>
                                                                        <td><?=$item->nn?></td>
                                                                        <td><?=$item->time_created?></td>
                                                                    </tr>
                                                                <?php endforeach ?>
                                                            <?php else:?>
                                                                <tr>
                                                                    <td colspan="20" class="table-no-results">没有相关结果。</td>
                                                                </tr>
                                                            <?php endif ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
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
    <?=$this->region('common/footer')?>
</div>
<div class="modal fade" id="modal-form">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">编辑养殖环境</h4>
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
            <label class="control-label col-md-3">养殖池ID <span class="required">*</span></label>
            <div class="col-md-8">
                <input class="form-control" name="pool_id" value="<%=item.pool_id%>" placeholder="养殖池数字ID">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">光照 <span class="required">*</span></label>
            <div class="col-md-8">
                <input class="form-control" name="light" value="<%=item.light%>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">水温 <span class="required">*</span></label>
            <div class="col-md-8">
                <input class="form-control" name="temperature" value="<%=item.temperature%>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">盐度 <span class="required">*</span></label>
            <div class="col-md-8">
                <input class="form-control" name="salt" value="<%=item.salt%>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">氨氮 <span class="required">*</span></label>
            <div class="col-md-8">
                <input class="form-control" name="an" value="<%=item.an%>">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3">PH <span class="required">*</span></label>
            <div class="col-md-8">
                <input class="form-control" name="ph" value="<%=item.ph%>">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3">溶解氧 <span class="required">*</span></label>
            <div class="col-md-8">
                <input class="form-control" name="oxy" value="<%=item.oxy%>">
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3">亚硝基氮 <span class="required">*</span></label>
            <div class="col-md-8">
                <input class="form-control" name="nn" value="<%=item.nn%>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">采集时间 <span class="required">*</span></label>
            <div class="col-md-8">
                <input class="form-control" name="time_created" value="<%=item.time_created%>" placeholder="格式为：2000-01-01 00:00:00">
            </div>
        </div>

    </form>
</script>
<?=$this->region('common/scripts')?>
<script>
    $(function () {
        $('.datetimepicker').datetimepicker({
            autoclose: true,
            language: 'zh-CN'
        });
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
                    url: '/farming/ajax/production-env/delete',
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
                url: '/farming/ajax/production-env/' + (id ? 'update' : 'create'),
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