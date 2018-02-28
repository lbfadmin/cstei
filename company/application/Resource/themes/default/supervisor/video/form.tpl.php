<?php
$statuses = [
    '3' => '合格',
    '4' => '不合格'
];
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
    <title>编辑视频 - <?=$_TPL['site_name']?></title>
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
            <h1 class="page-title"> 编辑视频
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
                        <a href="javascript:">政府端</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <i class="fa fa-book"></i>
                        <a href="/supervisor/spot-check/index">视频管理</a>
                    </li>
                </ul>
            </div>
            <?=render_message() ?>
            <!-- END PAGE HEADER-->
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject font-dark bold"><?=$item ? '编辑' : '添加' ?>视频</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">

                        <input type="hidden" name="id" value="<?=!empty($item)?$item->id:''?>">
                        <input type="hidden" name="ref" value="<?=$_SERVER['HTTP_REFERER']?>">
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="example-text-input">抽检部门名称 <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="department_name" class="form-control" placeholder="" value="<?=empty($item)?'':$item->department_name ?>">
                                <span class="help-block">必填项，50字符以内</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="example-text-input">抽检类型 <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="type" class="form-control" placeholder="" value="<?=empty($item)?'':$item->type ?>">
                                <span class="help-block">必填项，例如：微生物检测</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="example-text-input">抽检地点 <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="place" class="form-control" placeholder="" value="<?=empty($item)?'':$item->place ?>">
                                <span class="help-block">必填项</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="example-text-input">产品批次号 <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="product_batch_sn" class="form-control" placeholder="" value="<?=empty($item)?'':$item->product_batch_sn ?>">
                                <span class="help-block">必填项，50字符以内</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="example-text-input">生产企业 <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="production_unit_name" class="form-control" placeholder="" value="<?=empty($item)?'':$item->production_unit_name ?>">
                                <span class="help-block">必填项，50字符以内</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="example-text-input">抽检状态 <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <select class="form-control" name="status">
                                    <?php foreach ($statuses as $k => $status):?>
                                        <option value="<?=$k?>" <?php if ($k==$item->status):?>selected<?php endif ?>><?=$status?></option>
                                    <?php endforeach;?>
                                </select>
                                <span class="help-block">必填项</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label" for="example-text-input">检验员 <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="inspector" class="form-control" placeholder="" value="<?=empty($item)?'':$item->inspector ?>">
                                <span class="help-block">必填项，50字符以内</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label" for="example-text-input">不合格种类 <span class="text-danger"></span></label>
                            <div class="col-md-8">
                                <select class="form-control" name="unqualified_type">
                                    <option value="0"></option>
                                    <?php foreach ($unqualifiedTypes as $k => $v):?>
                                        <option value="<?=$k?>" <?php if ($k==$item->unqualified_type):?>selected<?php endif ?>><?=$v?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label" for="example-text-input">问题环节 <span class="text-danger"></span></label>
                            <div class="col-md-8">
                                <input type="text" name="problem_chain" class="form-control" placeholder="" value="<?=empty($item)?'':$item->problem_chain ?>">
                                <span class="help-block">必填项，例如：物流</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label" for="example-text-input">处理状态 <span class="text-danger"></span></label>
                            <div class="col-md-8">
                                <select class="form-control" name="progress">
                                    <option value="0"></option>
                                    <?php foreach ($progresses as $k => $v):?>
                                        <option value="<?=$k?>" <?php if ($k==$item->progress):?>selected<?php endif ?>><?=$v?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label" for="field-body">抽检说明 <span class="text-danger">&nbsp;</span></label>
                            <div class="col-md-8">
                                <textarea name="remark" rows="15"  class="form-control"><?=empty($item)?'':$item->remark?:$this->input->getHtml('remark', '')?></textarea>
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