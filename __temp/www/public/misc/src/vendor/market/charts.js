/**
 * Created by kevin on 17-5-2.
 */
(function () {

    var renderCharts = function () {
        var params = $('form[name=form-params]').serialize();
        $.get('/trace/ajax/production-env/get-all', params)
            .then(function (result) {
                var timelineData = [];
                var series = {
                    oxy: {
                        legend: '批发价格',
                        unit: '元/斤',
                        data: []
                    }
				}
                $.each(result.data.list, function (k, v) {
					alert(v.time_created);
                    timelineData.push(v.time_created);
                    series.oxy.data.push(v.retail_price);
                });
                timelineData.reverse();
                $.each(series, function (k, v) {
                    var options = {
                        tooltip: {
                            trigger: 'axis'
                        },
                        legend: {
                            data:[v.legend]
                        },
                        grid: {
                            left: '10%',
                            right: '10%',
                            bottom: '10%',
                            containLabel: true
                        },
                        xAxis: {
                            type: 'category',
                            name: '时间',
                            data: timelineData
                        },
                        yAxis: {
                            type: 'value',
                            name: v.unit || ''
                        },
                        series: [
                            {
                                name: v.legend,
                                type: 'line',
                                data: v.data.reverse(),
                                lineStyle: {
                                    normal: {
                                        color: '#3398DB'
                                    }
                                }
                            }
                        ]
                    };
                    var chart = echarts.init($('#chart-' + k)[0]);
                    chart.setOption(options);
                });
            });
    };

    renderCharts();

   $('.datetimepicker').datetimepicker({
		language: 'zh-CN',
		format: 'yyyy-mm',
		weekStart: 1,
		todayBtn: 1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 3, //这里就设置了默认视图为年视图
		minView: 3, //设置最小视图为年视图
		forceParse: 0,
        autoclose: true
		
    });

    $('form[name=form-params]').on('submit', function () {
        renderCharts();
        return false;
    });
})();