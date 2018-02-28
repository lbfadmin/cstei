<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo t('System exception');?></title>
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<style>
body{
	font-family: 'Microsoft Yahei', Verdana, arial, sans-serif;
	font-size:14px;
}
a{text-decoration:none;color:#174B73;}
a:hover{ text-decoration:none;color:#FF6600;}
h2{
	border-bottom:1px solid #DDD;
	padding:8px 0;
    font-size:25px;
}
.title{
	margin:4px 0;
	color:#F60;
	font-weight:bold;
}
.message,#trace{
	padding:1em;
	border:solid 1px #000;
	margin:10px 0;
	background:#FFD;
	line-height:150%;
}
.message{
	background:#FFD;
	color:#2E2E2E;
		border:1px solid #E0E0E0;
}
#trace{
	background:#E7F7FF;
	border:1px solid #E0E0E0;
	color:#535353;
}
.notice{
    padding:10px;
	margin:5px;
	color:#666;
	background:#FCFCFC;
	border:1px solid #E0E0E0;
}
.red{
	color:red;
	font-weight:bold;
}
</style>
</head>
<body>
<div class="notice">
<h2><?php echo t('System exception');?> (Code: <?php echo $e['code'];?>)</h2>
<div ><?php echo t('You can');?>: [ <A HREF="javascript:history.back()"><?php echo t('Backward');?></A> ] <?php echo t('or');?> [ <A HREF="<?php echo url('<front>');?>"><?php echo t('View frontpage');?></A> ]</div>
<?php if(isset($e['file'])) {?>
<p><strong><?php echo t('Location');?>:</strong>　<span class="red"><?php echo $e['file'] ;?></span>　<?php echo t('line');?>: <span class="red"><?php echo $e['line'];?></span></p>
<?php }?>
<p class="title">[ <?php echo t('Type');?> ]</p>
<p class="message"><?php echo $e['type'];?></p>
<p class="title">[ <?php echo t('Message');?> ]</p>
<p class="message"><?php echo $e['message'];?></p>
<?php if(isset($e['trace'])) {?>
<p class="title">[ <?php echo t('Trace');?> ]</p>
<p id="trace">
<?php echo nl2br($e['trace']);?>
</p>
<?php }?>
</div>
</body>
</html>
