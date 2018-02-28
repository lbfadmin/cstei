<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html>
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title>示范区县海水鱼成鱼养殖产量统计  - <?=$_TPL['site_name']?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <?=$this->region('common/styles')?>
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="/misc/src/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/misc/src/global/plugins/jquery-raty/jquery.raty.css">
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
            <h1 class="page-title"> 示范区县海水鱼成鱼养殖产量统计 
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
                        <a href="javascript:">养殖数据</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <i class="fa fa-book"></i>
                        <a href="/producer/company/credit/index">示范区县海水鱼成鱼养殖产量统计 </a>
                    </li>
                </ul>
            </div>
            <?=render_message() ?>
            <!-- END PAGE HEADER-->
            <div class="portlet light">
<!-- END CONTAINER -->
<div class="modal1 fade1" id="modal-form">
    <div class="modal-dialog">
        <div class="modal-content">
<!--            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">编辑类目</h4>
            </div>-->
            <div class="modal-body">
                <form class="form form-horizontal" method="post">
                    <div class="form-group">
                        <label class="control-label col-md-3">示范区县 <span class="required">*</span></label>
                        <div class="col-md-8">
                            <?=$unit_name?>
							<input type="hidden" type='unit_id' value="<?=$unit_id?>" />
                        </div>
                    </div>
					<div class="form-group">
						<label class="control-label col-md-3">季度 <span class="required">*</span></label>
						<div class="col-md-8">
							<!--<input class="form-control" readonly=true name="quarter" placeholder="" value="<%=item.quarter%>" />-->
						<select name="quarter" >
							<option value=''>--请选择季度--</option>
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

<table>
	<tr>
		<th width='120'>鱼类</th>
		<th width='180'>本季末存量</th>
		<th width='180'>待养成鱼 万尾</th>
		<th width='180'>待养成鱼 总重（吨）</th>
		<th width='180'>商品鱼 万尾</th>
		<th width='180'>商品鱼 总重（吨）</th>
	</tr>
	 <?php if (!empty($cats)):?>
		<?php foreach ($cats as $item):?>

			<tr>
				<th><?=$item ?></th>
				<th><input class="form-control" name="str[<?=$item ?>]" value="0"></th>
				<th><input class="form-control" name="pre_a[<?=$item ?>]" value="0"></th>
				<th><input class="form-control" name="pre_w[<?=$item ?>]" value="0"></th>
				<th><input class="form-control" name="sal_a[<?=$item ?>]" value="0"></th>
				<th><input class="form-control" name="sal_w[<?=$item ?>]" value="0"></th>
			</tr>
		<?php endforeach ?>
	 <?php endif ?>
</table>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
	<button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> 提交</button>
</div>  
                </form>
            </div>


<!--            
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
	<button type="button" class="btn btn-primary ok">保存</button>
</div>
-->
       

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
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
</body>

</html>