<div class="masthead">
	<div class="page-header">
		<h1>Twitter Sentiment Analysis</h1>
	</div>
	<div class="navbar">
	<div class="navbar-inner">
		<div class="container">
			<ul class="nav">
				<li id="j-home"><a href="<?php echo $this->Html->url(array('controller' => 'pages','action' => 'home'));?>">Home</a></li>
                
                <li id="j-repo" class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">Repository <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <li><a href="<?php echo $this->Html->url(array('controller' => 'FormalWords','action' => 'index'));?>">Kata Baku</a></li>
                      <li><a href="<?php echo $this->Html->url(array('controller' => 'InFormalWords','action' => 'index'));?>">Kata Tidak Baku</a></li>
                      <li><a href="<?php echo $this->Html->url(array('controller' => 'repositories','action' => 'index'));?>">Data Training</a></li>
                      <li><a href="<?php echo $this->Html->url(array('controller' => 'CleanRepositories','action' => 'statistik'));?>">Statistik</a></li>
                    </ul>
                  </li>
				<li id="j-lay" ><a href="<?php echo $this->Html->url(array('controller' => 'hunts','action' => 'index'));?>">Layanan</a></li>
				<li id="j-per" class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">Perbandingan<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <li><a href="<?php echo $this->Html->url(array('controller' => 'Pages','action' => 'summary','my'));?>">Training</a></li>
                      <li><a href="<?php echo $this->Html->url(array('controller' => 'CleanTweets','action' => 'statistik'));?>">Testing</a></li>
                    </ul>
                </li>
				<li id="j-peng" class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">Pengujian<b class="caret"></b></a>
                    <ul class="dropdown-menu">
                      <li><a href="<?php echo $this->Html->url(array('controller' => 'Pages','action' => 'testLexiconBased'));?>">Lexicon Based</a></li>
                      <li><a href="<?php echo $this->Html->url(array('controller' => 'Pages','action' => 'testSvm'));?>">SVM</a></li>
                    </ul>
                </li>
				<li id="j-ten"><a href="<?php echo $this->Html->url(array('controller' => 'Pages','action' => 'about'));?>">Tentang</a></li>
                
			</ul>
		</div>
	</div>
	</div><!-- /.navbar -->
</div>