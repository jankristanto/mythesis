<!-- Example row of columns --> 
<?php echo $this->Html->script('manual_sentiment');?>
<?php $status = array('positif' =>'positif','negatif'=>'negatif','netral'=>'netral')?>
<div class="text-center" class="row-fluid">	
    <h2><?php echo $data['Hunt']['keyword'];?></h2>
</div>
<?php //debug($positive);?>
<div id="result" class="row-fluid" >
<div class="span4">
  <h2>Positive</h2>
  <table class="table table-bordered">
	  <thead>
		<tr>
		  <th><?php echo count($positive)?></th>
		</tr>
	  </thead>
	  <tbody>
		<?php foreach($positive as $p) :?>
		<tr class="info">
		  <td>
			<?php $selected = 'positif';?>
			<?php if(isset($manual[$p['CleanTweet']['id']]))$selected=   $manual[$p['CleanTweet']['id']]; ?>
			<?php echo $p['Tweet']['content'];?>
			<?php echo $this->Form->input('sentiment',
				array(
					'id' => false,
					'rel' => $p['CleanTweet']['id'],
					'class' => 'sentiment',
					'div' => false,
					'label' => false,
					'options' => $status,
					'selected' => $selected
					)
				);?>	
		  </td>
		</tr>
		<?php endforeach;?>
	  </tbody>
	</table>
</div>
<div class="span4">
  <h2>Neutral</h2>
  <table class="table table-bordered">
	  <thead>
		<tr>
		  <th><?php echo count($neutral)?></th>
		</tr>
	  </thead>
	  <tbody>
		<?php foreach($neutral as $p) :?>
		<tr class="warning">
		  <td><?php echo $p['Tweet']['content']?>
		  <?php echo $this->Form->input('sentiment',
				array(
					'id' => false,
					'rel' => $p['CleanTweet']['id'],
					'class' => 'sentiment',
					'div' => false,
					'label' => false,
					'options' => $status,
					'selected' => 'netral' 
					)
				);?>
			</td>
		</tr>
		<?php endforeach;?>
	  </tbody>
	</table>
</div>
<div class="span4">
  <h2>Negative</h2>
  <table class="table table-bordered">
	  <thead>
		<tr>
		  <th><?php echo count($negative)?></th>
		</tr>
	  </thead>
	  <tbody>
		<?php foreach($negative as $p) :?>
		<tr class="error">
		  <td><?php echo $p['Tweet']['content']?>
		  <?php echo $this->Form->input('sentiment',
				array(
					'id' => false,
					'rel' => $p['CleanTweet']['id'],
					'class' => 'sentiment',
					'div' => false,
					'label' => false,
					'options' => $status,
					'selected' => 'negatif' 
					)
				);?>
		  </td>
		</tr>
		<?php endforeach;?>
	  </tbody>
	</table>
</div>

</div>	
