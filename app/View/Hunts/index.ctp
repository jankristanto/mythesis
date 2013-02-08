<div class="box">
	<!-- Box Head -->
	<div class="box-head">
		<h2>Sentiment pada Twitter</h2>
	</div>
	<!-- End Box Head -->
	
	<?php
					echo $this->Form->create('Hunt', array(
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
			<label>Masukan kata kunci<span>(Required Field)</span></label>
			<?php echo $this->Form->input('keyword',array('class' => 'field size1')); ?>	
		</p>			
	</div>
	<!-- End Form -->
	
	<!-- Form Buttons -->
	<div class="buttons">
		<input type="submit" class="button" value="submit" />
	</div>	
	<?php echo $this->Form->end(); ?>
</div>	
