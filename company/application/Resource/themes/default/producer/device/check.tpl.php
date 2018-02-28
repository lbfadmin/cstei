<?php
$statuses = [
    'DRAFT' => '草稿',
    'PUBLISHED' => '已发布',
    'OFFLINE' => '已下线',
    'CREATED' => '待审核'
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
        <title>查看设备 - <?=$_TPL['site_name']?></title>
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
                    <h1 class="page-title"> 查看设备
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
                                <a href="javascript:">设备管理</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <i class="fa fa-book"></i>
                                <a href="/device/device/index">设备列表</a>
                            </li>
                        </ul>
                    </div>
                    <?=render_message() ?>
                    <!-- END PAGE HEADER-->
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-dark bold">查看设备管理</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">

                                <input type="hidden" name="id" value="<?=!empty($item)?$item->id:''?>">
                                <input type="hidden" name="ref" value="<?=$_SERVER['HTTP_REFERER']?>">
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="example-text-input">设备名称 <span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" disabled name="device_name" class="form-control" placeholder="" value="<?=empty($item)?'':$item->device_name ?>">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="field-body">启用时间 <span class="text-danger">&nbsp;</span></label>
                                    <div class="col-md-8">
                                        <input type="text" disabled name="time_use" class="form-control input-datetimepicker" placeholder="默认是当前时间" value="<?=empty($item)?'':$item->time_use ?: $this->input->getHtml('time_use') ?>">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label">图片 <span class="text-danger">*</span></label>
                                    <div class="col-md-8">

                                        <?php if (!empty($item->pic)): ?>
                                            <img src="<?=$item->pic?>" style="height:160px;margin-top: 0.5rem;border:1px solid #ddd">
                                        <?php endif ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="field-body">参数 <span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <textarea id="field-body"  readonly="readonly" name="canshu" style="min-height: 400px;border: none;width: 100%"><?=empty($item)?'':$item->canshu?:$this->input->getHtml('canshu', '')?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="field-body">类型 <span class="text-danger">&nbsp;</span></label>
                                    <div class="col-md-8">
                                        <select name="device_type" disabled class="form-control" style="width: 100%">

                                            <option value="" selected>--请选择设备类型--</option>
                                            <?php foreach($devices as $k=>$v):?>
                                                <option  <?php  if($k==$item->device_type): ?>selected
                                                    <?php endif ?>
                                                    value="<?=$k?>"><?=$v?></option>
                                            <?php endforeach?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group form-actions">
                                    <div class="col-md-8 col-md-offset-2">
                                        <a href="/producer/device-use/add?deviceId=<?=$item->id?>" data-toggle="tooltip" title="" class="btn btn-sm btn-primary" ><i class="fa fa-edit"></i> 申请</a>
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

    <script type="text/javascript">
        $("[name=time_use]").datetimepicker({
            format: 'yyyy-mm-dd hh:ii',
            autoclose:true,
            language:"zh-CN"
        });
        var desc = UE.getEditor('field-body');
    </script>
    </body>

</html>