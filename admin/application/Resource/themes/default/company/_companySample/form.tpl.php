<?php
$statuses = [
    'DRAFT' => '草稿',
    'PUBLISHED' => '已发布',
    'OFFLINE' => '已下线',
    'CREATED' => '待审核'
];
?>
<?php
function printTree($data, $categoryId) {
    static $depth = 0;
    foreach ($data as $k => $item) {
        ?>
        <option value="<?=$item->id?>" <?php if (!empty($item->children)):?>disabled<?php endif ?> <?php if ($item->id==$categoryId):?>selected<?php endif ?>>
            <?php echo str_repeat('　　', $depth); ?><?=$item->name; ?>
        </option>
        <?php
        if (!empty($item->children)) {
            $depth++;
            printTree($item->children, $categoryId);
        }
    }
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
        <title>编辑示范县 - <?=$_TPL['site_name']?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <?=$this->region('common/styles')?>
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="/misc/src/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
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
                    <h1 class="page-title"> 编辑示范县
                        <small></small>
                    </h1>
<!--                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a href="<?=url('dashboard')?>">首页</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <i class="fa fa-industry"></i>
                                <a href="javascript:">示范县端</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <i class="fa fa-book"></i>
                                <a href="/producer/company/company/index">示范县管理</a>
                            </li>
                        </ul>
                    </div>
					-->
                    <?=render_message() ?>
                    <!-- END PAGE HEADER-->
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-dark bold"><?=$item ? '编辑' : '添加' ?>示范县</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">

                                <input type="hidden" name="id" value="<?=!empty($item)?$item->id:''?>">
                                <input type="hidden" name="ref" value="<?=$_SERVER['HTTP_REFERER']?>">
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="example-text-input">示范县名称 <span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" name="name" class="form-control" placeholder="" value="<?=empty($item)?'':$item->name ?>">
                                        <span class="help-block">必填项，50字符以内</span>
                                    </div>
                                </div>
<?php if($data->list):?><!--隶属试验站-->
<div class="form-group">
	<label class="col-md-2 control-label" for="example-text-input">隶属试验站 <span class="text-danger">*</span></label>
		<div class="col-md-8 area-selector">
			<select name="parent_id" class="form-control" style="width: 100%;margin-right:1.25%;float:left" data-selected="<?=$item->parent_id?>">
			<option value="">--请选择综合试验站--</option>
			<?php if (!empty($data->list)):?>
				<?php foreach ($data->list as $it):?>
					<option value="<?=$it->id ?>"><?=$it->name ?></option>
				<?php endforeach ?>
			<?php endif ?>
			</select>
		</div>
</div>
<?php endif?>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="example-text-input">所在地区 <span class="text-danger">*</span></label>
                                    <div class="col-md-8 area-selector">
                                        <select name="province_id" class="form-control provinces" style="width: 19%;margin-right:1.25%;float:left" data-selected="<?=$item->province_id?>">
                                        </select>
                                        <select name="city_id" class="form-control cities" style="width: 19%;margin-right:1.25%;float:left" data-selected="<?=$item->city_id?>">
                                        </select>
                                        <select name="district_id" class="form-control districts" style="width: 19%;margin-right:1.25%;float:left" data-selected="<?=$item->district_id?>">
                                        </select>
<!--                                      <select name="block_id" class="form-control blocks" style="width: 19%;margin-right:1.25%;float:left" data-selected="<?//=$item->block_id?>">
                                        </select>
                                        <select name="community_id" class="form-control communities" style="width: 19%;float:left" data-selected="<?//=$item->community_id?>">
                                        </select>-->
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="field-body">地址 <span class="text-danger">&nbsp;</span></label>
                                    <div class="col-md-8">
                                        <textarea name="address" rows="2"  class="form-control"><?=empty($item)?'':$item->address?:$this->input->getHtml('address', '')?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="field-body">坐标 <span class="text-danger">&nbsp;</span></label>
                                    <div class="col-md-8">
                                        经度：<input type=text name="lat"  class="form-control" value="<?=empty($item)?'':$item->lat?:$this->input->getHtml('lat', '')?>" />
                                        纬度：<input type=text name="lng"  class="form-control" value="<?=empty($item)?'':$item->lng?:$this->input->getHtml('lng', '')?>"  />
                                    
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label">LOGO <span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <input type="file" name="logo">
                                        <?php if (!empty($item->logo)): ?>
                                            <img src="<?=$item->logo?>" style="height:160px;margin-top: 0.5rem;border:1px solid #ddd">
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="field-body">示范县规模 <span class="text-danger">&nbsp;</span></label>
                                    <div class="col-md-8">
                                        <textarea name="scale" rows="2"  class="form-control"><?=empty($item)?'':$item->scale?:$this->input->getHtml('scale', '')?></textarea>
                                        <div class="help-block">100字以内</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="field-body">主要产品 <span class="text-danger">&nbsp;</span></label>
                                    <div class="col-md-8">
                                        <textarea name="products" rows="2"  class="form-control"><?=empty($item)?'':$item->products?:$this->input->getHtml('products', '')?></textarea>
                                        <div class="help-block">100字以内</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="field-body">负责人 <span class="text-danger">&nbsp;</span></label>
                                    <div class="col-md-8">
                                        <textarea name="holders" rows="2"  class="form-control"><?=empty($item)?'':$item->holders?:$this->input->getHtml('holders', '')?></textarea>
                                        <div class="help-block">100字以内</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="field-body">示范县简介 <span class="text-danger">&nbsp;</span></label>
                                    <div class="col-md-8">
                                        <textarea name="description" rows="15"  class="form-control"><?=empty($item)?'':$item->description?:$this->input->getHtml('description', '')?></textarea>
                                        <div class="help-block">500字以内</div>
                                    </div>
                                </div>

                                <div class="form-group form-actions">
                                    <div class="col-md-8 col-md-offset-2">
                                        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> 提交</button>
                                        <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> 重置</button>
                                    </div>
                                </div>
                            </form>
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

    <script src="/misc/src/global/plugins/ueditor/ueditor.config.js"></script>
    <script src="/misc/src/global/plugins/ueditor/ueditor.all.min.js"></script>
    <script src="/misc/src/global/scripts/selector.area.js"></script>
    <script type="text/javascript">
        $('.area-selector').areaSelector();
    </script>
    </body>

</html>