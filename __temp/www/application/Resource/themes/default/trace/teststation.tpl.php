<?=$this->region('common/head')?>
<?=$this->region('common/header')?>

<div class="mbxmenu center-block">
    <p>您的位置： <a href="">首页</a>>><a href="">体系简介</a>>><a href="">专家介绍</a></p>
</div>

<div class="inner center-block">
  

	<?=$this->region('common/menu_brief')?>
	
    <div class="innercontent">
        <div class="innercontenttitler">
            <p>试验站</p>
        </div>
        <div class="innercontentitem">
            <div class="innercontentitem1">
                <h1><?=$page->name?></h1>
				<div class="innercontentitem2" style="overflow:hidden;">
					<div id="mapChart" style="width:50%; height:450px;border:solid 0px #ccc;padding:10px;margin:0 auto;float:left;"></div>
					<input type='hidden' id="name" value="<?=$page->name?>" />
					<input type='hidden' id="lat" value="<?=$page->lat?>" />
					<input type='hidden' id="lng" value="<?=$page->lng?>" />
					<div style='float:right;overflow:hidden;width:50%'>
					<!--<?=$page->body?>-->
						<p>试验站长：<?=$page->holders?></p>
						<br>
						<p><?=$page->description?><br>
						<a href="/content/page/test-station-detail?id=<?=$pid?>">进入试验站</a></p>
						
					</div>
				</div>                
	<!--			<img src="img/map.png" alt="">
                <p>站长：杨长更，52岁，学士，研究员</p>
                <div>
                    <p>介绍：</p>
                    <div>
                        <p>北戴河中心实验站是中国水产科学研究院所属的面向渤海的国家级大型增殖实
                            验站。其建站宗旨是增殖渤海水产资源，提高渤海水域生产力，振兴渤海渔业
                            经济，主要任务是开展渔业资源增殖实验、良种选育研究和学术交流服务工作。</p>
                        <p>北戴河站现有职工37人，其中专业技术人员18人，研究员1人，客座研究员2
                            人，副高级专业技术职务8人，中级专业技术职务4人。站内设有4个职能科室，
                            2个业务研究科室，2个研究中心，并在昌黎和乐亭建有2个科技成果中试转化
                            基地。</p>
                        <p>北戴河站占地面积66亩，建有育种实验室、种苗培育中试车间、饵料培育室，
                            总规模3000立方米，拥有日本政府无偿援助的各类大型科研仪器设备21台(套)，
                            并配套建设了学员教室、宿舍、教学演示设备等。</p>
                    </div>
                </div>-->
            </div>


        </div>
    </div>

</div>


<?=$this->region('common/footer')?>
<?=$this->region('common/scripts')?>

<script src='<?=$this->misc('vendor/teststation/esl.js')?>'></script>
<script src='<?=$this->misc('vendor/teststation/echarts.js')?>'></script>
<script src='<?=$this->misc('vendor/teststation/echarts-map.js')?>'></script>
<script src='<?=$this->misc('vendor/teststation/teststation.js')?>'></script>


</body>
</html>

