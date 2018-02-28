<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html>
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>编辑企业诚信 - <?=$_TPL['site_name']?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <?=$this->region('common/styles')?>
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="/misc/src/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="/misc/src/global/plugins/jquery-raty/jquery.raty.css">
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
                    <h1 class="page-title"> 编辑企业诚信
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
                                <a href="javascript:">企业端</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <i class="fa fa-book"></i>
                                <a href="/producer/company/credit/index">企业诚信管理</a>
                            </li>
                        </ul>
                    </div>
                    <?=render_message() ?>
                    <!-- END PAGE HEADER-->
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-dark bold"><?=$item ? '编辑' : '添加' ?>企业诚信</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">

                                <input type="hidden" name="id" value="<?=!empty($item)?$item->id:''?>">
                                <input type="hidden" name="ref" value="<?=$_SERVER['HTTP_REFERER']?>">
                                <?php if ($this->input->getInt('production_unit_id')):?>
                                <input type="hidden" name="production_unit_id" value="<?=$this->input->getInt('production_unit_id')?>">
                                <?php else:?>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="example-text-input">企业ID <span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <input type="number" name="production_unit_id" class="form-control" placeholder="请填写企业数字ID" <?php if ($item->production_unit_id):?>readonly<?php endif ?> value="<?=$this->input->getInt('production_unit_id')?:$item->production_unit_id ?>">
                                    </div>
                                </div>
                                <?php endif ?>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="example-text-input">信用评级 <span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <span class="rate" data-rate="<?=$item->rank?>"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="example-text-input">不良经营 <span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" name="bad_management" class="form-control" placeholder="" value="<?=$this->input->getInt('bad_management')?:$item->bad_management ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="example-text-input">监管投诉 <span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" name="supervisor_complaint" class="form-control" placeholder="" value="<?=$this->input->getInt('supervisor_complaint')?:$item->supervisor_complaint ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="example-text-input">不合格记录 <span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" name="production_unqualified" class="form-control" placeholder="" value="<?=$this->input->getInt('production_unqualified')?:$item->production_unqualified ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="example-text-input">第三方不合格记录 <span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <input type="text" name="third_party_unqualified" class="form-control" placeholder="" value="<?=$this->input->getInt('third_party_unqualified')?:$item->third_party_unqualified ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="example-text-input">信用状态 <span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <select class="form-control" name="status">
                                            <?php foreach ($statuses as $k => $status):?>
                                                <option value="<?=$k?>" <?php if ($item->status==$k) { ?>selected<?php } ?>><?=$status?></option>
                                            <?php endforeach;?>
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
    <script src="/misc/src/global/scripts/selector.area.js"></script>
    <script src="/misc/src/global/plugins/jquery-raty/jquery.raty.js"></script>
    <script type="text/javascript">
        $('.area-selector').areaSelector();
        $('.rate').raty({
            path: '/misc/src/global/plugins/jquery-raty/images/',
            scoreName: 'rank',
            cancel: true,
            score: function() {
                return $(this).attr('data-rate');
            }
        });
    </script>
    </body>

</html>