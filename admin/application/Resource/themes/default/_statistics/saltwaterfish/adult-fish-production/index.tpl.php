
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html>
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title>示范区县海水鱼成鱼养殖产量统计 - <?=$_TPL['site_name']?></title>
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
                        <i class="fa fa-pencil-square-o"></i>
                        <a href="javascript:">统计数据</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    
                    <li>
                        <i class="fa fa-list"></i>
                        <a href="javascript:">示范区县海水鱼成鱼养殖产量统计</a>
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
									

									</div>
									<button class="btn btn-primary">查询</button>
									<button type="reset" onclick="window.location.href=window.location.pathname" class="btn btn-default">重置</button>
									<span class="pull-right btn">共 <?=$result->total?> 条结果</span>
									<a href = "push?quarter=<?=$search['quarter']?>" target = "blank" ><input type="button" value="导出数据" class="btn btn-default"></a>
								</form>
								</span>
                            </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-bordered table-hover">
                    <thead>
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
           
                        </tr>
                        </thead>
                        <tbody>
                                <?php if (!empty($result)):?>
                                    <?php foreach ($result->list as $item):
                                        ?>
                                        
                                        <tr data-item='<?=html_attr_json($item)?>' >
                                        <?php if ($item->type==1):?> 
                                            <th rowspan=5><?=$item->quarter_name ?></th>
                                            <th rowspan=5><?=$way_arr[$item->way_id] ?></th>
                                        <?php endif ?>                          
                                            <th><?=$type_arr[$item->type]?></th>
                                            <?php if (!empty($cats)):?>
                                                <?php foreach ($cats as $it):?>
                                                    <th><?=$item->$it ?></th>
                                                <?php endforeach ?>
                                            <?php endif ?>      
                                        <?php if ($item->type==1):?> 
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

<?=$this->region('common/footer')?>
<?=$this->region('common/scripts')?>

</body>

</html>