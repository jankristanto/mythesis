<?php echo $this->Html->script('myscript');?>
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2 class="left">Kata Baku</h2>
        <?php echo $this->Html->link('Tambah Kata Baku',array('controller' => 'FormalWords','action' => 'add'))?>
    </div>
    <!-- End Box Head -->    

    <!-- Table -->
	<div >
		
		<?php
			echo $this->Form->input('text',array('type'=>'text','id'=>'text','label'=>'Search'));
		?>
		
	</div>
    <div class="table">
        <table>
            <thead>
                <tr>
                    <th><?php echo $this->Paginator->sort('id');?></th>
                    <th><?php echo $this->Paginator->sort('text');?></th>
                    <th><?php echo $this->Paginator->sort('pos');?></th>
					<th><?php echo $this->Paginator->sort('status');?></th>
                   
                </tr>
            </thead>
            <tbody>
                <?php foreach($data as $informal):?>
                    <tr>
                        <td><?php echo $informal['FormalWord']['id']?></td>
                        <td><?php echo $informal['FormalWord']['text']?></td>
                        <td><?php echo $informal['FormalWord']['pos']?></td>
                        <td><?php echo $informal['FormalWord']['status']?></td>
                    </tr>
                <?php endforeach;?>
            </tbody>
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