<!DOCTYPE HTML>
<html lang="<?=$_LANG?>">
<head>
    <title>批次查询 - 公众溯源</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?=$this->misc('vendor/bootstrap/3.3.7/css/bootstrap.min.css')?>">
    <link rel="stylesheet" href="<?=$this->misc('vendor/font-awesome/4.7.0/css/font-awesome.min.css')?>">
    <link rel="stylesheet" href="<?=$this->misc('vendor/jquery-raty/jquery.raty.css')?>">
    <link rel="stylesheet" href="<?=$this->misc('app/css/batch.css')?>">
</head>

<body>
<?=$this->region('trace/batch/header')?>
<div class="content-container">
<div class="page-content">
                        <div class="container-fluid">
                            <div class="page-content-inner">
                                <div class="mt-content-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="portlet light">
                                                <div class="portlet-body">
                                                    <form class="form-inline" name="form-params">
                                                        <input type="hidden" name="pool_id" value="<?=$pool->id?>">
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <span class="input-group-addon">选择年月</span>
                                                                <input class="form-control datetimepicker" name="created_start" placeholder="请选择" value="<?=date('Y-m-d 06:00', strtotime('-1 day'))?>">
                                                            </div>
                                                        </div>
                                                        <button class="btn btn-primary">确定</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="portlet light">
                                                <div class="portlet-title" style="position: relative">
                                                    <div class="caption caption-md">
                                                        <i class="icon-bar-chart font-dark hide"></i>
                                                        <span class="caption-subject font-green-steel uppercase bold">溶解氧</span>
                                                    </div>
                                                </div>
                                                <div class="portlet-body">
                                                    <div id="chart-oxy" class="chart"></div>
                                                </div>
                                            </div>
                                        </div>
                                  
                                    </div>
                                </div>
                            </div>
                        </div>
</div>
</div>

<link href="/misc/src/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
<?=$this->region('common/scripts')?>
<script src="<?=$this->misc('vendor/echarts/echarts.min.js')?>" type="text/javascript"></script>
<script src="<?=$this->misc('vendor/market/charts.js')?>"></script>
</body>
</html>


