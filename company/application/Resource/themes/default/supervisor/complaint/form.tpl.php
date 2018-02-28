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
        <title>编辑投诉 - <?=$_TPL['site_name']?></title>
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
                    <h1 class="page-title"> 编辑投诉
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
                                <a href="/content/info/info/index">投诉管理</a>
                            </li>
                        </ul>
                    </div>
                    <?=render_message() ?>
                    <!-- END PAGE HEADER-->
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-dark bold"><?=$item ? '编辑' : '添加' ?>投诉</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">

                                <input type="hidden" name="id" value="<?=!empty($item)?$item->id:''?>">
                                <input type="hidden" name="ref" value="<?=$_SERVER['HTTP_REFERER']?>">
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="example-text-input">投诉类型 <span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" name="type" class="form-control" placeholder="" value="<?=empty($item)?'':$item->type ?>">
                                        <span class="help-block">必填项，50字符以内</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="example-text-input">投诉信息 <span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" name="complaint" class="form-control" placeholder="" value="<?=empty($item)?'':$item->complaint ?>">
                                        <span class="help-block">必填项，50字符以内</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="example-text-input">投诉时间 <span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" name="time" class="form-control" placeholder="" value="<?=empty($item)?'':$item->time ?>">
                                        <span class="help-block">必填项，50字符以内</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="example-text-input">投诉企业 <span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" name="production_unit" class="form-control" placeholder="" value="<?=empty($item)?'':$item->production_unit ?>">
                                        <span class="help-block">必填项，50字符以内</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="example-text-input">优先级 <span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <select class="form-control" name="priority">
                                            <?php foreach ($priority as $k => $value):?>
                                                <option value="<?=$k?>" <?php if ($k==$item->priority):?>selected<?php endif ?>><?=$value?></option>
                                            <?php endforeach;?>
                                        </select>
                                        <span class="help-block">必填项</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="example-text-input">状态 <span class="text-danger">*</span></label>
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
                                    <label class="col-md-2 control-label" for="example-text-input">处理部门 <span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" name="department" class="form-control" placeholder="" value="<?=empty($item)?'':$item->department ?>">
                                        <span class="help-block">必填项，50字符以内</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="example-text-input">处理结果 <span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" name="result" class="form-control" placeholder="" value="<?=empty($item)?'':$item->result ?>">
                                        <span class="help-block">必填项</span>
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