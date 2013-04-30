<?php echo $this->Html->script('updatesentiment'); ?>
<div class="text-center" class="row-fluid">
	<h2 class="left">DATA TWITTER</h2>
	<div class="right">
		<?php echo $this->Html->link('Lakukan Analisis Awal',array('controller' => 'CleanTweets','action' => 'checkNetral',$huntId )); ?>
		<?php echo $this->Html->link('Generate test',array('controller' => 'CleanTweets','action' => 'generateBobot',$huntId )); ?>
		<?php echo $this->Html->link('Analysis',array('controller' => 'CleanTweets','action' => 'test',$huntId )); ?>
	</div>
	<div class="table">
		<table class="table">
			<tr>
					<th><?php echo $this->Paginator->sort('id'); ?></th>
					<th><?php echo $this->Paginator->sort('content'); ?></th>
					<th><?php echo $this->Paginator->sort('sentiment'); ?></th>
			</tr>
			<?php foreach ($cleanTweets as $tweet): ?>
			<tr>
				<td rowspan="2"><?php echo h($tweet['CleanTweet']['id']); ?>&nbsp;</td>
				<td><?php echo h($tweet['CleanTweet']['content']); ?>&nbsp;</td>
				<td rowspan="2"><?php 
					if($tweet['CleanTweet']['sentiment'] != null){
						echo $this->Form->input('sentiment',array('rel' => $tweet['CleanTweet']['id'],'class' => 'senti','div' => false,'label' => false,'options' => $status,'selected' => $tweet['CleanTweet']['sentiment'] ));
					}else{
						echo $this->Form->input('sentiment',array('rel' => $tweet['CleanTweet']['id'],'class' => 'senti','div' => false,'label' => false,'options' => $status,'empty' => true ));
					}
					
				?>&nbsp;</td>
			</tr>
			<tr>
				<td style="background-color :#E6D1D9;"><?php echo h($tweet['Tweet']['content']); ?>&nbsp;</td>
			</tr>
			<?php endforeach; ?>
		</table>
		
		
		<!-- Pagging -->
		<div class="pagination">
				<ul>
					<?php echo $this->BootstrapPaginator->prev();?>
					<?php echo $this->BootstrapPaginator->numbers();?>
					<?php echo $this->BootstrapPaginator->next();?>
				</ul>
			  </div>
		<!-- End Pagging -->
	</div>
	<!-- Table -->
</div>


