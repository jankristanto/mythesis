<?php echo $this->Html->script('updatesentiment'); ?>
<div class="box">
	<!-- Box Head -->
	<div class="box-head">
		<h2 class="left">DATA TWITTER</h2>
		<div class="right">
			<?php echo $this->Html->link('Lakukan Analisis',array('controller' => 'CleanTweets','action' => 'analisis',$huntId )); ?>
			<?php echo $this->Html->link('Generate test',array('controller' => 'CleanTweets','action' => 'generateBobot',$huntId )); ?>
		</div>
	</div>
	<!-- End Box Head -->	

	<!-- Table -->
	<div class="table">
		<table cellpadding="0" cellspacing="0">
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
					echo $this->Form->input('sentiment',array('rel' => $tweet['CleanTweet']['id'],'class' => 'senti','div' => false,'label' => false,'options' => $status,'selected' => $tweet['CleanTweet']['sentiment']));
				?>&nbsp;</td>
			</tr>
			<tr>
				<td style="background-color :#E6D1D9;"><?php echo h($tweet['Tweet']['content']); ?>&nbsp;</td>
			</tr>
			<?php endforeach; ?>
		</table>
		
		
		<!-- Pagging -->
		<div class="pagging">
			<?php
				echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
				echo $this->Paginator->numbers(array('separator' => ''));
				echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
			?>
		</div>
		<!-- End Pagging -->
	</div>
	<!-- Table -->
</div>


