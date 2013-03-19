<div class="row-fluid">
	<?php
	echo $this->Form->create('FormalWord', array(
		'inputDefaults' => array(            
			'label' => false,            
			'div' => false,
			'error' => array(
			)
		),
			
			
		)
	); 
	?> 
	
	<div class="form">
	
		<p>
			
			<label>Kata Tidak Baku<span>(Required Field)</span></label>
			<?php echo $this->Form->input('text',array('class' => 'span4')); ?>	
		</p>		
		<p>
			
			<label>Kata Baku <span>(Required Field)</span></label>
			<?php echo $this->Form->input('pos',array('class' => 'span3','options' => $pos)); ?>	
		</p>

		<p>
			
			<label>Status </label>
			<?php echo $this->Form->input('status',array('class' => 'span4')); ?>	
		</p>
				
				
			
	</div>
	<!-- End Form -->
	
	<!-- Form Buttons -->
	<div class="buttons">
		<input type="submit" class="button" value="submit" />
	</div>	
	<?php echo $this->Form->end(); ?>
</div>	
