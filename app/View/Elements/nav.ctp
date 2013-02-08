<div id="navigation">
	<ul>
        <li><a href="<?php echo $this->Html->url('/');?>"><span>Dashboard</span></a></li>
		<li><a href="<?php echo $this->Html->url(array('controller' => 'inFormalWords', 'action' => 'index'));?>"><span>Slang</span></a></li>
		<li><a href="<?php echo $this->Html->url(array('controller' => 'FormalWords', 'action' => 'index'));?>"><span>Formal</span></a></li>
		<li><a href="<?php echo $this->Html->url(array('controller' => 'CleanTweets', 'action' => 'train'));?>"><span>Train</span></a></li>
		<li><a href="<?php echo $this->Html->url(array('controller' => 'CleanTweets', 'action' => 'test'));?>"><span>Test</span></a></li>
		<li><a href="<?php echo $this->Html->url(array('controller' => 'CleanTweets', 'action' => 'buildTrainingData'));?>"><span>Build Training Data</span></a></li>
	</ul>
</div>