<?=$this->region('common/head')?>
<?=$this->region('common/header')?>

<div class="mbxmenu center-block">
    <p>您的位置： <a href="">首页</a>>><a href="">体系简介</a>>><a href="">专家介绍</a></p>
</div>

<div class="inner center-block">

	<?=$this->region('common/menu_brief')?>
    <div class="innercontent">
        <div class="innercontenttitler">
            <p><?=$page->title?></p>
        </div>
        <div class="innercontentitem">
            <div class="innercontentitem2">

   <!--Step:2 Prepare a dom for ECharts which (must) has size (width & hight)-->
    <!--Step:2 为ECharts准备一个具备大小（宽高）的Dom-->
    <div id="mapChart" style="width:1000px;height:500px;border:solid 1px #ccc;padding:10px;margin:100px auto 10px;"></div>
    <div style="width:1000px;margin:0 auto;"><a href="#" onclick="refresh();return false;" style="color:#fff;">点击刷新</a></div>
    
    <script type="text/javascript">
    // Step:3 conifg ECharts's path, link to echarts.js from current page.
    // Step:3 为模块加载器配置echarts的路径，从当前页面链接到echarts.js，定义所需图表路径
    require.config({
        paths:{ 
            echarts:'./js/echarts',
            'echarts/chart/map' : './js/echarts-map'
        }
    });

    var echarts;
    var mapChart;
    var map;

    function init(){
        map = document.getElementById('mapChart');
        require(
            [
                'echarts',
                'echarts/chart/map'
            ],
            requireCallback
        );
    }

    function requireCallback(ec){
        echarts = ec;
        mapChart = echarts.init(map);
        refresh();
    }

    function refresh(){
        if (mapChart && mapChart.dispose) {
            mapChart.dispose();
        }
        mapChart = echarts.init(map);
        var options = getoptions();
        mapChart.setOption(options,true);
    }

    window.onload = init;

    function getoptions(){
 options = {
    title : {
        text: '全国主要城市空气质量（pm2.5）',
        subtext: 'data from PM25.in',
        sublink: 'http://www.pm25.in',
        x:'center'
    },
    tooltip : {
        trigger: 'item'
    },
    legend: {
        orient: 'vertical',
        x:'left',
        data:['pm2.5']
    },
    dataRange: {
        min : 0,
        max : 500,
        calculable : true,
        color: ['maroon','purple','red','orange','yellow','lightgreen']
    },
    toolbox: {
        show : true,
        orient : 'vertical',
        x: 'right',
        y: 'center',
        feature : {
            mark : {show: true},
            dataView : {show: true, readOnly: false},
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
    series : [
        {
            name: 'pm2.5',
            type: 'map',
            mapType: 'china',
            hoverable: false,
            roam:true,
            data : [],
            markPoint : {
                symbolSize: 5,       // 标注大小，半宽（半径）参数，当图形为方向或菱形则总宽度为symbolSize * 2
                itemStyle: {
                    normal: {
                        borderColor: '#87cefa',
                        borderWidth: 1,            // 标注边线线宽，单位px，默认为1
                        label: {
                            show: false
                        }
                    },
                    emphasis: {
                        borderColor: '#1e90ff',
                        borderWidth: 5,
                        label: {
                            show: false
                        }
                    }
                },
                data : [
                  
                    {name: "大庆", value: 279}
                ]
            },
            geoCoord: {
               
                "大庆":[125.03,46.58]
            }
        },
        {
            name: 'Top5',
            type: 'map',
            mapType: 'china',
            data:[],
            markPoint : {
                symbol:'emptyCircle',
                symbolSize : function (v){
                    return 10 + v/100
                },
                effect : {
                    show: true,
                    shadowBlur : 0
                },
                itemStyle:{
                    normal:{
                        label:{show:false}
                    }
                },
                data : [
                    
                    {name: "大庆", value: 279}
                ]
            }
        }
    ]
};
                    
        return options;

    }
    
    
        mapChart = echarts.init(map);
        var options = getoptions();
        mapChart.setOption(options,true);
    </script>


            </div>


        </div>
    </div>
</div>


<?=$this->region('common/footer')?>
<?=$this->region('common/scripts')?>
</body>
</html>