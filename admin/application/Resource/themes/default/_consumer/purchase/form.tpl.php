
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
        <title>编辑商品订单 - <?=$_TPL['site_name']?></title>
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
                    <h1 class="page-title"> 编辑商品订单
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
                                <a href="/consumer/purchase/index">商品订单管理</a>
                            </li>
                        </ul>
                    </div>
                    <?=render_message() ?>
                    <!-- END PAGE HEADER-->
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-dark bold"><?=$item ? '编辑' : '添加' ?>商品订单</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">

                                <input type="hidden" name="id" value="<?=!empty($item)?$item->id:''?>">
                                <input type="hidden" name="ref" value="<?=$_SERVER['HTTP_REFERER']?>">
                                <fieldset>
                                    <legend>商品订单</legend>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="example-text-input">商品ID <span class="text-danger">*</span></label>
                                        <div class="col-md-8">
                                            <input type="number" name="goods_id" class="form-control" placeholder="" value="<?=empty($item)?$this->input->getInt('goods_id'):$item->goods_id ?>">
                                            <span class="help-block">必填项，数字id</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="example-text-input">商品批次号 <span class="text-danger">*</span></label>
                                        <div class="col-md-8">
                                            <input name="batch_sn" class="form-control" placeholder="" value="<?=empty($item)?$this->input->getString('batch_sn'):$item->batch_sn ?>">
                                            <span class="help-block">必填项</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="example-text-input">订单编号 <span class="text-danger">*</span></label>
                                        <div class="col-md-8">
                                            <input name="sn" class="form-control" placeholder="" value="<?=empty($item)?$this->input->getInt('sn'):$item->sn ?>">
                                            <span class="help-block">必填项</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="example-text-input">订单类别 <span class="text-danger">*</span></label>
                                        <div class="col-md-3">
                                            <?php
                                            $types = [
                                                1 => '零售',
                                                2 => '批发',
                                            ];
                                            ?>
                                            <select name="type" class="form-control">
                                                <?php foreach ($types as $k => $type):?>
                                                    <option value="<?=$k?>" <?php if ($k==$item->type):?>selected<?php endif ?>><?=$type?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="example-text-input">渠道类别 <span class="text-danger">*</span></label>
                                        <div class="col-md-3">
                                            <?php
                                            $channels = [
                                                1 => '线下',
                                                2 => '线上',
                                            ];
                                            ?>
                                            <select name="channel" class="form-control">
                                                <?php foreach ($channels as $k => $channel):?>
                                                    <option value="<?=$k?>" <?php if ($k==$item->channel):?>selected<?php endif ?>><?=$channel?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="example-text-input">购买数量 <span class="text-danger">*</span></label>
                                        <div class="col-md-3">
                                            <input type="text" name="quantity" class="form-control" placeholder="填数字，如1000" value="<?=empty($item)?'':$item->quantity ?>">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="example-text-input">单价 <span class="text-danger">*</span></label>
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <input type="text" name="unit_price" class="form-control" placeholder="填数字，如10" value="<?=empty($item)?'':$item->unit_price ?>">
                                                <div class="input-group-addon">元</div>
                                            </div>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="example-text-input">购买时间 <span class="text-danger"></span></label>
                                        <div class="col-md-3">
                                            <input type="text" name="time_purchased" class="form-control input-datetimepicker" placeholder="默认是当前时间" value="<?=empty($item)?'':$item->time_purchased ?: $this->input->getHtml('time_purchased') ?>">
                                            <span class="help-block">选填，默认是当前时间</span>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend>客户信息</legend>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="example-text-input">客户名称 <span class="text-danger">*</span></label>
                                        <div class="col-md-8">
                                            <input name="customer_name" class="form-control" placeholder="" value="<?=empty($item)?$this->input->getInt('customer_name'):$item->customer_name ?>">
                                            <span class="help-block">必填项</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="example-text-input">客户地址 <span class="text-danger">*</span></label>
                                        <div class="col-md-8">
                                            <input name="customer_address" class="form-control" placeholder="" value="<?=empty($item)?$this->input->getInt('customer_address'):$item->customer_address ?>">
                                            <span class="help-block">必填项</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="example-text-input">下单人 <span class="text-danger">*</span></label>
                                        <div class="col-md-8">
                                            <input name="customer_contact" class="form-control" placeholder="" value="<?=empty($item)?$this->input->getInt('customer_contact'):$item->customer_contact ?>">
                                            <span class="help-block">必填项</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="example-text-input">联系电话 <span class="text-danger">*</span></label>
                                        <div class="col-md-8">
                                            <input name="customer_tel" class="form-control" placeholder="" value="<?=empty($item)?$this->input->getInt('customer_tel'):$item->customer_tel ?>">
                                            <span class="help-block">必填项</span>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend>付款信息</legend>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="example-text-input">付款方式 <span class="text-danger">*</span></label>
                                        <div class="col-md-3">
                                            <?php
                                            $pay_types = [
                                                1 => '现金',
                                                2 => '支票',
                                                3 => '电汇',
                                            ];
                                            ?>
                                            <select name="pay_type" class="form-control">
                                                <?php foreach ($pay_types as $k => $pay_type):?>
                                                    <option value="<?=$k?>" <?php if ($k==$item->pay_type):?>selected<?php endif ?>><?=$pay_type?></option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="example-text-input">到账时间 <span class="text-danger"></span></label>
                                        <div class="col-md-3">
                                            <input type="text" name="time_paid" class="form-control input-datetimepicker" placeholder="请选择" value="<?=empty($item)?'':$item->time_paid ?: $this->input->getHtml('time_paid') ?>">
                                            <span class="help-block">必填</span>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend>配送信息</legend>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="example-text-input">发货时间 <span class="text-danger"></span></label>
                                        <div class="col-md-3">
                                            <input type="text" name="time_sent" class="form-control input-datetimepicker" placeholder="请选择" value="<?=empty($item)?'':$item->time_sent ?: $this->input->getHtml('time_sent') ?>">
                                            <span class="help-block">必填</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="field-body">物流信息 <span class="text-danger">&nbsp;</span></label>
                                        <div class="col-md-8">
                                            <textarea name="logistics_info" rows="15"  class="form-control"><?=empty($item)?'':$item->logistics_info?:$this->input->getHtml('logistics_info', '')?></textarea>
                                            <div class="help-block">500字以内</div>
                                        </div>
                                    </div>
                                </fieldset>
                                <fieldset>
                                    <legend>评价</legend>
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" for="example-text-input">评分 <span class="text-danger">*</span></label>
                                        <div class="col-md-3">
                                            <input type="number" name="rank" class="form-control" placeholder="" value="<?=empty($item)?'5':$item->rank ?>">
                                            <span class="help-block">必填项，1-5的数字</span>
                                        </div>
                                    </div>
                                </fieldset>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="field-body">评价内容 <span class="text-danger">&nbsp;</span></label>
                                    <div class="col-md-8">
                                        <textarea name="remark" rows="15"  class="form-control"><?=empty($item)?'':$item->remark?:$this->input->getHtml('remark', '')?></textarea>
                                        <div class="help-block">500字以内</div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-2 control-label" for="example-text-input">评价时间 <span class="text-danger"></span></label>
                                    <div class="col-md-4">
                                        <input type="text" name="time_evaluated" class="form-control input-datetimepicker" placeholder="默认是当前时间" value="<?=empty($item)?'':$item->time_evaluated ?: $this->input->getHtml('time_evaluated') ?>">
                                        <span class="help-block">选填，默认是当前时间</span>
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
    <script type="text/javascript">
        $(".input-datetimepicker").datetimepicker({
            format: 'yyyy-mm-dd hh:ii',
            autoclose:true,
            language:"zh-CN"
        });
        var desc = UE.getEditor('field-body');
    </script>
    <script src="/misc/src/global/plugins/ueditor/ueditor.config.js"></script>
    <script src="/misc/src/global/plugins/ueditor/ueditor.all.min.js"></script>
    </body>

</html>