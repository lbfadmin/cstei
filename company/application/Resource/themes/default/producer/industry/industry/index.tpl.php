<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html>
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>产业动态管理 - <?=$_TPL['site_name']?></title>
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
                    <h1 class="page-title"> 产业动态管理
                        <small></small>
                    </h1>

                    <?=render_message() ?>

                    <!-- END PAGE HEADER-->
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-dark bold">产业动态</span>
                            </div>
                            <div class="actions">
                                <a href="javascript:" class="btn btn-primary btn-circle" data-role="add"><i class="fa fa-plus"> 添加产业动态记录</i></a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
									<th>鱼类</th>

                                    <th>产量（吨）</th>
                                    <th>时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($result->list)):?>
                                    <?php foreach ($result->list as $item):
                                        ?>
                                        <tr data-item='<?=html_attr_json($item)?>'>
                                            <td><?=$item->id ?></td>
                                            <td><?=$item->pool_name?> </td>

                                            <td><?=$item->production?></td>
                                            <td><?=$item->time_created?></td>
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
                                        <td colspan="20" class="table-no-results">没有相关结果。</td>
                                    </tr>
                                <?php endif ?>
                                </tbody>
                            </table>
                            <?=$pager?>
                        </div>
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
                    <h4 class="modal-title">编辑产业动态</h4>
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
                <label class="control-label col-md-3">鱼类 <span class="required">*</span></label>
                <div class="col-md-8">
					<select name="pool_id" class="form-control">
						<?php if (!empty($categories)):?>
						<?php foreach ($categories as $category):?>
						<option value="<?=$category->id?>" <?php if ($category->id==$item->category_id):?>selected<?php endif ?>><?=$category->name?></option>
						<?php endforeach;?>
						<?php endif ?>
					</select>
				</div>
	
			</div>

            <div class="form-group">
                <label class="control-label col-md-3">产量（吨） <span class="required">*</span></label>
                <div class="col-md-8">
                    <input class="form-control" name="production" value="<%=item.retail_price%>">
                </div>
            </div>
  
           
            <div class="form-group">
                <label class="control-label col-md-3">采集时间 <span class="required">*</span></label>
                <div class="col-md-8">
					<input class="form-control datetimepicker" name="time_created" placeholder="请选择" value="<?=date('Y-m', strtotime('-1 day'))?>">
                </div>
				
            </div>

        </form>
    </script>
	<link href="/misc/src/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
    <?=$this->region('common/scripts')?>
    <script>
        $(function () {
		   $('.datetimepicker').datetimepicker({
				language: 'zh-CN',
				format: 'yyyy-mm',
				weekStart: 1,
				todayBtn: 1,
				autoclose: 1,
				todayHighlight: 1,
				startView: 3, //这里就设置了默认视图为年视图
				minView: 3, //设置最小视图为年视图
				forceParse: 0,
				autoclose: true
				
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
                        url: '/producer/ajax/industry/industry/delete',
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
                    url: '/producer/ajax/industry/industry/' + (id ? 'update' : 'create'),
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