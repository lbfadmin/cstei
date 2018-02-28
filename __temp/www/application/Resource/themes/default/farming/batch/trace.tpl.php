<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html>
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title>批次追溯 - <?=$_TPL['site_name']?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <?=$this->region('common/styles')?>
    <link rel="shortcut icon" href="favicon.ico" />
    <link rel="stylesheet" href="/misc/src/pages/css/batch.css">
</head>
<!-- END HEAD -->

<body class="page-header-menu-fixed page-sidebar-closed-hide-logo page-container-bg-solid">
<div class="page-wrapper">
    <?=$this->region('common/top')?>
    <div class="page-wrapper-row full-height">
        <div class="page-wrapper-middle">
            <div class="page-container">
                <div class="page-content-wrapper">
                    <div class="page-head">
                        <div class="container-fluid">
                            <!-- BEGIN PAGE TITLE -->
                            <div class="page-title">
                                <h1>批次追溯
                                </h1>
                            </div>
                            <!-- END PAGE TITLE -->
                        </div>
                    </div>
                    <div class="page-content">
                        <div class="container-fluid">
                            <div class="page-content-inner">
                                <div class="mt-content-body">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="portlet light ">
                                                <div class="portlet-title" style="position: relative">
                                                    <div class="caption caption-md">
                                                        <i class="icon-bar-chart font-dark hide"></i>
                                                        <span class="caption-subject font-green-steel uppercase bold">追溯详情（批次号：<?=$batch->sn?>）</span>
                                                    </div>
                                                </div>
                                                <div class="portlet-body">
                                                    <div class="block block-base">
                                                        <div class="block-title">基本信息</div>
                                                        <div class="block-body">
                                                            <div class="row">
                                                                <div class="col-md-2 section type">
                                                                    <div class="name">类型</div>
                                                                    <div class="value"><?=$batch->product_type_name?></div>
                                                                </div>
                                                                <div class="col-md-2 section">
                                                                    <div class="name">批次</div>
                                                                    <div class="value"><?=$batch->sn?></div>
                                                                </div>
                                                                <div class="col-md-2 section">
                                                                    <div class="name">养殖时间</div>
                                                                    <div class="value"><?=$batch->date_start?></div>
                                                                </div>
                                                                <div class="col-md-2 section">
                                                                    <div class="name">收获时间</div>
                                                                    <div class="value"><?=$batch->date_end?></div>
                                                                </div>
                                                                <div class="col-md-2 section status">
                                                                    <div class="name">达标情况</div>
                                                                    <div class="value">合格</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="block block-trace">
                                                        <div class="block-title">溯源信息</div>
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            <li role="presentation" class="active col-md-2">
                                                                <a href="#produce" aria-controls="settings" role="tab" data-toggle="tab">
                                                                    <div class="name">生产</div>
                                                                    <div class="status">合格</div>
                                                                </a>
                                                            </li>
                                                            <li role="presentation" class="col-md-2">
                                                                <a href="#processing" aria-controls="messages" role="tab" data-toggle="tab">
                                                                    <div>
                                                                        <div class="name">加工</div>
                                                                        <div class="status">合格</div>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                            <li role="presentation" class="col-md-2">
                                                                <a href="#storage" aria-controls="profile" role="tab" data-toggle="tab">
                                                                    <div>
                                                                        <div class="name">仓储</div>
                                                                        <div class="status">合格</div>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                            <li role="presentation" class="sales col-md-2">
                                                                <a href="#sales" aria-controls="home" role="tab" data-toggle="tab">
                                                                    <div>
                                                                        <div class="name">销售</div>
                                                                        <div class="status">合格</div>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                            <li role="presentation" class="col-md-2">
                                                                <a href="#transport" aria-controls="profile" role="tab" data-toggle="tab">
                                                                    <div>
                                                                        <div class="name">物流</div>
                                                                        <div class="status">合格</div>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                            <li role="presentation" class="check col-md-2">
                                                                <a href="#check" aria-controls="settings" role="tab" data-toggle="tab">
                                                                    <div>
                                                                        <div class="name">抽检</div>
                                                                        <div class="status">合格</div>
                                                                    </div>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                        <!-- Tab panes -->
                                                        <div class="tab-content">
                                                            <div role="tabpanel" class="tab-pane active" id="produce">
                                                                <div class="table-header">饲养记录</div>
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered table-hover">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>ID</th>
                                                                            <th>养殖池</th>
                                                                            <th>饲料种类</th>
                                                                            <th>投放量</th>
                                                                            <th>投放位置</th>
                                                                            <th>投放时间</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <?php if (!empty($feed_list)):?>
                                                                            <?php foreach ($feed_list as $item):
                                                                                ?>
                                                                                <tr>
                                                                                    <td><?=$item->id ?></td>
                                                                                    <td>
                                                                                        <?=$item->pool_name?>
                                                                                    </td>
                                                                                    <td><?=$item->type_name ?></td>
                                                                                    <td><?=$item->amount?></td>
                                                                                    <td><?=$item->position?></td>
                                                                                    <td><?=$item->time_fed?></td>
                                                                                </tr>
                                                                            <?php endforeach ?>
                                                                        <?php else:?>
                                                                            <tr>
                                                                                <td colspan="8" class="no-results">没有相关结果。</td>
                                                                            </tr>
                                                                        <?php endif ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div role="tabpanel" class="tab-pane" id="sales">
                                                                <div class="table-header">销售记录</div>
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered table-hover">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>ID</th>
                                                                            <th>订单编号</th>
                                                                            <th>购买数量</th>
                                                                            <th>单价</th>
                                                                            <th>总价</th>
                                                                            <th>客户名称</th>
                                                                            <th>客户地址</th>
                                                                            <th>购买时间</th>
                                                                            <th>付款时间</th>
                                                                            <th>发货时间</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <?php if (!empty($sales_list)):?>
                                                                            <?php foreach ($sales_list as $item):
                                                                                ?>
                                                                                <tr>
                                                                                    <td><?=$item->id ?></td>
                                                                                    <td><?=$item->sn?></td>
                                                                                    <td><?=$item->quantity?></td>
                                                                                    <td><?=$item->unit_price?> 元</td>
                                                                                    <td><?=$item->unit_price * $item->quantity?> 元</td>
                                                                                    <td><?=$item->customer_name?></td>
                                                                                    <td><?=$item->customer_address?></td>
                                                                                    <td><?=$item->time_purchased?></td>
                                                                                    <td><?=$item->time_paid?></td>
                                                                                    <td><?=$item->time_sent?></td>
                                                                                </tr>
                                                                            <?php endforeach ?>
                                                                        <?php else:?>
                                                                            <tr>
                                                                                <td colspan="20" class="no-results">没有相关结果。</td>
                                                                            </tr>
                                                                        <?php endif ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div role="tabpanel" class="tab-pane" id="transport">
                                                                <div class="table-header">物流记录</div>
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered table-hover">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>ID</th>
                                                                            <th>物流公司</th>
                                                                            <th>冷链车辆编号</th>
                                                                            <th>运输环境</th>
                                                                            <th>运输地点</th>
                                                                            <th>运输时间</th>
                                                                            <th>操作人</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <?php if (!empty($transport_list)):?>
                                                                            <?php foreach ($transport_list as $item):
                                                                                ?>
                                                                                <tr>
                                                                                    <td><?=$item->id ?></td>
                                                                                    <td><?=$item->logistics_company_name ?></td>
                                                                                    <td><?=$item->truck_sn?></td>
                                                                                    <td><?=$item->env?></td>
                                                                                    <td><?=$item->position?></td>
                                                                                    <td><?=$item->time?></td>
                                                                                    <td><?=$item->operator?></td>
                                                                                </tr>
                                                                            <?php endforeach ?>
                                                                        <?php else:?>
                                                                            <tr>
                                                                                <td colspan="7" class="no-results">没有相关结果。</td>
                                                                            </tr>
                                                                        <?php endif ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div role="tabpanel" class="tab-pane" id="processing">
                                                                <div class="table-header">加工记录</div>
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered table-hover">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>ID</th>
                                                                            <th>暂养池</th>
                                                                            <th>加工类型</th>
                                                                            <th>操作员</th>
                                                                            <th>时间</th>
                                                                            <th>检验员</th>
                                                                            <th>重量</th>
                                                                            <th>装箱记录</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <?php if (!empty($processing_list)):?>
                                                                            <?php foreach ($processing_list as $item):
                                                                                ?>
                                                                                <tr>
                                                                                    <td><?=$item->id ?></td>
                                                                                    <td><?=$item->temp_pool_name?></td>
                                                                                    <td><?=$item->type ?></td>
                                                                                    <td><?=$item->operator?>
                                                                                    <td><?=$item->time?>
                                                                                    <td><?=$item->checker?>
                                                                                    <td><?=$item->weight?></td>
                                                                                    <td><?=$item->packing?></td>
                                                                                </tr>
                                                                            <?php endforeach ?>
                                                                        <?php else:?>
                                                                            <tr>
                                                                                <td colspan="9" class="no-results">没有相关结果。</td>
                                                                            </tr>
                                                                        <?php endif ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div role="tabpanel" class="tab-pane" id="check">
                                                                <div class="table-header">抽检记录</div>
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered table-hover">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>ID</th>
                                                                            <th>取样信息</th>
                                                                            <th>取样人</th>
                                                                            <th>取样地点</th>
                                                                            <th>检测结果</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <?php if (!empty($check_list)):?>
                                                                            <?php foreach ($check_list as $item):
                                                                                ?>
                                                                                <tr data-item='<?=html_attr_json($item)?>'>
                                                                                    <td><?=$item->id ?></td>
                                                                                    <td>
                                                                                        <?=$item->sampling?>
                                                                                    </td>
                                                                                    <td><?=$item->operator ?></td>
                                                                                    <td><?=$item->position ?></td>
                                                                                    <td><?=$item->results ?></td>
                                                                                </tr>
                                                                            <?php endforeach ?>
                                                                        <?php else:?>
                                                                            <tr>
                                                                                <td colspan="8" class="no-results">没有相关结果。</td>
                                                                            </tr>
                                                                        <?php endif ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <div role="tabpanel" class="tab-pane" id="storage">
                                                                <div class="table-header">入库记录</div>
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered table-hover">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>ID</th>
                                                                            <th>仓库ID</th>
                                                                            <th>装箱记录</th>
                                                                            <th>仓储记录</th>
                                                                            <th>操作员</th>
                                                                            <th>时间</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <?php if (!empty($warehousing_list)):?>
                                                                            <?php foreach ($warehousing_list as $item):
                                                                                ?>
                                                                                <tr data-item='<?=html_attr_json($item)?>'>
                                                                                    <td><?=$item->id ?></td>
                                                                                    <td><?=$item->warehouse_id?></td>
                                                                                    <td><?=$item->packing?></td>
                                                                                    <td><?=$item->storage?></td>
                                                                                    <td>
                                                                                        <?=$item->operator?>
                                                                                    </td>
                                                                                    <td><?=$item->time ?></td>
                                                                                </tr>
                                                                            <?php endforeach ?>
                                                                        <?php else:?>
                                                                            <tr>
                                                                                <td colspan="9" class="table-no-results">没有相关结果。</td>
                                                                            </tr>
                                                                        <?php endif ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="table-header">出库记录</div>
                                                                <div class="table-responsive">
                                                                    <table class="table table-bordered table-hover">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>ID</th>
                                                                            <th>仓库ID</th>
                                                                            <th>操作员</th>
                                                                            <th>时间</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <?php if (!empty($ex_warehouse_list)):?>
                                                                            <?php foreach ($ex_warehouse_list as $item):
                                                                                ?>
                                                                                <tr data-item='<?=html_attr_json($item)?>'>
                                                                                    <td><?=$item->id ?></td>
                                                                                    <td><?=$item->warehouse_id?></td>
                                                                                    <td>
                                                                                        <?=$item->operator?>
                                                                                    </td>
                                                                                    <td><?=$item->time ?></td>
                                                                                </tr>
                                                                            <?php endforeach ?>
                                                                        <?php else:?>
                                                                            <tr>
                                                                                <td colspan="9" class="table-no-results">没有相关结果。</td>
                                                                            </tr>
                                                                        <?php endif ?>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?=$this->region('common/footer')?>
</div>
<?=$this->region('common/scripts')?>
</body>

</html>