<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html>
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>饲养海水鱼管理 - <?=$_TPL['site_name']?></title>
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
                    <h1 class="page-title"> 饲养海水鱼管理
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
                                <a href="javascript:">试验站</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="javascript:">饲养海水鱼管理</a>
                            </li>
                        </ul>
                    </div>

                    <?=render_message() ?>

                    <!-- END PAGE HEADER-->
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-dark bold">选择养殖的海水鱼类</span>
                            </div>
                 <!--           <div class="actions">
                                <a href="javascript:" class="btn btn-primary btn-circle" data-role="add"><i class="fa fa-plus"> 添加仓储环境记录</i></a>
                            </div>-->
                        </div>

    <script type="text/html" id="tpl-form">
        <form class="form form-horizontal" method="post">       
		
		</form>
    </script>
        <form class="form form-horizontal" method="post">     
                        <div class="portlet-body">
                            <table class="table table-bordered table-hover">
     
                                <tbody>
                                <?php if (!empty($result)):?>
                                    <?php foreach ($result as $item):
                                        ?>
										
										
													
                                        <tr data-item='<?=html_attr_json($item)?>'>
                                        </tr>
												<?php if (!empty($item->list)):?>
													<td><?=$item->name ?>  :
														<?php foreach ($item->list as $it):?>
																<?=$it->name ?><input type="checkbox" id="kee" name="saltwater_fish[]" value="<?=$it->name ?>"
																<?php if (in_array($it->name, $cats)):?> checked=checked <?php endif ?>
																/>
														<?php endforeach ?>
													</td>
												<?php else:?>
													<td><?=$item->name ?><input type="checkbox" id="kee" name="saltwater_fish[]" value="<?=$item->name ?>" 
													<?php if (in_array($item->name, $cats)):?> checked=checked <?php endif ?>
													></td>
												<?php endif ?>
                                    <?php endforeach ?>
                                <?php else:?>
                                    <tr>
                                        <td colspan="20" class="table-no-results">没有相关结果。</td>
                                    </tr>
                                <?php endif ?>
                                </tbody>
                            </table>
                            
							<div class="modal-footer">
								<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> 提交</button>
							</div>
                        </div>

 
					</form>
                    </div>
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->
        <?=$this->region('common/footer')?>
    <div class="modal fade" id="modal-form">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">编辑仓储环境</h4>
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
            <input type="hidden" name="warehouse_id" value="<?=$_GET['warehouse_id']?>">
            <div class="form-group">
                <label class="control-label col-md-3">仓库ID <span class="required">*</span></label>
                <div class="col-md-8">
                    <input class="form-control" name="warehouse_id" value="<%=item.id%>" placeholder="仓库ID">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">温度 <span class="required">*</span></label>
                <div class="col-md-8">
                    <input class="form-control" name="temperature" value="<%=item.temperature%>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">湿度 <span class="required">*</span></label>
                <div class="col-md-8">
                    <input class="form-control" name="humidity" value="<%=item.humidity%>">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3">含氧量 <span class="required">*</span></label>
                <div class="col-md-8">
                    <input class="form-control" name="oxy" value="<%=item.oxy%>">
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
                        url: '/producer/ajax/storage/warehouse-env/delete',
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
                    url: '/producer/ajax/storage/warehouse-env/' + (id ? 'update' : 'create'),
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