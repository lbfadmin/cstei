<?=$this->region('common/head')?>
<?=$this->region('common/header')?>

<div class="mbxmenu center-block">
    <p>您的位置： <a href="">首页</a>>><a href="">产业文化</a><?php if($title != '产业文化'):?>>><a href=""><?=$title?></a><?php endif ?></p>
</div>

<div class="inner center-block">

				<?php if (!empty($category->children)):?>
    <div class="innermune">
        <div class="innermuneheader">
            <img src="<?=$this->misc('web/img/tag.png')?>" alt="">
            <h1>产业文化</h1>
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

<?php endif ?>
    <div class="innercontent">
        <div class="innercontenttitler">
            <p><?=$title?></p>
        </div>
		
<?php if (!empty($result->list)):?>
        <div class="innercontentitem">
            <div class="innercontentitem9">
				<?php foreach ($result->list as $item):?>

                <li class="listwz">
                    <a href="/content/news/culture-detail?id=<?=$item->id?>">
                        <dd></dd>
                        <p><?=$item->title?> </p>
                        <span><?=$item->time_published?></span>
                    </a>
                </li>
				<?php endforeach;?>
               

 
 
            </div>
            <div class="fy ">
                <div id="pageToolbar"> <?=$pager?></div>
            </div>

        </div>
<?php endif ?>
    </div>
</div>

<?=$this->region('common/footer')?>
<?=$this->region('common/scripts')?>
</body>
</html>