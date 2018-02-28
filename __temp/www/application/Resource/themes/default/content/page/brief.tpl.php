<?=$this->region('common/head')?>
<?=$this->region('common/header')?>

<div class="mbxmenu center-block">
    <p>您的位置： <a href="">首页</a>>><a href="">体系简介</a>>><a href="">体系简介</a></p>
</div>

<div class="inner center-block">
 

	<?=$this->region('common/menu_brief')?>
    <div class="innercontent">
        <div class="innercontenttitler">
            <p><?=$page->title?></p>
        </div>
        <div class="innercontentitem">
            <div class="innercontentitem2">
                <?=$page->body?>
            </div>

        </div>
    </div>
</div>


<?=$this->region('common/footer')?>
<?=$this->region('common/scripts')?>
</body>
</html>