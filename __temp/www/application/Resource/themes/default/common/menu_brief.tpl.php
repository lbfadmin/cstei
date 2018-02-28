 <div class="innermune">
        <div class="innermuneheader">
           <img src="<?=$this->misc('web/img/tag.png')?>" alt="">
            <h1>体系简介</h1>
        </div>
        <div class="innermunecon">
            <li class="more ">
                <!----><a href="/content/page/brief?id=37">
               
                    <h1>体系简介</h1>
                    <img src="<?=$this->misc('web/img/arrright.png')?>" alt="">   
	 </a>				
<!--				<?php if (!empty($systembrief->list)):?>
					<ul class="childerenul" style="/*display:none*/">
					
					<?php foreach ($systembrief->list as $item):?>
						<li><a href="/content/page/brief?id=<?=$item->id?>"><?=$item->title?></a></li>
					<?php endforeach;?>
				 </ul>
				<?php endif ?>-->

            </li>
            <li class="more ">
            
                    <h1>专家介绍</h1>
                    <img src="<?=$this->misc('web/img/arrright.png')?>" alt="">
				<?php if (!empty($expertteam->list)):?>
					<ul class="childerenul" style="display:none/**/">
					
					<?php foreach ($expertteam->list as $item):?>
						<li><a href="/content/page/test-station-detail?id=<?=$item->id?>"><?=$item->title?></a></li>
					<?php endforeach;?>
				 </ul>
				<?php endif ?>
                
            </li>
            <li class="more ">
                <h1>试验站</h1>
                <img src="<?=$this->misc('web/img/arrright.png')?>" alt="">
				<?php if (!empty($teststation->list)):?>
					<ul class="childerenul" style="display:none/**/">
					
					<?php foreach ($teststation->list as $item):?>
						<li><a href="/content/page/test-station?id=<?=$item->id?>&name=<?=$item->title?>"><?=$item->title?></a></li>
						<!--<li><a href="/content/page/test-station-detail?id=<?=$item->id?>"><?=$item->title?></a></li>-->
					<?php endforeach;?>
				 </ul>
				<?php endif ?>
            </li>
        </div>
    </div>