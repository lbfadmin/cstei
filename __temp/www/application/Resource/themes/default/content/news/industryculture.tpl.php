<?=$this->region('common/head')?>
<?=$this->region('common/header')?>

<div class="mbxmenu center-block">
    <p>您的位置： <a href="">首页</a>>><a href="">产业文化</a><?php if($title != '产业文化'):?>>><a href=""><?=$title?></a><?php endif ?></p>
</div>

<div class="inner center-block">

<?php if (!empty($categories->children)):?>
    <div class="innermune">
        <div class="innermuneheader">
            <img src="<?=$this->misc('web/img/tag.png')?>" alt="">
            <h1>产业文化</h1>
        </div>
        <div class="innermunecon">
<?php foreach ($categories->children as $item):?>

			<li class="">
                <a href="/content/news/industry-culture?category_id=<?=$item->id?>&name=<?=$item->name?>">
                    <h1><?=$item->name?></h1>
                    <img src="<?=$this->misc('web/img/arrright.png')?>" alt="">
                </a>

            </li>

<?php endforeach;?>
 
        </div>
    </div>

<?php endif ?>

	<!--文化产业列表-->
    <div class="innercontent">
        <div class="innercontenttitler">
            <p><?=$title?></p>
        </div>
		
<?php if (!empty($result->list)):?>
        <div class="innercontentitem">
            <div class="innercontentitem9">
				<?php foreach ($result->list as $item):?>

                <li class="listwz">
                    <a href="/content/news/industry-culture?id=<?=$item->id?>">
                        <dd></dd>
                        <p><?=$item->title?> </p>
                        <span><?=$item->time_published?></span>
                    </a>
                </li>
				<?php endforeach;?>
   
            </div>
            <div class="fy " style='display:none;'>
                <div id="pageToolbar"> <?=$pager?></div>
            </div>

        </div>
<?php endif ?>
<?php if (!empty($info)):?>
        <div class="innercontenttitler">
            <p><?=$info->category_name?></p>
        </div>	
       <div class="innercontentitem">
            <div class="innercontentitem10">
                <div class="whxccontant">
                    <h1> <?=$info->title?></h1>
                    <p>发布日期：<span><?=$info->time_published?></span>    总浏览量：<span><?=$info->hits?></span>  来源：<span><?=$info->source?></span> </p>
                </div>
                <div class="whxccontantcon whxccontantcon1">
				<?=$info->body?>
                </div>
            </div>

        </div>
<?php endif ?>
    </div>
</div>

<?=$this->region('common/footer')?>
<?=$this->region('common/scripts')?>
<script src="/misc/src/global/plugins/echarts/echarts.min.js" type="text/javascript"></script>
<script src="/misc/src/web/js/industry-dynamics.js" type="text/javascript"></script>
</body>
</html>