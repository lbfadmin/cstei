<!DOCTYPE HTML>
<html lang="<?=$_LANG?>">
<head>
    <title>批次查询 - 公众溯源</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?=$this->misc('vendor/bootstrap/3.3.7/css/bootstrap.min.css')?>">
    <link rel="stylesheet" href="<?=$this->misc('vendor/font-awesome/4.7.0/css/font-awesome.min.css')?>">
    <link rel="stylesheet" href="<?=$this->misc('vendor/jquery-raty/jquery.raty.css')?>">
    <link rel="stylesheet" href="<?=$this->misc('app/css/batch.css')?>">
</head>

<body>
<?=$this->region('trace/batch/header')?>
<div class="content-container">
    <form class="form form-inline form-search">
        <div class="title">公共溯源查询</div>
        <div class="form-group form-group-lg">
            <input class="form-control" name="sn" placeholder="请输入商品批次号" value="<?=$batch_sn?>">
        </div>
        <button type="submit" class="btn btn-lg">查询</button>
    </form>
    <?php if (!empty($batch_sn)):?>
    <div class="search-result">
        <div class="title">批次 <?=$batch_sn?> 查询结果请扫描二维码或点击链接访问</div>
        <?php $url = url('trace/batch/' . $batch_sn, ['absolute' => true]); ?>
        <div class="search-contents">
            <?php if (!empty($batch)):?>
            <div class="link">
                <a href="<?=$url?>"><?=$url?></a>
            </div>
            <img src="/common/qr-code/make?text=<?=$url?>">
            <?php else:?>
            <div class="empty-result">没有批次的相关信息。</div>
            <?php endif ?>
        </div>
    </div>
    <?php endif ?>
</div>
<script src="<?=$this->misc('vendor/jquery/jquery.min.js')?>" type="text/javascript"></script>
<script src="<?=$this->misc('vendor/bootstrap/3.3.7/js/bootstrap.min.js')?>" type="text/javascript"></script>
</body>
</html>