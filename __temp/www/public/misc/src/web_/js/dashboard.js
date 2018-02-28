var Dashboard = function() {
    var initCompanyChart = function () {
 
        $.get('trace/ajax/production-env/industry')
            .then(function (result) {
                var data = [];
                $.each(result.data.list, function (k, v) {
                    data.push(v.num);
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
                            name: '鱼类',
                            type : 'category',
                            data : ['大菱鲆', '牙鲆', '半滑舌蹋', '大黄鱼', '石斑鱼', '海鲈鱼', '河魨', '卵形鲳鰺', '军曹鱼'],
                            axisTick: {
                                alignWithLabel: true
                            }
                        }
                    ],
                    yAxis : [
                        {
                            type : 'value',
                            name: '产量(万吨)'
                        }
                    ],
                    series : [
                        {
                            name:'产量(万吨)',
                            type:'bar',
                            barWidth: '60%',
                            data: data.reverse()
                        }
                    ]
                };
				// alert("123123123");
                var chart = echarts.init(document.getElementById('chart-companies'));
				
				// alert("23423423423");
                chart.setOption(options);
            });
    };


    return {

        init: function() {
            initCompanyChart();
        }
    };

}();

// if (App.isAngularJsApp() === false) {
    // jQuery(document).ready(function() {
        Dashboard.init();
    // });
// }