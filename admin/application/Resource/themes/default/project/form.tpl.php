<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html>
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title>编辑园区维修 - <?=$_TPL['site_name']?></title>
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
            <h1 class="page-title"> 编辑园区维修
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
                        <i class="fa fa-book"></i>
                        <a href="/project/project/index">维修列表</a>
                    </li>
                </ul>
            </div>
            <?=render_message() ?>
            <!-- END PAGE HEADER-->
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject font-dark bold"><?=$item ? '编辑' : '添加' ?>维修</span>
                    </div>
                </div>
                <div class="portlet-body form">
                    <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">

                        <input type="hidden" name="id" value="<?=!empty($item)?$item->id:''?>">
                        <input type="hidden" name="ref" value="<?=$_SERVER['HTTP_REFERER']?>">
                        <input type="hidden" name="company_id" value="<?=$_SESSION['company_id']?>">
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="example-text-input">事项 <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="matter" class="form-control" placeholder="" value="<?=empty($item)?'':$item->matter ?>">
                                <span class="help-block">必填项，50字符以内</span>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-2 control-label">图片 <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="file" name="pic">
                                <?php if (!empty($item->pic)): ?>
                                    <img src="<?=$item->pic?>" style="height:160px;margin-top: 0.5rem;border:1px solid #ddd">
                                <?php endif ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="field-body">联系电话 <span class="text-danger">&nbsp;</span></label>
                            <div class="col-md-8">
                                <input name="tel" rows="2"  class="form-control" value="<?=empty($item)?'':$item->tel?:$this->input->getHtml('tel', '')?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="field-body">联系人 <span class="text-danger">&nbsp;</span></label>
                            <div class="col-md-8">
                                <input name="linkman"   class="form-control" value="<?=empty($item)?'':$item->linkman?:$this->input->getHtml('linkman', '')?>">
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

</body>

</html>