<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html>
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>抽检管理 - <?=$_TPL['site_name']?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <?=$this->region('common/styles')?>
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
                                        <h1>抽检管理
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
                                                                <span class="caption-subject font-green-steel uppercase bold">抽检</span>
                                                            </div>
                                                            <div class="actions">
                                                                <a class="btn btn-circle btn-primary" href="javascript:" data-role="add">
                                                                    <i class="fa fa-plus"> 添加抽检</i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="portlet-body">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered table-hover">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>ID</th>
                                                                        <th>批次号</th>
                                                                        <th>取样信息</th>
                                                                        <th>取样人</th>
                                                                        <th>取样地点</th>
                                                                        <th>检测结果</th>
                                                                        <th>状态</th>
                                                                        <th>操作</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <?php if (!empty($result->list)):?>
                                                                        <?php foreach ($result->list as $item):
                                                                            ?>
                                                                            <tr data-item='<?=html_attr_json($item)?>'>
                                                                                <td><?=$item->id ?></td>
                                                                                <td><a href="/farming/batch/index?sn=<?=$item->batch_sn?>"><?=$item->batch_sn ?></a> </td>
                                                                                <td>
                                                                                    <?=$item->sampling?>
                                                                                </td>
                                                                                <td><?=$item->operator ?></td>
                                                                                <td><?=$item->position ?></td>
                                                                                <td><?=$item->results ?></td>
                                                                                <td><?=$statuses[$item->status] ?></td>
                                                                                <td>
                                                                                    <div class="btn-group">
                                                                                        <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-default btn-xs" data-role="edit"><i class="fa fa-edit"></i> 编辑</a>
                                                                                        <a href="javascript:" data-toggle="tooltip" title="" class="btn btn-default btn-xs" data-role="delete" data-id="<?=$item->id?>"><i class="fa fa-times"></i> 删除</a>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                                                        <?php endforeach ?>
                                                                    <?php endif ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div><?=$pager?></div>
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
                        <h4 class="modal-title">编辑设备</h4>
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
            <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">

                <input type="hidden" name="id" value="<%=item.id%>">
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-text-input">批次号 <span class="text-danger">*</span></label>
                    <div class="col-md-8">
                        <input type="text" name="batch_sn" class="form-control" placeholder="" value="<%=item.batch_sn%>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-text-input">取样信息 <span class="text-danger">*</span></label>
                    <div class="col-md-8">
                        <input type="text" name="sampling" class="form-control" placeholder="" value="<%=item.sampling%>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-text-input">取样人 <span class="text-danger">*</span></label>
                    <div class="col-md-8">
                        <input type="text" name="operator" class="form-control" placeholder="" value="<%=item.operator%>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-text-input">取样地点 <span class="text-danger">*</span></label>
                    <div class="col-md-8">
                        <input type="text" name="position" class="form-control" placeholder="" value="<%=item.position%>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-text-input">取样时间 <span class="text-danger">*</span></label>
                    <div class="col-md-8">
                        <input type="text" name="time_taken" class="form-control" placeholder="如：2016-10-10 10:10" value="<%=item.time_taken%>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="example-text-input">检测结果 <span class="text-danger">*</span></label>
                    <div class="col-md-8">
                        <input type="text" name="results" class="form-control" placeholder="" value="<%=item.results%>">
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
            </form>
        </script>
        <?=$this->region('common/scripts')?>
        <script>
            $(function () {
                var $modal = $('#modal-form');
                $('[data-role=add]').on('click', function () {
                    $modal.find('.modal-body').html(tpl('tpl-form').render({item: {}}));
                    $modal.modal();
                });
                $('[data-role=edit]').on('click', function () {
                    var item = JSON.parse($(this).parents('tr').attr('data-item'));
                    $modal.find('.modal-body').html(tpl('tpl-form').render({item: item}));
                    $modal.modal();
                });
                $modal.find('.ok').on('click', function () {
                    var id = $modal.find('[name=id]').val();
                    var loading = layer.load();
                    $.ajax({
                        url: '/farming/ajax/check/' + (id ? 'update' : 'create'),
                        data: $modal.find('form').serialize(),
                        type: 'post',
                        success: function (result) {
                            layer.close(loading);
                            layer.msg(result.message, function () {
                                window.location.reload();
                            });
                        }
                    });
                });
                $('[data-role=delete]').on('click', function () {
                    var $this = $(this),
                        id = $this.attr('data-id');
                    layer.confirm('您确定要删除这条记录吗？', function () {
                        $.ajax({
                            url: '/farming/ajax/check/delete',
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