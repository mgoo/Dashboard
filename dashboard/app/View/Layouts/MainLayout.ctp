<?php
$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo 'login'; ?>:
		<?php echo $this->fetch('title'); ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css(['index','button']);
                echo $this->Html->script('http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js' , array('inline' => false)); 
                echo $this->Html->script('http://code.jquery.com/ui/1.11.4/jquery-ui.js' , array('inline' => false)); 
                
                if(isset($mobile) && $mobile == 1){
                    echo $this->Html->css('mobile');
                }
                
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
    <div id="content">
        <?php echo $this->fetch('content'); ?>
    </div>
</body>
</html>
