<?php
$_categoryId = $this->input->getInt('category_id', 0);
function printTree($data, $categoryId) {
    global $_categoryId;
    static $depth = 0;
    foreach ($data as $k => $item) {
        ?>
        <option value="<?=$item->id?>" <?php if ($item->id == $_categoryId):?>selected<?php endif ?>>
            <?php echo str_repeat('　　', $depth); ?><?=$item->name; ?>
        </option>
        <?php
        if ($item->children) {
            $depth++;
            printTree($item->children, $categoryId);
        }
    }
    $depth--;
}
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
    <title>资讯管理 - <?=$_TPL['site_name']?></title>
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
            <h1 class="page-title"> 资讯管理
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
                        <a href="javascript:">资讯管理</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <i class="fa fa-list"></i>
                        <a href="javascript:">列表</a>
                    </li>
                </ul>
            </div>

            <?=render_message() ?>
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject font-dark bold">资讯列表</span>
                    </div>
                    <div class="actions">
                        <a class="btn btn-circle btn-primary" href="<?=url('content/info/info/add') ?>">
                            <i class="fa fa-plus"> 添加资讯</i>
                        </a>
                    </div>
                </div>
<div class="form-group">

<form class="form-inline" style="margin-bottom: 15px">
	<label class="col-md-2 control-label" for="example-text-input">类别 </label>
	<div class="col-md-4">
		<select name="category_id" class="form-control" style="width: 100%">
			<option value="" selected>&nbsp;</option>
			<?php printTree($categories, empty($item)?0:$item->category_id)?>
		</select>
	</div>
	<label class="col-md-2 control-label" for="example-text-input">标题</label>
	<div class="col-md-4">
		<input  type="text" name="title" placeholder="请输入文章标题" value="" />

	<button class="btn btn-primary">查询</button>
	<button type="reset" onclick="window.location.href=window.location.pathname" class="btn btn-default">重置</button>
	<span class="pull-right btn">共 <?=$result->total?> 条结果</span>
</form>
</div>
                <div class="portlet-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th width="5%">ID</th>
                            <th>分类</th>
                            <th width="40%">标题</th>
                            <th width="10%">发布时间/序号</th>
                            <th width="10%">状态</th>
                            <th width="10%">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($result->list)):?>
                            <?php foreach ($result->list as $item):
                                $classes = [
                                    'DRAFT' => 'warning',
                                    'PUBLISHED' => 'info',
                                    'OFFLINE' => 'default'
                                ];
                                ?>
                                <tr>
                                    <td><?=$item->id ?></td>
                                    <td><?=$item->category_name?></td>
                                    <td>
                                        <div style="background-image: url(<?=$item->picture?>);width: 60px;height:60px;background-position: center;background-size: cover;float: left;border:1px solid #eee">
                                        </div>
                                        <h4 style="margin-left: 70px; font-size: 15px;"><?=$item->title ?></h4>
                                        <div style="margin-left: 70px;color:#999; font-size: 12px;"><?=mb_substr($item->summary, 0, 100)?></div>
                                    </td>
                                    <td><?=$item->time_published ?><br><?=$item->sort_num ?></td>
                                    <td><span><?=$statuses[$item->status]?></span></td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="/content/info/info/edit?id=<?=$item->id?>" data-toggle="tooltip" title="" class="btn btn-default btn-xs" ><i class="fa fa-edit"></i> 编辑</a>
                                            <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-default btn-xs" data-role="delete" data-id="<?=$item->id?>"><i class="fa fa-times"></i> 删除</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                        </tbody>
                    </table>
                    <div><?=$pager?></div>
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
<script>
    $(function () {
        $('[data-role=delete]').on('click', function () {
            var $this = $(this),
                id = $this.attr('data-id');
            layer.confirm('您确定要删除这条资讯吗？', function () {
                $.ajax({
                    url: '/content/ajax/info/info/delete',
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