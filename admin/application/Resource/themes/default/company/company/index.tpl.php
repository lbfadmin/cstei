<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html>
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>企业管理 - <?=$_TPL['site_name']?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <?=$this->region('common/styles')?>
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="/misc/src/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
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
                    <h1 class="page-title"> 企业管理
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
                                <a href="javascript:">站点管理</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <a href="javascript:">企业</a>
                            </li>
                        </ul>
                    </div>

                    <?=render_message() ?>

                    <!-- END PAGE HEADER-->
                    <div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption">
                                <span class="caption-subject font-dark bold">企业列表</span>
                            </div>
						    <div class="actions">
                                <a class="btn btn-circle btn-primary" href="<?=url('company/company/add') ?>">
                                    <i class="fa fa-plus"> 添加企业</i>
                                </a>
                            </div> 
                        </div>
                        <div class="portlet-body">
                            <form class="form-inline area-selector" style="margin-bottom: 15px">

                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">名称</span>
                                        <input class="form-control" name="name" placeholder="企业名称" value="<?=$this->input->getString('name')?>">
                                    </div>

                                </div>
                                <button class="btn btn-primary">查询</button>
                                <button type="reset" onclick="window.location.href=window.location.pathname" class="btn btn-default">重置</button>
                                <span class="pull-right btn">共 <?=$result->total?> 条结果</span>
                            </form>
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>编号</th>
                                    <th class="col-md-2">公司名称</th>
                                    <th class="col-md-2">入驻类型</th>
                                    <th class="col-md-1">联系方式</th>
                                    <th class="col-md-2">所在位置</th>
                                    <th class="col-md-1">规模</th>
                                    <th class="col-md-2">主营业务</th>
                                    <th width="10%">入驻时间</th>
                                    <th class="col-md-1">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($result->list)):?>
                                    <?php foreach ($result->list as $item):
                                        ?>
                                        <tr>
                                            <td><?=$item->id ?></td>
                                            <td><?=$item->name ?></td>
                                            <td>入驻类型</td>
                                            <td>联系电话</td>
                                            <td><?=$item->address?></td>
                                            <td>规模</td>
                                            <td><?=mb_substr($item->description, 0, 100)?></td>
                                            <td>入驻时间</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="/producer/company/companySample/edit?id=<?=$item->id?>" data-toggle="tooltip" title="" class="btn btn-default btn-xs" ><i class="fa fa-edit"></i> 编辑</a>
                                                    <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-default btn-xs" data-role="delete" data-id="<?=$item->id?>"><i class="fa fa-times"></i> 删除</a>
													<br>
                                                    <a href="/company/employee/index?id=<?=$item->id?>" data-toggle="tooltip" title="" class="btn btn-default btn-xs" ><i class="fa fa-edit"></i>员工</a>
                                                    <a href="/producer/saltwater-fish/category/index?id=<?=$item->id?>" data-toggle="tooltip" title="" class="btn btn-default btn-xs" ><i class="fa fa-edit"></i>专家团队</a>
													<br>
                                                    <a href="/producer/saltwater-fish/category/index?id=<?=$item->id?>" data-toggle="tooltip" title="" class="btn btn-default btn-xs" ><i class="fa fa-edit"></i>专利</a>
                                                    <a href="/producer/saltwater-fish/category/index?id=<?=$item->id?>" data-toggle="tooltip" title="" class="btn btn-default btn-xs" ><i class="fa fa-edit"></i>经济指标</a>
                                                </div>
<!--                                                <div class="btn-group">
                                                    <a href="/producer/company/qualification/index?production_unit_id=<?=$item->id?>" data-toggle="tooltip" title="" class="btn btn-primary btn-xs" ><i class="fa fa-edit"></i> 资质</a>
                                                </div>-->
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                <?php endif ?>
                                </tbody>
                            </table>
							<?=$pager?>
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
    <script src="/misc/src/global/scripts/selector.area.js"></script>
    <script>
        $(function () {
            $('.area-selector').areaSelector();
        });
    </script>
    <script>
        $(function () {
            $('[data-role=delete]').on('click', function () {
                var $this = $(this),
                    id = $this.attr('data-id');
                layer.confirm('您确定要删除这条记录吗？', function () {
                    $.ajax({
                        url: '/producer/ajax/company/company/delete',
                        type: 'post',
                        data: {id: id},
                        success: function (result) {
                            layer.msg(result.message, function () {
                                window.location.reload();
                            });
                        }
                    });
                });
            });
        });
    </script>
    </body>

</html>