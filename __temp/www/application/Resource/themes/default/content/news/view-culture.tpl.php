<?=$this->region('common/head')?>
<?=$this->region('common/header')?>

<div class="mbxmenu center-block">
    <p>您的位置： <a href="">首页</a>>><a href=""><?=$title_m?></a><?php if($title_c != title_m):?>>><a href=""><?=$title_c ?></a><?php endif ?></p>
</div>

<div class="inner center-block">

<?php if (!empty($category->children)):?>
    <div class="innermune">
        <div class="innermuneheader">
            <img src="<?=$this->misc('web/img/tag.png')?>" alt="">
            <h1><?=$title_m?></h1>
        </div>
        <div class="innermunecon">
<?php foreach ($category->children as $item):?>
           <li class="">
                <a href="/content/news/culture?category_id=<?=$item->id?>&name=<?=$item->name?>">
                    <h1><?=$item->name?></h1>
                    <img src="<?=$this->misc('web/img/arrright.png')?>" alt="">
                </a>

            </li>
<?php endforeach;?>
 
        </div>
    </div>

<?php endif;?>

    <div class="innercontent">
        <div class="innercontenttitler">
            <p><?=$news->category_name?></p>
        </div>
        <div class="innercontentitem">
            <div class="innercontentitem10">
                <div class="whxccontant">
                    <h1> <?=$news->title?></h1>
                    <p>发布日期：<span><?=$news->time_published?></span>    总浏览量：<span><?=$news->hits?></span>  来源：<span><?=$news->source?></span> </p>
                </div>
                <div class="whxccontantcon whxccontantcon1">
				<?=$news->body?>
                </div>
            </div>

        </div>
    </div>
	
</div>
<?=$this->region('common/footer')?>
<?=$this->region('common/scripts')?>
</body>
</html>