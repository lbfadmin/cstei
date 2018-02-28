<!DOCTYPE html>
<html lang="zh">
<head>
    <title>智慧海洋平台</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <?=$this->region('common/styles')?>
    <link rel="stylesheet" href="<?=$this->misc('app/css/page.css')?>">
</head>
<body>
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
<?=$this->region('content/sidebar')?>
</div>
<?=$this->region('common/footer')?>
<?=$this->region('common/scripts')?>
</body>
</html>