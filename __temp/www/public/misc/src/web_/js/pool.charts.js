/**
 * Created by kevin on 17-5-2.
 */
(function () {

    var renderCharts = function () {
        var params = $('form[name=form-params]').serialize();

        $.get('/trace/ajax/production-env/market-economy', params)

            .then(function (result) {
	

                var timelineData = [];
                var series = {
                    oxy: {
                        legend: '市场价格',
                        unit: '元/公斤',
                        data: []
                    }
                };
				//alert("bbb");
                $.each(result.data.list, function (k, v) {
					
				//
                     timelineData.push(v.time_created);
                     series.oxy.data.push(v.trade_price);
           
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
                            left: '3%',
                            right: '5%',
                            bottom: '3%',
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
				//	alert("bbb");
                   // var chart = echarts.init($('#chart-' + k)[0]);
                var chart = echarts.init(document.getElementById('chart-oxy'));
                    chart.setOption(options);
                });
  /**/
            });
    };

    renderCharts();

    // $('.datetimepicker').datetimepicker({
        // language: 'zh-CN',
        // autoclose: true
    // });

    // $('form[name=form-params]').on('submit', function () {
        // renderCharts();
        // return false;
    // });
})();