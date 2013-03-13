<?php
$cakeDescription = __d('cake_dev', 'Twitter Sentiment Analysis');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css(array('bootstrap','style','bootstrap-responsive'));
		//echo $this->Html->css('jquery-ui-1.8.23.custom');
		echo $this->Html->script('jquery-1.8.0.min');
		//echo $this->Html->script('jquery-ui-1.8.23.custom.min');
		echo $this->Html->script('bootstrap.min');
		//echo $this->Html->script('myautocomplate');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>

<body>
	<div class="container">
		<?php echo $this->Element('header'); ?>
		<?php echo $this->Session->flash(); ?>
		<?php echo $this->fetch('content'); ?>
		<hr>
		<?php echo $this->Element('footer'); ?>
	</div> <!-- /container -->
</body>
</html>
