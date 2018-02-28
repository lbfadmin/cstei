<?php
function printTree($data) {
    static $depth = 0;
    foreach ($data as $k => $item) {
        ?>
        <tr class="<?=isset($item->children)?'parent':'child'?>"
            data-id="<?=$item->id?>"
            data-item='<?=json_encode(['id' => $item->id,'production_unit_id' => $item->production_unit_id, 'name' => $item->name, 'weight' => $item->weight, 'parent_id' => $item->parent_id])?>'
        >
            <td style="width: 5%"><?=$item->id?></td>
            <td style="width: 30%"><?php echo str_repeat('　　', $depth);?><span class="indent"><i class="fa <?= isset($item->children) ? 'fa-caret-down' : 'fa-caret-right'?>"></i>&nbsp;</span><?=isset($item->children)?'<strong>'.$item->name.'</strong>':$item->name; ?></td>
            <td style="width: 15%"><?=$item->production_unit_name?></td>
            <td style="width: 15%"><?=$item->weight ?></td>
            <td style="width: 20%">
                <div class="btn-group">
                    <?php if (!$item->parent_id):?>
                        <a href="javascript:"
                           data-role="add-item"
                           class="btn btn-xs btn-default">
                            <i class="fa fa-plus"> 添加子类</i>
                        </a>
                    <?php endif ?>
                    <a href="javascript:"
                       data-toggle="tooltip"
                       data-role="edit-item"
                       class="btn btn-xs btn-default" data-original-title="编辑"><i class="fa fa-pencil"> 编辑</i></a>
                    <a href="javascript:"
                       data-toggle="tooltip"
                       data-role="delete-item"
                       class="btn btn-xs btn-danger" data-original-title="删除"><i class="fa fa-times"> 删除</i></a>
                </div>
            </td>
        </tr>
        <?php if (isset($item->children)): ?>
            <td style="padding: 0" colspan="5">
                <table class="table nested table-striped table-bordered table-hover" style="border: none;margin-bottom:0">
                    <?php
                    if (isset($item->children)) {
                        $depth++;
                        printTree($item->children);
                    }
                    ?>
                </table>
            </td>
        <?php endif ?>
    <?php }
    $depth--;
}
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
    <title>企业产业比重管理 - <?=$_TPL['site_name']?></title>
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
            <h1 class="page-title"> 海水鱼养殖产量统计
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
                        <a href="javascript:">试验站</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
					
                    <li>
                        <i class="fa fa-list"></i>
                        <a href="javascript:">海水鱼养殖产量统计</a>
                    </li>
                </ul>
            </div>

            <?=render_message() ?>
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject font-dark bold">海水鱼养殖产量统计</span>
                    </div>
                    <div class="actions">
                        <a class="btn btn-circle btn-primary" href="javascript:" data-role="add-item" data-item='<?=json_encode(['id' => 0])?>'>
                            <i class="fa fa-plus"> 添加海水鱼养殖产量统计</i>
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-bordered table-hover">
   <!---->              <thead>
                        <tr>
                            <th width="10%">季度</th>
                            <th width="10%">养殖方式</th>
                            <th width="10%">规格</th>
                               <?php if (!empty($cats)):?>
                                    <?php foreach ($cats as $item):
                                        ?>
										<th><?=$item ?></th>
							
                                    <?php endforeach ?>
                                <?php endif ?>
           
                            <th width="10%">操作</th>
                        </tr>
                        </thead>
                        <tbody>
								<?php if (!empty($result)):?>
                                    <?php foreach ($result->list as $item):
                                        ?>
										
										<tr>
										<?php if ($item->type==1):?> 
											<th rowspan=5><?=$item->quarter ?></th>
											<th rowspan=5><?=$way_arr[$item->way_id] ?></th>
										<?php endif ?>							
											<th><?=$type_arr[$item->type]?></th>
											<?php foreach ($cats as $it):?>
												<th><?=$item->$it ?></th>
											<?php endforeach ?>
										<?php if ($item->type==1):?> 
											<th rowspan=5><a>编辑</a>
											&nbsp;&nbsp;&nbsp;<a>删除</a></th>
										<?php endif ?>	
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
<!-- END CONTAINER -->
<div class="modal fade" id="modal-form">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">编辑类目</h4>
            </div>
            <div class="modal-body">
                <form class="form form-horizontal" method="post">
                    <div class="form-group">
                        <label class="control-label col-md-3">季度 <span class="required">*</span></label>
                        <div class="col-md-8">
                            <input class="form-control" name="quarter" placeholder='格式为：年/季度 如： 2017/03 '>
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