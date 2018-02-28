var Dashboard = function() {

   // 产业动态图表
    var initIndustryChart = function () {
    var params = $('form[name=form-params]').serialize();
	// alert(params);
	// return;
	//location.href='/trace/ajax/production-env/industry-dynamics?'+params;return;
        $.get('/trace/ajax/production-env/industry-dynamics',params )
            .then(function (result) {
                var timelineData = [];
                var rechargeData = [];
				var table = document.getElementById("tblMain");
				// alert(result.data.list);
				// return;
                $.each(result.data.list, function (k, v) {
					// alert(v.date);
					
					timelineData.push(v.date);
					rechargeData.push(v.amount);


					var tr = document.createElement("tr");
					var td1 = document.createElement("td");
					td1.innerText = v.date;
					tr.appendChild(td1);
					var td2 = document.createElement("td");
					td2.innerHTML = v.amount;
					tr.appendChild(td2);
					table.tBodies[0].appendChild(tr);
                });
                var options = {
                    tooltip: {
                        trigger: 'axis'
                    },
                    legend: {
                        data:['产量']
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
                        name: '万吨'
                    },
                    series: [
                        {
                            name:'产量',
                            type:'line',
                            data: rechargeData.reverse(),
                            symbolSize: 5,
                            lineStyle: {
                                normal: {
                                    color: '#3398DB'
                                }
                            }
                        }
                    ]
                };
                var chart = echarts.init(document.getElementById('chart-industrydynamics'));
                chart.setOption(options);
            });
    };

    return {

        init: function() {
            initIndustryChart();
        }
    };

}();

Dashboard.init();
