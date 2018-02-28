<?php
$status_names = [
    1 => '正常',
    2 => '检查维修',
    3 => '异常'
];
$status_classes = [
    1 => '',
    2 => 'warning',
    3 => 'danger'
];
$exception_types = [
    1 => '溶氧异常',
    2 => '温度异常',
    3 => '需投饵料'
];
function printCategoryTree($categories)
{
    static $depth = 0;
    foreach ($categories as $k => $item) {
        ?>
        <option value="<?= $item->id ?>" <?php if ($_GET['category_id']==$item->id):?>selected<?php endif ?>><?php echo str_repeat('　　', $depth);?><?= $item->name ?></option>
        <?php if (isset($item->children)): ?>
            <?php
            if (isset($item->children)) {
                $depth++;
                printCategoryTree($item->children);
            }
            ?>
        <?php endif ?>
        <?php
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
        <title>养殖池管理 - <?=$_TPL['site_name']?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <?=$this->region('common/styles')?>
        <link type="text/css" rel="stylesheet" href="/misc/src/global/plugins/video.js/video-js.min.css">
        <link rel="shortcut icon" href="favicon.ico" />
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
                                        <h1>养殖池管理
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
                                                        <div class="portlet-title">
                                                            <div class="caption caption-md">
                                                                <i class="icon-bar-chart font-dark hide"></i>
                                                                <span class="caption-subject font-green-steel uppercase bold">养殖池列表</span>
                                                                <span class="caption-helper hide">weekly stats...</span>
                                                            </div>
                                                            <div class="actions">
                                                                <a href="javascript:" class="btn btn-primary btn-circle" data-role="add-pool"><i class="fa fa-plus"> 添加养殖池</i></a>
                                                            </div>
                                                        </div>
                                                        <div class="portlet-body">
                                                            <form class="form-inline" style="margin-bottom: 15px">
                                                                <div class="form-group">
                                                                    <select class="form-control" name="category_id">
                                                                        <option value="">养殖池分组</option>
                                                                        <?php if (!empty($categories)):?>
                                                                        <?php printCategoryTree($categories)?>
                                                                        <?php endif ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <select class="form-control" name="product_type_id">
                                                                        <option value="">产品种类</option>
                                                                        <?php if (!empty($product_types)):?>
                                                                        <?php foreach ($product_types as $product_type):?>
                                                                        <option value="<?=$product_type->id?>" <?php if ($_GET['product_type_id']==$product_type->id):?>selected<?php endif ?>><?=$product_type->name?></option>
                                                                        <?php endforeach;?>
                                                                        <?php endif ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <select class="form-control" name="status">
                                                                        <option value="">状态</option>
                                                                        <?php foreach ($status_names as $k => $v):?>
                                                                        <option value="<?=$k?>" <?php if ($_GET['status']==$k):?>selected<?php endif ?>><?=$v?></option>
                                                                        <?php endforeach;?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">循环水养殖池组</span>
                                                                        <input class="form-control" name="group_id" placeholder="循环水养殖池组ID" style="width: 100px" value="<?=$this->input->getString('group_id')?>">
                                                                    </div>

                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">ID</span>
                                                                        <input class="form-control" name="id" placeholder="养殖池ID" style="width: 100px" value="<?=$this->input->getString('id')?>">
                                                                    </div>

                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">名称</span>
                                                                        <input class="form-control" name="name" placeholder="养殖池名称" value="<?=$this->input->getString('name')?>">
                                                                    </div>

                                                                </div>
                                                                <button class="btn btn-primary">查询</button>
                                                                <button type="reset" onclick="window.location.href=window.location.pathname" class="btn btn-default">重置</button>
                                                                <span class="pull-right btn">共 <?=$result->total?> 条结果</span>
                                                            </form>
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered table-hover">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>ID</th>
                                                                        <th>名称</th>
                                                                        <th>分组</th>
                                                                        <th>循环水养殖池组</th>
                                                                        <th>产品种类</th>
                                                                        <th style="width: 30%">说明</th>
                                                                        <th>状态</th>
                                                                        <th>异常类型</th>
                                                                        <th>更新时间</th>
                                                                        <th>操作</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <?php if (!empty($result->list)):?>
                                                                        <?php foreach ($result->list as $item):
                                                                            ?>
                                                                            <tr data-item='<?=html_attr_json($item)?>'>
                                                                                <td><?=$item->id ?></td>
                                                                                <td><?=$item->name ?></td>
                                                                                <td><?=$item->category_name ?></td>
                                                                                <td><?=$item->group_name ?></td>
                                                                                <td><?=$item->product_type_name?>
                                                                                <td><?=$item->description?>
                                                                                <td class="<?=$status_classes[$item->status]?>"><?=$statuses[$item->status]?></td>
                                                                                <td><?=$exception_types[$item->exception_type]?></td>
                                                                                <td><?=$item->time_updated?></td>
                                                                                <td>
                                                                                    <div class="btn-group">
                                                                                        <a href="/farming/device/index?container_type=POOL&container_id=<?=$item->id?>" class="btn btn-xs btn-info"><i class="fa fa-cogs"></i> 设备管理</a>
                                                                                    </div>
                                                                                    <div class="btn-group">
                                                                                        <a href="/farming/pool/view?id=<?=$item->id?>" class="btn btn-xs btn-default"><i class="fa fa-eye"></i> 详情</a>
                                                                                        <a href="javascript:" class="btn  btn-default btn-xs" data-role="view-video"><i class="fa fa-video-camera"></i> 视频</a>
                                                                                        <a href="/farming/production-env/index?pool_id=<?=$item->id?>" class="btn  btn-default btn-xs"><i class="fa fa-cloud"></i> 环境</a>
                                                                                        <a href="/farming/pool/charts?id=<?=$item->id?>" class="btn  btn-default btn-xs"><i class="fa fa-line-chart"></i> 实时水质</a>
                                                                                    </div>
                                                                                    <div class="btn-group">
                                                                                        <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-default btn-xs" data-role="edit"><i class="fa fa-edit"></i> 编辑</a>
                                                                                        <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-default btn-xs" data-role="delete" data-id="<?=$item->id?>"><i class="fa fa-times"></i> 删除</a>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        <?php endforeach ?>
                                                                    <?php else:?>
                                                                        <tr>
                                                                            <td colspan="100" class="table-no-results">没有相关结果。</td>
                                                                        </tr>
                                                                    <?php endif ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                            <?=$pager?>
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
        <div class="modal fade" id="modal-form">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">编辑养殖池</h4>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="button" class="btn btn-primary ok">保存</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
<script type="text/html" id="tpl-form">
            <form class="form form-horizontal" method="post">
                <input type="hidden" name="id" value="<%=item.id%>">
                <div class="form-group">
                    <label class="control-label col-md-3">名称 <span class="required">*</span></label>
                    <div class="col-md-8">
                        <input class="form-control" name="name" value="<%=item.name%>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">分组 <span class="required">&nbsp;</span></label>
                    <div class="col-md-8">
                        <select class="form-control" name="category_id">
                            <?php if (!empty($categories)):?>
                            <option value="0">请选择</option>
                            <?php foreach ($categories as $category):?>
                                <option value="<?=$category->id?>" <% if (item.category_id==<?=$category->id?>) { %>selected<% } %>><?=$category->name?></option>
                            <?php endforeach;?>
                            <?php endif ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">循环水养殖池组 <span class="required">&nbsp;</span></label>
                    <div class="col-md-8">
                        <input class="form-control" name="group_id" <% if (<?=$this->input->getInt('group_id',0)?>) { %>readonly<% } %> value="<%=item.group_id?item.group_id:'<?=$this->input->getInt('group_id','')?>'%>" placeholder="填写养殖池组ID">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">产品种类 <span class="required">*</span></label>
                    <div class="col-md-8">
                        <select class="form-control" name="product_type_id">
                            <?php foreach ($product_types as $type):?>
                                <option value="<?=$type->id?>" <% if (item.product_type_id==<?=$type->id?>) { %>selected<% } %>><?=$type->name?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">状态 <span class="required">*</span></label>
                    <div class="col-md-8">
                        <select class="form-control" name="status">
                            <?php foreach ($statuses as $k => $status):?>
                            <option value="<?=$k?>" <% if (item.status==<?=$k?>) { %>selected<% } %>><?=$status?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
                <div class="form-group" <% if (item.status!=3) { %>style="display: none;"<% } %>>
                    <label class="control-label col-md-3">异常类型 <span class="required">&nbsp;</span></label>
                    <div class="col-md-8">
                        <select class="form-control" name="exception_type">
                            <option value="0"></option>
                            <?php foreach ($exception_types as $k => $type):?>
                                <option value="<?=$k?>" <% if (item.exception_type==<?=$k?>) { %>selected<% } %>><?=$type?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">说明 <span class="required">&nbsp;</span></label>
                    <div class="col-md-8">
                        <textarea name="description" class="form-control" rows="8"><%=item.description%></textarea>
                    </div>
                </div>
            </form>
</script>
<script type="text/html" id="tpl-video">
    <video id="my-video" class="video-js" controls preload="auto" width="<%=width%>" height="<%=height%>"
           data-setup='{"autoplay":true,"controls":false,"loop":true}'>
        <source src="/misc/src/pages/img/01.mp4" type='video/mp4'>
    </video>
</script>
<?=$this->region('common/scripts')?>
<script src="/misc/src/global/plugins/video.js/video.min.js"></script>
<script>
    $(function () {
        var $modal = $('#modal-form');
        $('[data-role=add-pool]').on('click', function () {
            $modal.find('.modal-body').html(tpl('tpl-form').render({item: {}}));
            $modal.find('[name=status]').on('change', function () {
                if ($(this).val() == 3) {
                    $modal.find('[name=exception_type]').parents('.form-group').show();
                } else {
                    $modal.find('[name=exception_type]').parents('.form-group').hide();
                }
            });
            $modal.modal();
        });
        $('[data-role=edit]').on('click', function () {
            var item = JSON.parse($(this).parents('tr').attr('data-item'));
            $modal.find('.modal-body').html(tpl('tpl-form').render({item: item}));
            $modal.find('[name=status]').on('change', function () {
                if ($(this).val() == 3) {
                    $modal.find('[name=exception_type]').parents('.form-group').show();
                } else {
                    $modal.find('[name=exception_type]').parents('.form-group').hide();
                }
            });
            $modal.modal();
        });
        $modal.find('.ok').on('click', function () {
            var id = $modal.find('[name=id]').val();
            $.ajax({
                url: '/farming/ajax/pool/' + (id ? 'update' : 'create'),
                data: $modal.find('form').serialize(),
                type: 'post',
                success: function (result) {
                    if (result.code === 'OK') {
                        layer.msg(result.message, function () {
                            window.location.reload();
                        });
                    } else {
                        layer.msg(result.message);
                    }
                }
            });
        });
        $('[data-role=delete]').on('click', function () {
            var id = $(this).attr('data-id');
            layer.confirm('您确定删除这条信息吗？', function () {
                $.ajax({
                    url: '/farming/ajax/pool/delete?id=' + id,
                    success: function (result) {
                        layer.msg(result.message, function () {
                            window.location.reload();
                        });
                    }
                });
            });
        });
        // 显示视频
        var videoSize = {width: 1280, height: 738};
        var windowWidth = $(window).width();
        $(document).on('click', '[data-role=view-video]', function () {
            var width = windowWidth > videoSize.width ? videoSize.width : windowWidth;
            width -= 30;
            var height = width * videoSize.height / videoSize.width;
            layer.open({
                type: 1,
                title: false,
                area: [width + 'px', height + 'px'],
                content: tpl('tpl-video').render({width: width, height: height}),
                success: function ($layer, index) {
                    videojs($layer.find('#my-video')[0]);
                }
            });
        });
    });
</script>
</body>

</html>