<div class="masthead">
	<div class="page-header">
		<h1>Twitter Sentiment Analysis</h1>
	</div>
	<div class="navbar">
	<div class="navbar-inner">
		<div class="container">
			<ul class="nav">
				<li class="active"><a href="<?php echo $this->Html->url(array('controller' => 'pages','action' => 'home'));?>">Home</a></li>
                
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">Repository <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <li><a href="<?php echo $this->Html->url(array('controller' => 'FormalWords','action' => 'index'));?>">Kata Baku</a></li>
                      <li><a href="<?php echo $this->Html->url(array('controller' => 'InFormalWords','action' => 'index'));?>">Kata Tidak Baku</a></li>
                      <li><a href="<?php echo $this->Html->url(array('controller' => 'repositories','action' => 'index'));?>">Data Training</a></li>
                      <li><a href="<?php echo $this->Html->url(array('controller' => 'CleanRepositories','action' => 'statistik'));?>">Statistik</a></li>
                      
                      
                    </ul>
                  </li>
				<li><a href="<?php echo $this->Html->url(array('controller' => 'hunts','action' => 'index'));?>">Services</a></li>
				<li><a href="<?php echo $this->Html->url(array('controller' => 'pages','action' => 'summary','my'));?>">Comparison</a></li>
				<li><a href="#">About</a></li>
				<li><a href="#">Contact</a></li>
                
			</ul>
		</div>
	</div>
	</div><!-- /.navbar -->
</div>