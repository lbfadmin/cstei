<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html>
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>控制面板 - <?=$_TPL['site_name']?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <?=$this->region('common/styles')?>
        <link rel="shortcut icon" href="favicon.ico" />
        <style>
            .chart {height: 250px}
        </style>
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
                    <h1 class="page-title"> 控制面板
                        <small>统计、图表、报告等</small>
                    </h1>
                    <!-- END PAGE HEADER-->
                    <div class="row">

                        <div class="col-md-6 col-sm-12">
                            <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <span class="caption-subject bold uppercase font-dark">平台日常访问量</span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div id="chart-views" class="chart"></div>
                                </div>
                            </div>
                        </div>
  
  <!--                      <div class="col-md-6 col-sm-12">
                            <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <span class="caption-subject bold uppercase font-dark">智慧云平台财务图表</span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div id="chart-finance" class="chart"></div>
                                    <style>
                                    .chart {
                                        height: 250px;
                                    }
                                    </style>
                                </div>
                            </div>
                        </div>-->
                    </div>
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->
        <?=$this->region('common/footer')?>
        <?=$this->region('common/scripts')?>
            <!-- BEGIN PAGE LEVEL PLUGINS -->
            <script src="/misc/src/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
            <!-- END PAGE LEVEL PLUGINS -->
            <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="/misc/src/global/plugins/echarts/echarts.min.js" type="text/javascript"></script>
    <script src="/misc/src/pages/scripts/dashboard.js" type="text/javascript"></script>
            <!-- END PAGE LEVEL SCRIPTS -->
    </body>

</html>