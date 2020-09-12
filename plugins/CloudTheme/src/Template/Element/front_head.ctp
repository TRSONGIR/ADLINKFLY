<?= $this->Html->charset(); ?>
<title><?= h($this->fetch('title')); ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="<?= h($this->fetch('description')); ?>">

<?= $this->Assets->favicon() ?>

<?php
if ((bool)get_option('combine_minify_css_js', false)) {
    echo $this->Assets->css('/build/css/styles.min.css');
	if(locale_get_primary_language(null)=='fa'){
		echo $this->Assets->css('/build/css/styles.min.rtl.css');
	}
	else{
?>
	<link href="//fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
<?php
	}
} else {
    echo $this->Assets->css('/vendor/bootstrap/css/bootstrap.min.css');
    echo $this->Assets->css('/vendor/font-awesome/css/font-awesome.min.css');
    echo $this->Assets->css('/vendor/animate.min.css');
    echo $this->Assets->css('/vendor/owl/owl.carousel.min.css');
    echo $this->Assets->css('/vendor/owl/owl.theme.default.css');
    echo $this->Assets->css('/css/front.css');
    echo $this->Assets->css('/css/app.css');
    echo $this->Assets->css('/css/spritesheet.css');
}

echo $this->fetch('meta');
echo $this->fetch('css');
echo $this->fetch('script');
?>

<?= get_option('head_code'); ?>
<?= $this->fetch('scriptTop') ?>

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
