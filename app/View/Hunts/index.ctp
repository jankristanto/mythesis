<!-- Example row of columns --> 
<div class="text-center" class="row-fluid">
	<h2>Enter Keyword...</h2>
	<?php
		echo $this->Form->create('Hunt', array(
			'inputDefaults' => array(            
				'label' => false,            
				'div' => false,
				)	
			)
		); 
	?>
	<?php echo $this->Form->input('keyword',array('class' => 'input-big','placeholder' => 'enter keyword...')); ?>	
	
	<button type="submit" class="btn btn-primary">Search</button>
	<?php echo $this->Form->end(); ?>
</div>

<div class="row-fluid">
<div class="span4">
  <h2>Positive</h2>
  <table class="table table-condensed">
	  <thead>
		<tr>
		  <th>#</th>
		</tr>
	  </thead>
	  <tbody>
		<tr>
		  <td>@twitter</td>
		</tr>
	  </tbody>
	</table>
</div>
<div class="span4">
  <h2>Neutral</h2>
  <table class="table table-condensed">
	  <thead>
		<tr>
		  <th>#</th>
		</tr>
	  </thead>
	  <tbody>
		<tr>
		  <td>@twitter</td>
		</tr>
	  </tbody>
	</table>
</div>
<div class="span4">
  <h2>Negative</h2>
  <table class="table table-condensed">
	  <thead>
		<tr>
		  <th>#</th>
		</tr>
	  </thead>
	  <tbody>
		<tr>
		  <td>@twitter</td>
		</tr>
	  </tbody>
	</table>
</div>


</div>	
