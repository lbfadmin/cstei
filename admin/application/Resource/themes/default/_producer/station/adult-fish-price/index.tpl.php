<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html>
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title>本季度末海水鱼成鱼塘边现价（单位：元/斤） - <?=$_TPL['site_name']?></title>
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
		<?php if (!empty($unit_name)):?>
            <h1 class="page-title"><?=$unit_name?> <!--本季度末海水鱼成鱼塘边现价（单位：元/斤）-->
                <small></small>
            </h1>
		<?php endif?>
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="<?=url('dashboard')?>">首页</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <i class="fa fa-pencil-square-o"></i>
                        <a href="javascript:">示范县区</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <i class="fa fa-list"></i>
                        <a href="javascript:">本季度末海水鱼成鱼塘边现价（单位：元/斤）</a>
                    </li>

                </ul>
            </div>

            <?=render_message() ?>
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
                    <div class="actions">
                        <a class="btn btn-circle btn-primary" href="javascript:" data-role="add-item">
                            <i class="fa fa-plus">添加本季度末海水鱼成鱼塘边现价（单位：元/斤）</i>
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-bordered table-hover">
                 <thead>
                        <tr>
                            <th width="10%">示范县区</th>
                            <th width="10%">季度</th>
                         <!-- <th width="10%">养殖方式</th>-->
                            <th width="10%">规格</th>
                               <?php if (!empty($cats)):?>
                                    <?php foreach ($cats as $item):
                                        ?>
                                        <th><?=$item ?></th>
                            
                                    <?php endforeach ?>
                                <?php endif ?>
           
                            <th width="10%" colspan=2>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                                <?php if (!empty($result->list)):?>
                                    <?php foreach ($result->list as $item):?>
                                        
                                        <tr>
                                        <?php if ($item->type==1):?> 
                                            <th rowspan=2><?=$item->unit_name ?></th>
                                            <th rowspan=2><?=$item->quarter_name ?></th>
                                        <?php endif ?>                          
                                            <th><?=$type_arr[$item->type]?></th>
                                <?php if (!empty($cats)):?>
                                            <?php foreach ($cats as $it):?>
                                                <th><?=$item->$it ?></th>
                                            <?php endforeach ?>
                                <?php endif ?>  
<th>
<div class="btn-group">
    <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-default btn-xs" data-role="edit-item"
	 data-id="<?=$item->id?>">
        <i class="fa fa-edit"></i> 编辑
    </a>
</div>
</th>
<?php if ($item->type==1):?> 
<th rowspan=2>
<div class="btn-group">
    <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-default btn-xs" data-role="delete-item" data-id="<?=$item->id?>"><i class="fa fa-times"></i> 删除</a>
</div>
</th>
<?php endif ?>  
                                        </tr>
                            
                                    <?php endforeach ?>
                                <?php endif ?>
                        
                        <?php //printTree($industrys); ?>
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
<div class="modal fade" id="modal-form">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">编辑本季度末海水鱼成鱼塘边现价（单位：元/斤）</h4>
            </div>
            <div class="modal-body">
                <form class="form form-horizontal" method="post">
                    <div class="form-group">
                        <label class="control-label col-md-3">季度 <span class="required">*</span></label>
                        <div class="col-md-8">
                            <input class="form-control" name="quarter" placeholder='格式为：年/季度 如： 2017/03 '>
                        </div>
                    </div>

<table>
    <tr>
        <th width='120'>鱼类</th>
        <th width='180'>标准规格</th>
        <th width='180'>超标准</th>
    </tr>
     <?php if (!empty($cats)):?>
        <?php foreach ($cats as $item):?>

            <tr>
                <th><?=$item ?></th>
                <th><input class="form-control" name="standard[<?=$item ?>]" value="0"></th>
                <th><input class="form-control" name="exceeding[<?=$item ?>]" value="0"></th>
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
   // 添加
        $('[data-role=add-item]').on('click', function () {

            var unitid = $("#unit_id").val();
            if(unitid==''){
                alert("请选择要添加的示范县！");
                return; 
            }
            location.href='/producer/saltwater-fish/adult-fish-price/add?unit_id='+unitid;
            return;

        });
        // 修改
        $('[data-role=edit-item]').on('click', function () {
			// var $this = $(this);
			var id 	=	$(this).attr('data-id');
		    location.href='/producer/saltwater-fish/adult-fish-price/edit?id='+id;

        });
        // 删除
        var $modalFormDelete = $('#modal-form-delete');
        $('[data-role=delete-item]').on('click', function () {

            var id = JSON.parse($(this).attr('data-id'));

            layer.confirm('您确定要删除这个吗？', function () {
                $.ajax({
                    url: '/producer/ajax/breeding/breeding-price/delete',
                    type: 'post',
                    data: {id: id},
                    success: function (result) {
                        $modalFormDelete.modal('hide');
                        layer.msg(result.message, function () {
                            window.location.reload();
                        });
                    }
                });
            });
        });
/*
            var $this = $(this),
                $tr = $this.parents('tr');
            var item = $tr.length ? JSON.parse($tr.attr('data-item')) : {};
           // $modalForm.find('[name=parent_id]').val(item.id).attr('disabled', false);
           // $modalForm.find('[name=id]').val('');
           // $modalForm.find('[name=production_unit_id]').val('');
           // $modalForm.find('[name=name]').val('');
           // $modalForm.find('[name=weight]').val(0);
            $modalForm.modal();
            $modalForm.data('action', 'add');
*/
  /*

        $modalForm.find('.ok').on('click', function () {
            var action = $modalForm.data('action');

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

  */
    });
</script>
</body>

</html>