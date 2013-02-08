<?php //debug($hunt);?>

<div class="box">
	<!-- Box Head -->
	<div class="box-head">
		<h2 class="left">Hasil Pencarian : <?php echo $hunt[0]['Hunt']['keyword']?></h2>
		<div class="right">
			<?php echo $this->Html->link('Lakukan Preprosesing Data ini',array('controller' => 'tweets','action' => 'preprocessing',$hunt[0]['Hunt']['id'])); ?>
		</div>
	</div>
	<!-- End Box Head -->	

	<!-- Table -->
	<div class="table">
		<table cellpadding="0" cellspacing="0">
			<tr>
				<th><?php echo $this->Paginator->sort('published'); ?></th>
				<th>Pengirim</th>
				<th><?php echo $this->Paginator->sort('content'); ?></th>
			</tr>
			<?php foreach ($hunt as $tweet): ?>
			<tr>
				<td><?php echo h($tweet['Tweet']['published']); ?>&nbsp;</td>
				<td><?php echo $this->Html->image($tweet['Tweet']['avatar_image_link']);?>&nbsp; <?php echo $tweet['Tweet']['author_name']?></td>
				<td><?php echo $tweet['Tweet']['content']?>&nbsp;</td>
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


