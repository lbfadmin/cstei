<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html>
<!--<![endif]-->
<!-- BEGIN HEAD -->
<?php
$statuses = [
    'QUALIFIED' => '合格',
    'UNQUALIFIED' => '不合格'
];
?>
<head>
    <meta charset="utf-8" />
    <title>生物多样性数据管理 - <?=$_TPL['site_name']?></title>
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
            <h1 class="page-title"> 生物多样性数据管理
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
                        <a href="javascript:">政府端</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="javascript:">生物多样性数据管理</a>
                    </li>
                </ul>
            </div>

            <?=render_message() ?>

            <!-- END PAGE HEADER-->
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject font-dark bold">生物多样性数据列表</span>
                    </div>
                    <div class="actions">
                        <a class="btn btn-circle btn-primary" href="javascript:" data-role="add">
                            <i class="fa fa-plus"> 添加数据</i>
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>采集设备ID</th>
                            <th>浮游植物</th>
                            <th>浮游动物</th>
                            <th>附着生物</th>
                            <th>底栖生物</th>
                            <th>游泳动物</th>
                            <th>采集时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($result->list)):?>
                            <?php foreach ($result->list as $item):
                                ?>
                                <tr data-item='<?=html_attr_json($item)?>'>
                                    <td><?=$item->id?></td>
                                    <td><?=$item->device_id ?></td>
                                    <td><?=$item->fu_you_zhi_wu ?></td>
                                    <td><?=$item->fu_you_dong_wu ?></td>
                                    <td><?=$item->fu_zhuo_sheng_wu ?></td>
                                    <td><?=$item->di_qi_sheng_wu ?></td>
                                    <td><?=$item->you_yong_dong_wu ?></td>
                                    <td><?=$item->time ?></td>
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
                            <tr style="text-align: center">
                                <td colspan="13" class="table-no-results">没有相关结果。</td>
                            </tr>
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
                <h4 class="modal-title">编辑生物多样性数据</h4>
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
            <label class="control-label col-md-3">采集设备ID <span class="required">*</span></label>
            <div class="col-md-8">
                <input class="form-control" name="device_id" value="<%=item.device_id%>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">浮游植物 <span class="required">*</span></label>
            <div class="col-md-8">
                <input class="form-control" name="fu_you_zhi_wu" value="<%=item.fu_you_zhi_wu%>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">浮游动物 <span class="required">*</span></label>
            <div class="col-md-8">
                <input class="form-control" name="fu_you_dong_wu" value="<%=item.fu_you_dong_wu%>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">附着生物 <span class="required">*</span></label>
            <div class="col-md-8">
                <input class="form-control" name="fu_zhuo_sheng_wu" value="<%=item.fu_zhuo_sheng_wu%>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">底栖生物 <span class="required">*</span></label>
            <div class="col-md-8">
                <input class="form-control" name="di_qi_sheng_wu" value="<%=item.di_qi_sheng_wu%>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">游泳动物 <span class="required">*</span></label>
            <div class="col-md-8">
                <input class="form-control" name="you_yong_dong_wu" value="<%=item.you_yong_dong_wu%>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">采集时间 <span class="required">*</span></label>
            <div class="col-md-8">
                <input class="form-control" name="time" value="<%=item.time%>" placeholder="如：2016-10-01 10:00:00">
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
            $modal.find('.modal-body').html(tpl('tpl-form').render({item: {}}));
            $modal.modal();
        });
        $('[data-role=delete]').on('click', function () {
            var $this = $(this),
                id = $this.attr('data-id');
            layer.confirm('您确定要删除这条信息吗？', function () {
                $.ajax({
                    url: '/supervisor/ajax/biodiversity/delete',
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
                url: '/supervisor/ajax/biodiversity/' + (id ? 'update' : 'create'),
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