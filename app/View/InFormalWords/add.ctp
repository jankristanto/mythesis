<div class="box">
	<!-- Box Head -->
	<div class="box-head">
		<h2>Tambah Kata tidak Baku</h2>
	</div>
	<!-- End Box Head -->
	
	<?php
					echo $this->Form->create('InFormalWord', array(
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
			<?php echo $this->Form->input('aspal',array('class' => 'field size1')); ?>	
		</p>		
		<p>
			
			<label>Kata Baku <span>(Required Field)</span></label>
			<?php echo $this->Form->input('asli',array('class' => 'field size1')); ?>	
		</p>

		<p>
			
			<label>Keterangan </label>
			<?php echo $this->Form->input('keterangan',array('class' => 'field size1')); ?>	
		</p>
				
				
			
	</div>
	<!-- End Form -->
	
	<!-- Form Buttons -->
	<div class="buttons">
		<input type="submit" class="button" value="submit" />
	</div>	
	<?php echo $this->Form->end(); ?>
</div>	
