<!DOCTYPE HTML>
<html lang="<?=$_LANG?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title>403</title>
    <link rel="stylesheet" href="<?=$this->misc('libs/amazeui/2.3.0/css/amazeui.min.css') ?>">
    <link rel="stylesheet" href="<?=$this->misc('styles/normalize.css') ?>">
    <style type="text/css">
        body {
            font-family: "微软雅黑", "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
        }
        .title {
            padding: .5em 1em;
            margin: 0;
        }
        .message {
            padding: .5em 1em;
            background: #efefef;
        }
    </style>
</head>

<body>
<div id="maincontent">
    <div class="wrap">
        <div class="main">
            <h3 class="title">哇哦~您无法浏览此页面：</h3>
            <div class="message"><p>提示：<?php echo isset($message) ? $message : '您没有查看此页面的权限。' ?></p>
                <div style="font-size: 15em; text-align: right;color:#ddd">:(</div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<?php exit(0); ?>