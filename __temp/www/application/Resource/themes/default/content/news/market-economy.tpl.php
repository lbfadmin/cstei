<?=$this->region('common/head')?>
<?=$this->region('common/header')?>

<div class="mbxmenu center-block">
    <p>您的位置： <a href="">首页</a>>><a href="">市场经济</a><?php if($title != '市场经济'):?>>><a href=""><?=$title?></a><?php endif ?></p>
</div>

<div class="inner center-block">

<?php if (!empty($categories->list)):?>
    <div class="innermune">
        <div class="innermuneheader">
            <img src="<?=$this->misc('web/img/tag.png')?>" alt="">
            <h1>市场经济</h1>
        </div>
        <div class="innermunecon">
<?php foreach ($categories->list as $item):?>

			<li class="">
                <a href="/content/news/market-economy?id=<?=$item->id?>&name=<?=$item->name?>">
                    <h1><?=$item->name?></h1>
                    <img src="<?=$this->misc('web/img/arrright.png')?>" alt="">
                </a>

            </li>

<?php endforeach;?>
 
        </div>
    </div>

<?php endif ?>
    <div class="innercontent">
        <div class="innercontenttitler">
            <p><?=$title?></p>
			 
        </div>
<form class="form-inline" name="form-params">
<input type="hidden" name="id" value="<?=$id?>">
<!--<div class="form-group">
	<div class="input-group">
		<span class="input-group-addon">选择时间</span>
		<input class="form-control datetimepicker" name="created_start" placeholder="请选择" value="<?=date('Y-m-d 06:00', strtotime('-1 day'))?>">
		<span class="input-group-addon">至</span>
		<input class="form-control datetimepicker" name="created_end" placeholder="请选择">
	</div>
</div>
<button class="btn btn-primary">确定</button>-->
</form>
		<div id="chart-oxy" class="chart" style="width:600px;height:400px;"></div>

    </div>
</div>

<?=$this->region('common/footer')?>
<?=$this->region('common/scripts')?>
<script src="<?=$this->misc('global/plugins/echarts/echarts.min.js')?>"></script>
<script src="<?=$this->misc('web/js/pool.charts.js')?>"></script>
</body>
</html>