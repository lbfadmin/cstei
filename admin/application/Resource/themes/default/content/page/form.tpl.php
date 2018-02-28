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
        <title>编辑页面 - <?=$_TPL['site_name']?></title>
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
                    <h1 class="page-title"> 编辑页面
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
                                <a href="javascript:">内容管理</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <i class="fa fa-book"></i>
                                <a href="/content/page/index">页面管理</a>
                            </li>
                        </ul>
                    </div>
                    <?=render_message() ?>
                    <!-- END PAGE HEADER-->
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-dark bold"><?=$item ? '编辑' : '添加' ?>页面</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">

                                <input type="hidden" name="id" value="<?=!empty($item)?$item->id:''?>">
                                <input type="hidden" name="ref" value="<?=$_SERVER['HTTP_REFERER']?>">
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="example-text-input">标题 <span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" name="title" class="form-control" placeholder="" value="<?=empty($item)?'':$item->title ?>">
                                        <span class="help-block">必填项，50字符以内</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="example-text-input">关键词 <span class="text-danger"></span></label>
                                    <div class="col-md-8">
                                        <input type="text" name="keywords" class="form-control" placeholder="" value="<?=empty($item)?'':$item->keywords ?: $this->input->getHtml('keywords', '') ?>">
                                        <span class="help-block">选填，200字符以内，用空格分隔</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="field-body">摘要 <span class="text-danger">&nbsp;</span></label>
                                    <div class="col-md-8">
                                        <textarea name="summary" rows="5"  class="form-control"><?=empty($item)?'':$item->summary?:$this->input->getHtml('summary', '')?></textarea>
                                        <div class="help-block">300字以内的文章概要</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="field-body">正文 <span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <textarea id="field-body" name="body" style="min-height: 400px;border: none;width: 100%"><?=empty($item)?'':$item->body?:$this->input->getHtml('body', '')?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="example-text-input">发布时间 <span class="text-danger"></span></label>
                                    <div class="col-md-4">
                                        <input type="text" name="time_published" class="form-control input-datetimepicker" placeholder="默认是当前时间" value="<?=empty($item)?'':$item->time_published ?: $this->input->getHtml('time_published') ?>">
                                        <span class="help-block">选填，默认是当前时间</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="example-text-input">文章状态 <span class="text-danger">*</span></label>
                                    <div class="col-md-4">
                                        <select name="status" class="form-control">
                                            <?php foreach ($statuses as $k => $v):?>
                                                <option value="<?=$k?>" <?php if (!empty($item)&&$k==$item->status):?>selected<?php endif ?>><?=$v?></option>
                                            <?php endforeach; ?>
                                        </select>
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
        $("[name=time_published]").datetimepicker({
            format: 'yyyy-mm-dd hh:ii',
            autoclose:true,
            language:"zh-CN"
        });
        var desc = UE.getEditor('field-body');
    </script>
    </body>

</html>