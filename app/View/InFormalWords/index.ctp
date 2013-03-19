<div class="box">
	<!-- Box Head -->
	<div class="box-head">
		<h2 class="left">Kata Tidak Baku</h2>
		<?php echo $this->Html->link('Tambah Kata TIdak Baku',array('controller' => 'InFormalWords','action' => 'add'))?>
	</div>
	<!-- End Box Head -->	

	<!-- Table -->
	<div class="table">
		<table>
			<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('id');?></th>
					<th><?php echo $this->Paginator->sort('asli');?></th>
					<th><?php echo $this->Paginator->sort('aspal');?></th>
					<th>Formal</th>
                    
				</tr>
			</thead>
			<tbody>
				<?php foreach($data as $informal):?>
					<tr>
						<td><?php echo $informal['InFormalWord']['id']?></td>
						<td><?php echo $informal['InFormalWord']['asli']?></td>
						<td><?php echo $informal['InFormalWord']['aspal']?></td>
						<td><?php echo $informal['FormalWord']['text']?></td>
					</tr>
				<?php endforeach;?>
			</tbody>
			
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