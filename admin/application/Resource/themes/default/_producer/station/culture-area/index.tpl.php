<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html>
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>季度示范区县海水养殖面积统计    - <?=$_TPL['site_name']?></title>
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
                    <h1 class="page-title"> 季度示范区县海水养殖面积统计                        
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
                                <a href="javascript:">示范县区</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="javascript:">季度示范区县海水养殖面积统计                      </a>
                            </li>
                        </ul>
                    </div>

                    <?=render_message() ?>

                    <!-- END PAGE HEADER-->
                    <div class="portlet light">
                        <div class="portlet-title">
						<?php if (!empty($unit_name)):?>
                            <div class="caption">
                                <span class="caption-subject font-dark bold"><?=$unit_name?></span>
                            </div>
						<?php endif?>
                            <div class="caption">
                                <span class="caption-subject font-dark bold">
								<form class="form-inline area-selector" style="margin-bottom: 15px">
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon">季度</span>
											<select id='quarter' name='quarter'>
												<option value=''>--请选择季度--</option>
												<?php if (!empty($quarter)):?>
												<?php foreach ($quarter as $k=>$v):?>
													<option value='<?=$k?>'
													<?php if ($search['quarter']==$k):?>
													selected=selected
													<?php endif ?>
													><?=$v?></option>
												<?php endforeach ?>
												<?php endif ?>
											</select>
										</div>

									</div>
									<?php if (!empty($pcom)):?>
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon">试验站</span>
											<select id='parent_id' name='parent_id'>
												<option value=''>--请选择试验站--</option>
												
												<?php foreach ($pcom as $v):?>
													<option value='<?=$v->id?>'
													<?php if ($search['parent_id']==$v->id):?>
													selected=selected
													<?php endif ?>
													
													><?=$v->name?></option>
												<?php endforeach ?>
												
											</select>
										</div>

									</div>						
									<?php endif ?>
									<div class="form-group">
										<div class="input-group">
											<span class="input-group-addon">示范县区</span>
											<select id='unit_id' name='unit_id'>
												<option value=''>--请选择示范县区--</option>
												<?php if (!empty($com)):?>
												<?php foreach ($com as $v):?>
													<option value='<?=$v->id?>'
													<?php if ($search['unit_id']==$v->id):?>
													selected=selected
													<?php endif ?>
													
													><?=$v->name?></option>
												<?php endforeach ?>
												<?php endif ?>
											</select>
										</div>

									</div>
									<button class="btn btn-primary">查询</button>
									<button type="reset" onclick="window.location.href=window.location.pathname" class="btn btn-default">重置</button>
									<span class="pull-right btn">共 <?=$result->total?> 条结果</span>
								</form>
								</span>
                            </div>
                            <?php if($editable):?><th><div class="actions">
                                <a href="javascript:" class="btn btn-primary btn-circle" data-role="add"><i class="fa fa-plus"> 添加季度示范区县海水养殖面积统计</i></a>
                            </div>
							<?php endif?>
                        </div>
                        <div class="portlet-body">
                        <style>.table th,td{text-align: center;}
                        </style>
                            <table class="table table-bordered table-hover">
                                <thead>

								<tr>
                                    <th rowspan="2" style='text-align:center'>示范区县</th>
                                    <th rowspan="2" style='text-align:center'>季度</th>
                                    <th rowspan="2" style='text-align:center'>池塘养殖(亩)</th>
                                    <th rowspan="2" style='text-align:center'>网箱养殖（平方米/立方米）</th>
                                    <th colspan="2" style='text-align:center'>工厂化养殖（平方米/立方米）</th>
                                    <?php if($editable):?><th rowspan="2">操作</th><?php endif?>
                                </tr>				
                                <tr>
                                    <th style='text-align:center'>流水养殖</th>
                                    <th style='text-align:center'>循环水养殖</th>
                                </tr>
                                </thead>
								<tbody style='text-align:center;'>
									<?php if (!empty($result)):?>
										<?php foreach ($result->list as $it):
											?>
											
											<tr data-item='<?=html_attr_json($it)?>' >
												<th><?=$it->unit_name ?></th>  
												<th><?=$it->quarter_name ?></th>                        
												<th><?=$it->池塘养殖?></th>                     
												<th><?=$it->网箱养殖?></th>                     
												<th><?=$it->流水养殖?></th>                  
												<th><?=$it->循环水养殖?></th>
												<?php if($editable):?><th>
												<div class="btn-group">
													<a href="javascript:" data-toggle="tooltip" title="" class="btn btn-default btn-xs" data-role="edit">
														<i class="fa fa-edit"></i> 编辑
													</a>
													<a href="javascript:" data-toggle="tooltip" title="" class="btn btn-default btn-xs" data-role="delete" data-id="<?=$it->id?>"><i class="fa fa-times"></i> 删除</a>
												</div>
												</th>
												<?php endif ?>
											</tr>
								
										<?php endforeach ?>
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
                    <h4 class="modal-title">编辑海水养殖面积统计</h4>
                </div>
                <div class="modal-body">

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <script type="text/html" id="tpl-form">

        <form class="form form-horizontal" method="post">
            <input type="hidden" class="form-control"  name="id"  value="<%=item.id%>" />
			
			
					
            <div class="form-group">
                <label class="control-label col-md-3">示范县 <span class="required">*</span></label>
                <div class="col-md-8">
				
					<!--<input class="form-control" readonly=true name="unit_name" placeholder="" value="<%=item.unit_name%>" />-->
				<select name="unit_id">
					<option value="">--请选择示范县--</option>
						<?php if (!empty($com)):?>
						<?php foreach ($com as $v):?>
							<option value="<?=$v->id?>" 
								><?=$v->name?></option>
						<?php endforeach ?>
						<?php endif ?>
					
					</select>
				</div>
            </div>
  
            <div class="form-group">
                <label class="control-label col-md-3">季度 <span class="required">*</span></label>
                <div class="col-md-8">
					<!--<input class="form-control" readonly=true name="quarter" placeholder="" value="<%=item.quarter%>" />-->
				<select name="quarter" >
					<option value="">--请选择季度--</option>
					<?php foreach($quarter as $k=>$v):?>
						<option value="<?=$k?>" 
							><?=$v?></option>
					<?php endforeach?>
				</select>
				
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">池塘养殖</label>
                <div class="col-md-8">
                    <input class="form-control" name="池塘养殖" placeholder="亩" value="<%=item.池塘养殖%>">亩
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">网箱养殖</label>
                <div class="col-md-8">
                    <input class="form-control" name="网箱养殖" placeholder="平方米/立方米" value="<%=item.网箱养殖%>">平方米/立方米
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">流水养殖</label>
                <div class="col-md-8">
                    <input class="form-control" name="流水养殖" placeholder="平方米/立方米" value="<%=item.流水养殖%>">平方米/立方米
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">循环水养殖</label>
                <div class="col-md-8">
                    <input class="form-control" name="循环水养殖" placeholder="平方米/立方米" value="<%=item.循环水养殖%>">平方米/立方米
                </div>
            </div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
	<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> 提交</button>
</div>  
        </form>
    </script>
    <?=$this->region('common/scripts')?>
    <script>
        $(function () {
			$('#parent_id').on('change', function () {
                var id = $(this).val();
				
				var data = {"parent_id":id};
				//alert(data);
				$.ajax({
                    url: '/producer/ajax/company/company/get-list/',
					data: data,
                    type: 'post',
                    success: function (result) {
						var html = '<option value=""> -- 请选择 -- </option>';
						$.each(result.data.list, function (k, v) {
							//var selected = self.selected.province_id == v.id ? 'selected' : '';
							html += '<option value="' + v.id + '" ' + '>' + v.name + '</option>';
						});
						$("#unit_id").html(html);
                    }
                });

            });
			
			
            var $modal = $('#modal-form');
            $('[data-role=add]').on('click', function () {
                $modal.find('.modal-body').html(tpl('tpl-form').render({item: {}}));
                $modal.modal();
            });
            $('[data-role=edit]').on('click', function () {

                var item = JSON.parse($(this).parents('tr').attr('data-item'));

                $modal.find('.modal-body').html(tpl('tpl-form').render({item: item}));
				$modal.find('[name=id]').val(item.id);
				$modal.find('[name=unit_id]').val(item.unit_id);
				$modal.find('[name=quarter]').val(item.quarter);
                $modal.modal();
            });


            $('[data-role=delete]').on('click', function () {
                var id = $(this).attr('data-id');
                layer.confirm('您确定删除这条信息吗？', function () {
                    $.ajax({
                        url: '/producer/ajax/breeding/breeding-area/delete?id=' + id,
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