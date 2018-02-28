<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html>
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title>海水鱼苗种生产情况 - <?=$_TPL['site_name']?></title>
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
            <h1 class="page-title"> 海水鱼苗种生产情况
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
                        <i class="fa fa-pencil-square-o"></i>
                        <a href="javascript:">统计数据</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
					
                    <li>
                        <i class="fa fa-list"></i>
                        <a href="javascript:">海水鱼苗种生产情况</a>
                    </li>
                </ul>
            </div>

            <?=render_message() ?>
            <div class="portlet light">
                <div class="portlet-title">
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
<!--<div class="form-group">
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
-->
									<button class="btn btn-primary">查询</button>
									<button type="reset" onclick="window.location.href=window.location.pathname" class="btn btn-default">重置</button>
									<span class="pull-right btn">共 <?=$result->total?> 条结果</span>
									<a href = "push?quarter=<?=$search['quarter']?>" target = "blank" ><input type="button" value="导出数据" class="btn btn-default"></a>
								</form>
								</span>
                            </div>
<!--                    
					<div class="actions">
                        <a class="btn btn-circle btn-primary" href="javascript:" data-role="add-item" data-item='<?=json_encode(['id' => 0])?>'>
                            <i class="fa fa-plus"> 添加海水鱼苗种生产情况</i>
                        </a>
                    </div>
-->
                </div>
                <div class="portlet-body">
                    <table class="table table-bordered table-hover">
                <thead>
                        <tr>
                            <!--<th width="10%">示范县</th>--> 
                            <th width="10%">季度</th>
                            <th width="10%">规格</th>
                               <?php if (!empty($cats)):?>
                                    <?php foreach ($cats as $item):
                                        ?>
										<th><?=$item ?></th>
							
                                    <?php endforeach ?>
                                <?php endif ?>
           
                            <!--<th width="10%">操作</th>-->
                        </tr>
                        </thead>
                        <tbody>
								<?php if (!empty($result)):?>
                                    <?php foreach ($result->list as $item):
                                        ?>
										
										<tr>
										<?php if ($item->type==1):?> 
											<!--<th rowspan=3><?=$item->unit_name ?></th>-->
											<th rowspan=3><?=$item->quarter_name ?></th>
										<?php endif ?>							
											<th><?=$type_arr[$item->type]?></th>
											<?php if(!empty($cats)):?> 
												<?php foreach ($cats as $it):?>
													<th><?=$item->$it ?></th>
												<?php endforeach ?>
											<?php endif ?>			
										<!--<?php if ($item->type==1):?> 
											<th rowspan=3><a>编辑</a>
											&nbsp;&nbsp;&nbsp;<a>删除</a></th>
										<?php endif ?>-->	
										</tr>
							
                                    <?php endforeach ?>
                                <?php endif ?>
						
                        <?php //printTree($industrys); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
</div>

<?=$this->region('common/footer')?>
<?=$this->region('common/scripts')?>
<script>
    $(function () {
        var $modalForm = $('#modal-form');
		//alert( $modalForm.data('action'));
		//return;
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
			var unitid = $("#unit_id").val();
			if(unitid==''){
				alert("请选择要添加的示范县！");
				return;
				
			}
			location.href = "/producer/saltwater-fish/fish-fry-production/add?unit_id="+unitid;

/*			
            var $this = $(this),
                $tr = $this.parents('tr');
            var item = $tr.length ? JSON.parse($tr.attr('data-item')) : {};

            $modalForm.find('[name=parent_id]').val(item.id).attr('disabled', false);
            $modalForm.find('[name=id]').val('');
            $modalForm.find('[name=production_unit_id]').val('');
            $modalForm.find('[name=name]').val('');
            $modalForm.find('[name=weight]').val(0);

            $modalForm.modal();
            $modalForm.data('action', 'add');
*/
        });
  /**/

        $modalForm.find('.ok').on('click', function () {
            var action = $modalForm.data('action');
			//alert(action);
			//return; 
			location.href='/producer/ajax/statistics/industry-weight/add?'+$modalForm.find('form').serialize();
			return;
            if (action == 'add') {
                $.ajax({
                    url: '/producer/ajax/statistics/industry-weight/add',
                    type: 'post',
                    data: $modalForm.find('form').serialize(),
                    success: function (result) {
                        $modalForm.modal('hide');
                        layer.msg(result.message, function () {
                            window.location.reload();
                        });
                    }
                });
            }
            if (action === 'update') {
                $.ajax({
                    url: '/producer/ajax/statistics/industry-weight/update',
                    type: 'post',
                    data: $modalForm.find('form').serialize(),
                    success: function (result) {
                        $modalForm.modal('hide');
                        layer.msg(result.message, function () {
                            window.location.reload();
                        });
                    }
                });
            }
        });
        // 删除
        var $modalFormDelete = $('#modal-form-delete');
        $('[data-role=delete-item]').on('click', function () {
            var $this = $(this),
                $tr = $this.parents('tr'),
                item = JSON.parse($tr.attr('data-item'));
            layer.confirm('您确定要删除这个吗（如果比重下有子比重请先删除子比重）？', function () {
                $.ajax({
                    url: '/producer/ajax/statistics/industry-weight/delete',
                    type: 'post',
                    data: {id: item.id},
                    success: function (result) {
                        $modalFormDelete.modal('hide');
                        layer.msg(result.message, function () {
                            window.location.reload();
                        });
                    }
                });
            });
        });
     /* */
    });
</script>
</body>

</html>