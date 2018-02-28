var Dashboard = function() {

    // 平台企业图表
    var initCompanyChart = function () {
        $.get('statistic/ajax/platform-company/get-list')
            .then(function (result) {
                var data = [];
                $.each(result.data.list, function (k, v) {
                    data.push(v.num_companies);
                });
                var options = {
                    color: ['#3398DB'],
                    tooltip : {
                        trigger: 'axis',
                        axisPointer : {
                            type : 'shadow'
                        }
                    },
                    grid: {
                        left: '3%',
                        right: '40',
                        bottom: '3%',
                        containLabel: true
                    },
                    xAxis : [
                        {
                            name: '月份',
                            type : 'category',
                            data : ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
                            axisTick: {
                                alignWithLabel: true
                            }
                        }
                    ],
                    yAxis : [
                        {
                            type : 'value',
                            name: '个数'
                        }
                    ],
                    series : [
                        {
                            name:'个数',
                            type:'bar',
                            barWidth: '60%',
                            data: data.reverse()
                        }
                    ]
                };
                var chart = echarts.init($('#chart-companies')[0]);
                chart.setOption(options);
            });
    };

    // 平台访问图表
    var initViewChart = function () {
        $.get('statistic/ajax/platform-view/get-list')
            .then(function (result) {
                var timelineData = [];
                var pvData = [];
                var uvData = [];
                $.each(result.data.list, function (k, v) {
                    timelineData.push(v.date);
                    pvData.push(v.num_pv);
                    uvData.push(v.num_uv);
                });
                var options = {
                    tooltip: {
                        trigger: 'axis'
                    },
                    legend: {
                        data:['访问量（PV）','访问用户（UV）']
                    },
                    grid: {
                        left: '3%',
                        right: '4%',
                        bottom: '3%',
                        containLabel: true
                    },
                    xAxis: {
                        type: 'category',
                        data: timelineData.reverse()
                    },
                    yAxis: {
                        type: 'value'
                    },
                    series: [
                        {
                            name:'访问量（PV）',
                            type:'line',
                            data: pvData.reverse(),
                            symbolSize: 5,
                            lineStyle: {
                                normal: {
                                    color: '#3398DB'
                                }
                            }
                        },
                        {
                            name:'访问用户（UV）',
                            type:'line',
                            data: uvData.reverse(),
                            symbol: 'diamond',
                            symbolSize: 5
                        }
                    ]
                };
                var chart = echarts.init($('#chart-views')[0]);
                chart.setOption(options);
            });
    };

    // 平台养殖产量图表
    var initOutputChart = function () {
        $.get('statistic/ajax/platform-output/get-list')
            .then(function (result) {
                var timelineData = [];
                var productTypes = {};
                var legends = [];
                var series = [];
                $.each(result.data.list, function (k, v) {
                    if ($.inArray(v.date, timelineData) === -1) {
                        timelineData.push(v.date);
                    }
                    if ($.inArray(v.product_type_name, legends) === -1) {
                        legends.push(v.product_type_name);
                    }
                    if (productTypes[v.product_type_id]) {
                        productTypes[v.product_type_id].data.push(v.num_output);
                    } else {
                        productTypes[v.product_type_id] = {
                            name: v.product_type_name,
                            type: 'line',
                            data: [v.num_output]
                        };
                    }
                });
                $.each(productTypes, function (k, v) {
                    v.data.reverse();
                    series.push(v);
                });
                var options = {
                    tooltip: {
                        trigger: 'axis'
                    },
                    legend: {
                        data: legends
                    },
                    grid: {
                        left: '3%',
                        right: '40',
                        bottom: '3%',
                        containLabel: true
                    },
                    xAxis: {
                        type: 'category',
                        data: timelineData.reverse(),
                        name: '月份'
                    },
                    yAxis: {
                        type: 'value',
                        name: '产量（万吨）'
                    },
                    series: series
                };
                var chart = echarts.init($('#chart-output')[0]);
                chart.setOption(options);
            });
    };

    // 平台财务图表
    var initFinanceChart = function () {
        $.get('statistic/ajax/platform-finance/get-list')
            .then(function (result) {
                var timelineData = [];
                var rechargeData = [];
                var consumeData = [];
                $.each(result.data.list, function (k, v) {
                    timelineData.push(v.date);
                    rechargeData.push(v.num_recharge);
                    consumeData.push(v.num_consume);
                });
                var options = {
                    tooltip: {
                        trigger: 'axis'
                    },
                    legend: {
                        data:['充值','消费']
                    },
                    grid: {
                        left: '3%',
                        right: '40',
                        bottom: '3%',
                        containLabel: true
                    },
                    xAxis: {
                        type: 'category',
                        data: timelineData.reverse(),
                        name: '月份'
                    },
                    yAxis: {
                        type: 'value',
                        name: '金额（万元）'
                    },
                    series: [
                        {
                            name:'充值',
                            type:'line',
                            data: rechargeData.reverse(),
                            symbolSize: 5,
                            lineStyle: {
                                normal: {
                                    color: '#3398DB'
                                }
                            }
                        },
                        {
                            name:'消费',
                            type:'line',
                            data: consumeData.reverse(),
                            symbol: 'diamond',
                            symbolSize: 5
                        }
                    ]
                };
                var chart = echarts.init($('#chart-finance')[0]);
                chart.setOption(options);
            });
    };

    return {

        init: function() {
            initCompanyChart();
            initOutputChart();
            initViewChart();
            initFinanceChart();
        }
    };

}();

if (App.isAngularJsApp() === false) {
    jQuery(document).ready(function() {
        Dashboard.init();
    });
}