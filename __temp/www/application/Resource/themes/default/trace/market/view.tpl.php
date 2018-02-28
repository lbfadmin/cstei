<?php
$device_status_names = [
    'RUNNING' => '运行中', // 运行中
    'MAINTAIN' => '检查维修', // 检查维修
    'STOPPED' => '停止', // 停止
    'DOWN' => '故障', // 故障
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
    <title>养殖池管理 - <?=$_TPL['site_name']?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <?=$this->region('common/styles')?>
    <link rel="shortcut icon" href="favicon.ico" />
    <link type="text/css" rel="stylesheet" href="/misc/src/global/plugins/video.js/video-js.min.css">
    <style>
        td.name {color: #888; text-align: right; padding-right: 50px!important;}
        tr.legend td {font-weight: bold; background-color: #f3f3f3}
        .metrics {padding: 0 20px; margin-bottom: 40px; text-align: center; color: #fff}
        .metrics .wrapper {background-color: #72c200; height: 200px; padding-top: 20px}
        .metrics.status-alert .wrapper {background-color: #ffa903}
        .metrics .name {font-size: 24px;}
        .metrics .value {font-size: 42px; margin: 10px}
        .head-time {width: 300px; text-align: center; position: absolute; padding: 10px 0; left: 50%; margin-left: -150px; font-size: 24px}
        .related-batches li {padding-right: 10%; list-style: none}
        .related-batches .wrapper {border-bottom: 1px solid #e5e5e5; padding-bottom: 15px}
        .related-devices {text-align: center; line-height: 2}
        .related-devices li {list-style: none}
        .device-pic {width: 200px; height: 200px; background-repeat: no-repeat; background-position: center; background-size: contain; background-color: #eee; margin: auto; border:5px solid #ddd}
        .device-status-RUNNING {border-color: #72c200}
        .device-status-DOWN {border-color: red}
        .device-status-MAINTAIN {border-color: yellow}
    </style>
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
                                                <div class="portlet-title" style="position: relative">
                                                    <div class="caption caption-md">
                                                        <i class="icon-bar-chart font-dark hide"></i>
                                                        <span class="caption-subject font-green-steel uppercase bold">养殖池详情（养殖池：<?=$pool->name?>）</span>
                                                    </div>
                                                    <div class="head-time"><?=$env->time_created?></div>
                                                    <div class="actions">
                                                        <button class="btn btn-primary" data-role="view-video"><i class="fa fa-video-camera"></i> 实时视频</button>
                                                    </div>
                                                </div>
                                                <div class="portlet-body">
                                                    <div class="row">
                                                        <div class="col-md-2 metrics">
                                                            <div class="wrapper">
                                                                <div class="name">温度</div>
                                                                <div class="value"><?=$env->temperature ?: '--'?>℃</div>
                                                                <div class="actions"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 metrics status-alert">
                                                            <div class="wrapper">
                                                                <div class="name">溶解氧</div>
                                                                <div class="value"><?=$env->oxy ?: '--'?>mg/L</div>
                                                                <div class="actions"><button class="btn btn-danger" data-role="m-oxy"><i class="fa fa-cogs"></i> 需调氧</button></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 metrics">
                                                            <div class="wrapper">
                                                                <div class="name">PH</div>
                                                                <div class="value"><?=$env->ph ?: '--'?></div>
                                                                <div class="actions"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 metrics">
                                                            <div class="wrapper">
                                                                <div class="name">氨氮</div>
                                                                <div class="value"><?=$env->an ?: '--'?></div>
                                                                <div class="actions"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 metrics">
                                                            <div class="wrapper">
                                                                <div class="name">盐度</div>
                                                                <div class="value"><?=$env->salt ?: '--'?></div>
                                                                <div class="actions"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 metrics">
                                                            <div class="wrapper">
                                                                <div class="name">光照</div>
                                                                <div class="value"><?=$env->light ?: '--'?></div>
                                                                <div class="actions"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 metrics">
                                                            <div class="wrapper">
                                                                <div class="name">亚硝基氮</div>
                                                                <div class="value"><?=$env->nn ?: '--'?></div>
                                                                <div class="actions"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="portlet light related-batches">
                                                <div class="portlet-title">
                                                    <div class="caption caption-md">
                                                        <i class="icon-bar-chart font-dark hide"></i>
                                                        <span class="caption-subject font-green-steel uppercase bold">相关批次</span>
                                                    </div>
                                                </div>
                                                <div class="portlet-body">
                                                    <ul class="row">
                                                        <?php if (!empty($related_batches)):?>
                                                        <?php foreach ($related_batches as $batch_sn):?>
                                                        <li class="col-md-6">
                                                            <div class="wrapper">
                                                                &gt;&nbsp;批次 <?=$batch_sn?><a href="/farming/batch/trace?sn=<?=$batch_sn?>" class="pull-right">查看</a>
                                                            </div>
                                                        </li>
                                                        <?php endforeach;?>
                                                        <?php else :?>
                                                        <li class="no-data">暂无相关批次。</li>
                                                        <?php endif ?>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="portlet light related-devices">
                                                <div class="portlet-title">
                                                    <div class="caption caption-md">
                                                        <i class="icon-bar-chart font-dark hide"></i>
                                                        <span class="caption-subject font-green-steel uppercase bold">相关设备</span>
                                                    </div>
                                                </div>
                                                <div class="portlet-body">
                                                    <ul class="row">
                                                        <?php if (!empty($related_devices)):?>
                                                            <?php foreach ($related_devices as $device):?>
                                                                <li class="col-md-3">
                                                                    <div class="wrapper">
                                                                        <div><?=$device->type->name?></div>
                                                                        <div><?=$device->sn?></div>
                                                                        <div class="device-pic device-status-<?=$device->status?>" style="background-image: url(<?=$device->type->picture?>)"></div>
                                                                        <div>状态：<?=$device_status_names[$device->status]?></div>
                                                                        <div class="actions">
                                                                            <?php if ($device->status !== 'RUNNING'):?>
                                                                            <button class="btn btn-sm btn-danger" data-role="power-on" data-id="<?=$device->id?>"><i class="fa fa-power-off"></i> 开机</button>
                                                                            <?php else:?>
                                                                            <button class="btn btn-sm btn-warning" data-role="power-off" data-id="<?=$device->id?>"><i class="fa fa-power-off"></i> 关机</button>
                                                                            <?php endif ?>
                                                                            <div class="btn-group">
                                                                            <?php if (!empty($device->type->controllers)):?>
                                                                                <?php foreach ($device->type->controllers as $controller):?>
                                                                                <button class="btn btn-sm btn-info" data-role="controller-run"><i class="fa fa-play"></i> <?=$controller->action?></button>
                                                                                <?php endforeach ?>
                                                                            <?php endif ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            <?php endforeach;?>
                                                        <?php else :?>
                                                            <li class="no-data">无相关设备。</li>
                                                        <?php endif ?>
                                                    </ul>
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
<script type="text/html" id="tpl-m-oxy">
    <div class="exception-handler">
        <dl>
            <dt>工作设备<dt><dd>增氧机（OXY00001）</dd>
            <dt>工作进度</dt><dd>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0;">
                        0%
                    </div>
                </div>
            </dd>
        </dl>
    </div>
</script>
<script type="text/html" id="tpl-controller-run">
    <div class="exception-handler">
        <dl>
            <dt>工作进度</dt><dd>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0;">
                        0%
                    </div>
                </div>
            </dd>
        </dl>
    </div>
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
    // 调氧
    $(document).on('click', '[data-role=m-oxy]', function () {
        var $this = $(this);
        layer.open({
            type: 1,
            title: '调氧操作中……',
            area: ['350px'],
            content: tpl('tpl-m-oxy').render(),
            success: function ($layer, index) {
                var ps = 0;
                var timer = setInterval(function () {
                    ps += 20;
                    if (ps > 100) {
                        layer.close(index);
                        clearInterval(timer);
                        $this.parents('.metrics')
                            .removeClass('status-alert').addClass('status-ok')
                            .find('.exception').removeClass('exception').end()
                            .find('.actions').hide();
                        layer.msg('操作完成');
                        return;
                    }
                    $layer.find('.progress-bar').width(ps + '%').text(ps + '%');
                }, 1200);
            }
        });
    });
    // 通用设备操作
    $(document).on('click', '[data-role=controller-run]', function () {
        var $this = $(this);
        layer.open({
            type: 1,
            title: '操作进行中……',
            area: ['350px'],
            content: tpl('tpl-controller-run').render(),
            success: function ($layer, index) {
                var ps = 0;
                var timer = setInterval(function () {
                    ps += 20;
                    if (ps > 100) {
                        layer.close(index);
                        clearInterval(timer);
                        $this.parents('.metrics')
                            .removeClass('status-alert').addClass('status-ok')
                            .find('.exception').removeClass('exception').end()
                            .find('.actions').hide();
                        layer.msg('操作完成');
                        return;
                    }
                    $layer.find('.progress-bar').width(ps + '%').text(ps + '%');
                }, 1200);
            }
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

    $('[data-role=power-on]').on('click', function () {
        var id = $(this).attr('data-id');
        layer.confirm('您确定执行操作吗？', function () {
            $.ajax({
                url: '/farming/ajax/device/power-on?id=' + id,
                success: function (result) {
                    layer.msg(result.message, function () {
                        window.location.reload();
                    });
                }
            });
        });
    });
    $('[data-role=power-off]').on('click', function () {
        var id = $(this).attr('data-id');
        layer.confirm('您确定执行操作吗？', function () {
            $.ajax({
                url: '/farming/ajax/device/power-off?id=' + id,
                success: function (result) {
                    layer.msg(result.message, function () {
                        window.location.reload();
                    });
                }
            });
        });
    });
</script>
</body>

</html>