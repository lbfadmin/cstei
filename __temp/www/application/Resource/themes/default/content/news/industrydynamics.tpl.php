<?=$this->region('common/head')?>
<?=$this->region('common/header')?>

<div class="mbxmenu center-block">
    <p>您的位置： <a href="">首页</a>>><a href="">产业动态</a><?php if($title != '产业动态'):?>>><a href=""><?=$title?></a><?php endif ?></p>
</div>

<div class="inner center-block">

<?php if (!empty($result->list)):?>
    <div class="innermune">
        <div class="innermuneheader">
            <img src="<?=$this->misc('web/img/tag.png')?>" alt="">
            <h1>产业动态</h1>
        </div>
        <div class="innermunecon">
<?php foreach ($result->list as $item):?>

			<li class="">
                <a href="/content/news/industry-dynamics?id=<?=$item->id?>&name=<?=$item->title?>">
                    <h1><?=$item->title?></h1>
                    <img src="<?=$this->misc('web/img/arrright.png')?>" alt="">
                </a>

            </li>
<?php endforeach;?>
 
        </div>
    </div>

<?php endif ?>

<form class="form-inline" name="form-params">
<input type="hidden" name="name" value="<?=$info->title?>">

</form>
    <div class="innercontent innercontent1">
        <div class="innercontenttitler">
            <p><?=$info->title?></p>
        </div>
        <div class="innercontentitem">
            <div class="innercontentitem4">
               <div class="yubix">
                   <h1><?=$info->summary?></h1>
                   <img src="<?=$info->picture?>" alt="" style='width:80%;'>
                   <p style='font-family:微软雅黑;'>
				   <?=$info->body?>
				   </p>
               </div>
                <div class="zhexian">
                    <!--<img src="<?//=$this->misc('web/img/zhe.png')?>" alt="">-->
					<div id="chart-industrydynamics" class="chart" style='height:250px;'></div>
                    <dd></dd>
                </div>
                <div class="mingxi">
                    <div class="migncen">
                        <h1>2017年<?=$info->title?>全年产量明细</h1>
                        <p>单位：万吨</p>
						<table id="tblMain" style='width:100%; text-align:center'><tbody>
						<tr><td style='width:40%'>年月</td><td>产量(万吨)</td></tr>
						</tbody></table>
  
                    </div>
                </div>
            </div>


        </div>
    </div>
	

</div>

<?=$this->region('common/footer')?>
<?=$this->region('common/scripts')?>
<script src="/misc/src/global/plugins/echarts/echarts.min.js" type="text/javascript"></script>
<script src="/misc/src/web/js/industry-dynamics.js" type="text/javascript"></script>
</body>
</html>