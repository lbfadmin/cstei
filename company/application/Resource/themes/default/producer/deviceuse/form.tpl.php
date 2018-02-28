
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html>
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>编辑设备申请 - <?=$_TPL['site_name']?></title>
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
                    <h1 class="page-title"> 编辑设备申请
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
                                <a href="/device/device/index">设备申请列表</a>
                            </li>
                        </ul>
                    </div>
                    <?=render_message() ?>
                    <!-- END PAGE HEADER-->
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-dark bold"><?=$item ? '编辑' : '添加' ?>设备申请</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">

                                <input type="hidden" name="device_id" value="<?=$device->id ?>">
                                <input type="hidden" name="ref" value="<?=$_SERVER['HTTP_REFERER']?>">
                                <input type="hidden" name="deviceType_id" value="<?=$devicetype->id?>">
                                <input type="hidden" name="device_name" value="<?=$devicetype->device_name?>">
                                <input type="hidden" name="company_id" value="<?=$_SESSION->company_id?>">
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="example-text-input">设备名称 <span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text"  disabled class="form-control" placeholder="" value="<?=empty($device)?'':$device->device_name ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="field-body">设备类型 <span class="text-danger">&nbsp;</span></label>
                                    <div class="col-md-8">
                                        <input type="text"  disabled class="form-control" placeholder="" value="<?=empty($devicetype)?'':$devicetype->type_name ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">图片 <span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <?php if (!empty($device->logo)): ?>
                                            <img src="<?=$item->logo?>" style="height:160px;margin-top: 0.5rem;border:1px solid #ddd">
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="field-body">开始时间 <span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" name="time_start" class="form-control input-datetimepicker" placeholder="" value="<?=empty($item)?'':$item->time_start ?: $this->input->getHtml('time_start') ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="field-body">结束时间 <span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" name="time_end" class="form-control input-datetimepicker" placeholder="" value="<?=empty($item)?'':$item->time_end ?: $this->input->getHtml('time_end') ?>">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="field-body">用途 <span class="text-danger">&nbsp;</span></label>
                                    <div class="col-md-8">
                                        <textarea name="yongtu" rows="2"  class="form-control"><?=empty($item)?'':$item->yongtu?:$this->input->getHtml('yongtu', '')?></textarea>
                                        <div class="help-block">100字以内</div>
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
    <script type="text/javascript">
        $("[name=time_start]").datetimepicker({
            format: 'yyyy-mm-dd hh:ii',
            autoclose:true,
            language:"zh-CN"
        });
        $("[name=time_end]").datetimepicker({
            format: 'yyyy-mm-dd hh:ii',
            autoclose:true,
            language:"zh-CN"
        });
    </script>
    </body>

</html>