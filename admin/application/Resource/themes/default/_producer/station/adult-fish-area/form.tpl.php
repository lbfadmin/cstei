<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html>
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>项目管理 - <?=$_TPL['site_name']?></title>
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
                    <h1 class="page-title"> 示范区县海水鱼成鱼养殖面积统计
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
                                <i class="fa fa-cubes"></i>
                                <a href="javascript:">示范区县海水鱼成鱼养殖面积统计</a>
                            </li>
                        </ul>
                    </div>

                    <?=render_message() ?>

                    <!-- END PAGE HEADER-->
                    <div class="portlet light">
                        <div class="portlet-title">
		
<div class="fade1" id="modal-form">
    <div class="modal-dialog">
        <div class="modal-content">
<!--
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">编辑成鱼养殖面积统计</h4>
            </div>
-->
            <div class="modal-body">
                <form class="form form-horizontal" method="post">
                    <div class="form-group">
                        <label class="control-label col-md-3">示范县 <span class="required">*</span></label>
                        <div class="col-md-8"><?=$item->name?>
						<input type='hidden' name='unit_id' value='<?=$item->id?>' /></div>
                    </div>
					<div class="form-group">
						<label class="control-label col-md-3">季度 <span class="required">*</span></label>
						<div class="col-md-8">
							<!--<input class="form-control" readonly=true name="quarter" placeholder="" value="<%=item.quarter%>" />-->
						<select name="quarter" >
							<option value="">--请选择时间--</option>
							<?php foreach($quarter as $k=>$v):?>
								<option value="<?=$k?>" 
									><?=$v?></option>
							<?php endforeach?>
						</select>
						
						</div>
					</div>
                    <div class="form-group">
                        <label class="control-label col-md-3">养殖方式 <span class="required">*</span></label>
                        <div class="col-md-8">
                            <select class="form-control" name="way_id">
							<option value=''>请选择养殖方式</option>
							<option value='1'>工厂化</option>
							<option value='2'>网箱</option>
							<option value='3'>池塘</option>
							</select>
                        </div>
                    </div>

				 <?php if (!empty($item->saltwater_fish)):?>
					<?php foreach (json_decode($item->saltwater_fish) as $item):?>
						 <div class="form-group">
								<label class="control-label col-md-3"><?=$item ?> <span class="required">*</span></label>
								<div class="col-md-8">
									<input class="form-control" name="<?=$item ?>" value="0">
								</div>
							</div>		
					<?php endforeach ?>
				 <?php endif ?>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
	<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> 提交</button>
</div>  
                </form>
            </div>



        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>	

                        </div>
                    
                    </div>
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->

		
        <?=$this->region('common/footer')?>
        <?=$this->region('common/scripts')?>
		
		
<script>
    $(function () {
        var $modalForm = $('#modal-form');

        // 修改类目

        $('[data-role=edit-item]').on('click', function () {
            var $this = $(this),
                $tr = $this.parents('tr'),
                item = JSON.parse($tr.attr('data-item'));
/*            $modalForm.find('[name=id]').val(item.id);
            $modalForm.find('[name=production_unit_id]').val(item.production_unit_id);
            $modalForm.find('[name=name]').val(item.name);
            $modalForm.find('[name=weight]').val(item.weight);
            $modalForm.find('[name=parent_id]').val(item.parent_id).attr('disabled', true);*/
            $modalForm.modal();
            $modalForm.data('action', 'update');
        });
        // 添加类目
        $('[data-role=add-item]').on('click', function () {
			//
			
            var $this = $(this),
                $tr = $this.parents('tr');
            var item = $tr.length ? JSON.parse($tr.attr('data-item')) : {};
/*
            $modalForm.find('[name=parent_id]').val(item.id).attr('disabled', false);
            $modalForm.find('[name=id]').val('');
            $modalForm.find('[name=production_unit_id]').val('');
            $modalForm.find('[name=name]').val('');
            $modalForm.find('[name=weight]').val(0);
*/
            $modalForm.modal();
            $modalForm.data('action', 'add');
        });
  /**/


    });
</script>
    </body>

</html>