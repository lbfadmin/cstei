<?=$this->region('common/head')?>
<?=$this->region('common/header')?>

<div class="banner">
    <div class="banner-content"><span class="text"><?=$title?></span></div>
</div>
<div class="body">
    <div class="body-main">
        <div class="wrapper">
            <h2 class="body-title"><?=$page->title?></h2>
            <div class="body-content">
                <?=$page->body?>
            </div>
        </div>
    </div>

</div>
<?=$this->region('common/footer')?>
<?=$this->region('common/scripts')?>
</body>
</html>