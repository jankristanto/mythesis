<!-- Example row of columns --> 
<?php echo $this->Html->script('searchtweet'); ?>
<script type="text/javascript">
	$(document).ready(function(){
		$("#j-lay").addClass("active");
	});
</script>
<div class="text-center" class="row-fluid">
	
	<h2>Enter Keyword...</h2>
	<?php
		echo $this->Form->create('Hunt', array(
			'url' => array('action' => 'service'),
			'id' => 'newservice',
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


	<div id="formhunt">
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
    <div id="pgbar" class="progress progress-info progress-striped">
        <div class="bar" style="width: 100%"></div>
    </div>
</div>

<div id="result" class="row-fluid" style="display: none;">
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
