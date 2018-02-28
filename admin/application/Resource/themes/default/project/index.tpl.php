
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html>
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title>孵化器管理 - <?=$_TPL['site_name']?></title>
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
            <h1 class="page-title"> 孵化器管理
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
                        <i class="fa fa-industry"></i>
                        <a href="javascript:">园区管理</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:">工程维修</a>
                    </li>
                </ul>
            </div>

            <?=render_message() ?>

            <!-- END PAGE HEADER-->
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject font-dark bold">维修列表</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <form class="form-inline area-selector" style="margin-bottom: 15px">

                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">公司名称</span>
                                <select name="company_id" class="form-control provinces  ">
                                    <option value="" selected>--请选择公司--</option>
                                    <?php foreach($company as $k=>$v):?>
                                        <option  value="<?=$k?>"><?=$v?></option>
                                    <?php endforeach?>
                                </select>
                            </div>

                        </div>
                        <button class="btn btn-primary">查询</button>
                        <button type="reset" onclick="window.location.href=window.location.pathname" class="btn btn-default">重置</button>
                        <span class="pull-right btn">共 <?=$result->total?> 条结果</span>
                    </form>
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th class="col-md-1">公司名称</th>
                            <th class="col-md-2">事项</th>
                            <th class="col-md-1">时间</th>
                            <th class="col-md-1">图片</th>
                            <th class="col-md-1">联系人</th>
                            <th class="col-md-1">联系电话</th>
                            <th class="col-md-1">状态</th>
                            <th class="col-md-2">备注</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($result->list)):?>
                            <?php foreach ($result->list as $item):
                                ?>
                                <tr  data-item='<?=json_encode(['id' => $item->id])?>'>
                                    <td><?=$item->id ?></td>
                                    <td><?=$item->company_name?></td>
                                    <td><?=$item->matter?>
                                    </td>
                                    <td><?=$item->time_created ?></td>
                                    <td><p style="max-width: 300px;"><img src="<?=$item->pic?>"  /></td>
                                    <td><?=$item->linkman ?></td>
                                    <td><?=$item->tel ?></td>
                                    <td><?=$item->status ?></td>
                                    <td><?=$item->desc ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <?php if(empty($item->desc)&&$item->status==0):?>
                                                <a href="#" data-toggle="tooltip" title="" data-role="add-desc" class="btn btn-default btn-xs" ><i class="fa fa-edit"></i> 添加备注</a>
                                            <?php endif ?>
                                            <?php if($item->status==0):?>
                                                <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-default btn-xs" data-role="yes" data-id="<?=$item->id?>"><i class="fa fa-edit"></i> 通过</a>
                                                <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-default btn-xs" data-role="no" data-id="<?=$item->id?>"><i class="fa fa-edit"></i> 拒绝</a>

                                            <?php elseif($item->status==1):?>
                                                <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-default btn-xs"  data-id="<?=$item->id?>"><i class="fa fa-edit"></i> 已通过</a>

                                            <?php elseif($item->status==2):?>
                                                <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-default btn-xs"  data-id="<?=$item->id?>"><i class="fa fa-edit"></i> 已拒绝</a>

                                            <?php elseif($item->status==3):?>
                                                <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-default btn-xs"  data-id="<?=$item->id?>"><i class="fa fa-edit"></i> 修理中</a>
                                            <?php elseif($item->status==4):?>
                                                <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-default btn-xs" data-role="finish" data-id="<?=$item->id?>"><i class="fa fa-edit"></i> 完成</a>
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
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
</div>

!-- END CONTAINER -->
<div class="modal fade" id="modal-form">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">添加备注</h4>
            </div>
            <div class="modal-body">
                <form class="form form-horizontal" method="post">
                    <input type="hidden" name="id">
                    <div class="form-group">
                        <label class="control-label col-md-3">备注 <span class="required">*</span></label>
                        <div class="col-md-8">
                            <input class="form-control" name="desc">
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


<!-- END CONTAINER -->
<?=$this->region('common/footer')?>
<?=$this->region('common/scripts')?>

<script>
    $(function () {
        var $modalForm = $('#modal-form');
        // 添加类目
        $('[data-role=add-desc]').on('click', function () {
            var $this = $(this),
                $tr = $this.parents('tr'),
                project = JSON.parse($tr.attr('data-item'));
            $modalForm.find('[name=id]').val(project.id);
            $modalForm.find('[name=desc]').val('');
            $modalForm.modal();
            $modalForm.data('action', 'update');
        });
        $modalForm.find('.ok').on('click', function () {
            var action = $modalForm.data('action');
            if (action === 'update') {
                var id=$modalForm.find('[name=id]').val();
                var desc=$modalForm.find('[name=desc]').val();
                $.ajax({
                    url: '/project/ajax/project/update',
                    type: 'post',
                    data: {id:id,desc:desc},
                    success: function (result) {
                        $modalForm.modal('hide');
                        layer.msg(result.message, function () {
                            window.location.reload();
                        });
                    }
                });
            }
        });
        //通过
        $('[data-role=yes]').on('click', function () {
            var $this = $(this),
                id = $this.attr('data-id'),
                status=1;
            layer.confirm('您确定要通过这个维修记录吗？', function () {
                $.ajax({
                    url: '/project/ajax/project/updatestatus',
                    type: 'post',
                    data: {id: id,status:status},
                    success: function (result) {
                        layer.msg(result.message, function () {
                            window.location.reload();
                        });
                    }
                });
            });
        });
        //拒绝
        $('[data-role=no]').on('click', function () {
            var $this = $(this),
                id = $this.attr('data-id'),
                status=2;
            layer.confirm('您确定要拒绝这个维修记录吗？', function () {
                $.ajax({
                    url: '/project/ajax/project/updatestatus',
                    type: 'post',
                    data: {id: id,status:status},
                    success: function (result) {
                        layer.msg(result.message, function () {
                            window.location.reload();
                        });
                    }
                });
            });
        });
        //完成
        $('[data-role=finish]').on('click', function () {
            var $this = $(this),
                id = $this.attr('data-id'),
                status=5;
            layer.confirm('您确定要完成这个维修记录吗？', function () {
                $.ajax({
                    url: '/project/ajax/project/updatestatus',
                    type: 'post',
                    data: {id: id,status:status},
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