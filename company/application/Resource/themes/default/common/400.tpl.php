<!DOCTYPE html>
<html lang="<?=$_LANG?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>400</title>
</head>

<body>
<div class="main">
    <h3 class="title">哇哦~您无法浏览此内容</h3>
    <p><?php echo $message ?: '参数错误。' ?></p>
</div>
</body>
</html>
<?php exit() ?>
