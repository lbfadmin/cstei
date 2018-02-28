<?php
$status_classes = [
    'RUNNING' => '',
    'MAINTAIN' => 'info',
    'STOPPED' => 'warning',
    'DOWN' => 'danger'
];
$status_names = [
    'RUNNING' => '运行中', // 运行中
    'MAINTAIN' => '检查维修', // 检查维修
    'STOPPED' => '停止', // 停止
    'DOWN' => '故障', // 故障
];
$container_type_names = [
    'POOL' => '养殖池', // 养殖池
    'DEVICE_GROUP' => '设备组' // 设备组
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
        <title>设备管理 - <?=$_TPL['site_name']?></title>
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
                                        <h1>设备管理
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
                                                                <span class="caption-subject font-green-steel uppercase bold">设备列表</span>
                                                            </div>
                                                            <div class="actions">
                                                                <a href="javascript:" class="btn btn-primary btn-circle" data-role="add"><i class="fa fa-plus"> 添加设备</i></a>
                                                            </div>
                                                        </div>
                                                        <div class="portlet-body">
                                                            <form class="form-inline" style="margin-bottom: 15px">
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">状态</span>
                                                                    <select class="form-control" name="status">
                                                                        <option value="">全部</option>
                                                                        <?php foreach ($status_names as $k => $v):?>
                                                                            <option value="<?=$k?>" <?php if ($_GET['status']==$k):?>selected<?php endif ?>><?=$v?></option>
                                                                        <?php endforeach;?>
                                                                    </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">容器类型</span>
                                                                        <select class="form-control" name="container_type">
                                                                            <option value="">全部</option>
                                                                            <?php foreach ($container_type_names as $k => $v):?>
                                                                                <option value="<?=$k?>" <?php if ($_GET['container_type']==$k):?>selected<?php endif ?>><?=$v?></option>
                                                                            <?php endforeach;?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">容器ID</span>
                                                                        <input class="form-control" name="container_id" placeholder="上级容器ID" style="width: 100px" value="<?=$this->input->getString('container_id')?>">
                                                                    </div>

                                                                </div>
                                                                <button class="btn btn-primary">查询</button>
                                                                <button type="reset" onclick="window.location.href=window.location.pathname" class="btn btn-default">重置</button>
                                                                <span class="pull-right btn">共 <?=$result->total?> 条结果</span>
                                                            </form>
                                                           <div class="table-responsive">
                                                               <table class="table table-bordered table-hover">
                                                                   <thead>
                                                                   <tr>
                                                                       <th>ID</th>
                                                                       <th>设备编号</th>
                                                                       <th>类型</th>
                                                                       <th>容器类型</th>
                                                                       <th>容器ID</th>
                                                                       <th>采购时间</th>
                                                                       <th>状态</th>
                                                                       <th>更新时间</th>
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
                                                                               <td><?=$types->{$item->type_id}->name?></td>
                                                                               <td><?=$container_type_names[$item->container_type]?></td>
                                                                               <td><?=$item->container_id?></td>
                                                                               <td><?=$item->time_purchased?>
                                                                               <td class="<?=$status_classes[$item->status]?>"><?=$status_names[$item->status]?></td>
                                                                               <td><?=$item->time_updated?></td>
                                                                               <td>
                                                                                   <div class="btn-group">
                                                                                       <?php if ($item->status != 'RUNNING') :?>
                                                                                           <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-success btn-xs" data-role="power-on" data-id="<?=$item->id?>"><i class="fa fa-power-off"></i> 开机</a>
                                                                                       <?php else :?>
                                                                                           <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-danger btn-xs" data-role="power-off" data-id="<?=$item->id?>"><i class="fa fa-power-off"></i> 关机</a>
                                                                                       <?php endif ?>
                                                                                   </div>
                                                                                   <div class="btn-group">
                                                                                       <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-default btn-xs" data-role="edit"><i class="fa fa-edit"></i> 编辑</a>
                                                                                       <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-default btn-xs" data-role="delete" data-id="<?=$item->id?>"><i class="fa fa-times"></i> 删除</a>
                                                                                       <a href="/company/device-maintenance/index?device_sn=<?=$item->sn?>" data-toggle="tooltip" title="" class="btn btn-default btn-xs" data-role="add-maintenance"><i class="fa fa-edit"></i> 维护记录</a>
                                                                                       <a href="/company/device-power/index?device_sn=<?=$item->sn?>" data-toggle="tooltip" title="" class="btn btn-default btn-xs" data-role="add-power"><i class="fa fa-edit"></i> 开关机记录</a>
                                                                                   </div>
                                                                               </td>
                                                                           </tr>
                                                                       <?php endforeach ?>
                                                                   <?php else:?>
                                                                       <tr>
                                                                           <td colspan="100" class="table-no-results">没有相关结果。</td>
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
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">编辑设备</h4>
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
                    <label class="control-label col-md-3">编号 <span class="required">*</span></label>
                    <div class="col-md-8">
                        <input class="form-control" name="sn" value="<%=item.sn%>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">设备类型 <span class="required">*</span></label>
                    <div class="col-md-8">
                        <select class="form-control" name="type_id">
                            <?php foreach ($types as $k => $value):?>
                                <option value="<?=$k?>" <% if (item.type_id==<?=$k?>) { %>selected<% } %>><?=$value->name?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">容器类型 <span class="required">*</span></label>
                    <div class="col-md-8">
                        <select class="form-control" name="container_type">
                            <?php foreach ($container_type_names as $k => $value):?>
                                <option value="<?=$k?>" <% if (item.container_type=='<?=$k?>') { %>selected<% } %>><?=$value?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">容器ID <span class="required">*</span></label>
                    <div class="col-md-8">
                        <input class="form-control" name="container_id" value="<%=item.container_id%>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">采购时间 <span class="required">*</span></label>
                    <div class="col-md-8">
                        <input class="form-control datetimepicker" name="time_purchased" placeholder="日期时间，如:2010-01-01 00:00:00" value="<%=item.time_purchased%>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">状态 <span class="required">*</span></label>
                    <div class="col-md-8">
                        <select class="form-control" name="status">
                            <?php foreach ($status_names as $k => $status):?>
                                <option value="<?=$k?>" <% if (item.status=='<?=$k?>') { %>selected<% } %>><?=$status?></option>
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
                    $modal.find('.datetimepicker').datetimepicker({
                        language: 'zh-CN',
                        autoclose: true
                    });
                    $modal.modal();
                });
                $('[data-role=edit]').on('click', function () {
                    var item = JSON.parse($(this).parents('tr').attr('data-item'));
                    $modal.find('.modal-body').html(tpl('tpl-form').render({item: item}));
                    $modal.find('.datetimepicker').datetimepicker({
                        language: 'zh-CN',
                        autoclose: true
                    });
                    $modal.modal();
                });
                $modal.find('.ok').on('click', function () {
                    var id = $modal.find('[name=id]').val();
                    $.ajax({
                        url: '/farming/ajax/device/' + (id ? 'update' : 'create'),
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
                            url: '/farming/ajax/device/delete?id=' + id,
                            success: function (result) {
                                layer.msg(result.message, function () {
                                    window.location.reload();
                                });
                            }
                        });
                    });
                });
                $('[data-role=power-on]').on('click', function () {
                    var id = $(this).attr('data-id');
                    layer.confirm('您确定执行操作吗？', function () {
                        $.ajax({
                            url: '/farming/ajax/device/power-on?id=' + id,
                            success: function (result) {
                                layer.msg(result.message, function () {
                                    window.location.reload();
                                });
                            }
                        });
                    });
                });
                $('[data-role=power-off]').on('click', function () {
                    var id = $(this).attr('data-id');
                    layer.confirm('您确定执行操作吗？', function () {
                        $.ajax({
                            url: '/farming/ajax/device/power-off?id=' + id,
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