<script type="text/javascript">
	$(document).ready(function(){
		$("#j-peng").addClass("active");
	});
</script>
<div class="row-fluid">
    <h2>Test Lexicon Based</h2>
	<?php
		echo $this->Form->create('Pages', array(
			'inputDefaults' => array(            
				'label' => false,            
				'div' => false,
				)	
			)
		); 
	?>
	<?php echo $this->Form->input('sentence',array('type' =>'textarea','class' => 'input-big','placeholder' => 'type here..')); ?>	
	<button type="submit" class="btn btn-primary">Analysis</button>
	<?php echo $this->Form->end(); ?>    
</div>
<div class="row-fluid">
	<?php //debug($result)?>
    <?php if(isset($result)):?>
		<div class="table">
        <table>
            <thead>
                <tr>
                    <th>Urutan</th>
                    <th>Word</th>
                    <th>Pos</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($result['words'] as $word):?>
                    <tr>
                        <td><?php echo $word['urutan']+1;?></td>
                        <td><?php echo $word['word'];?></td>
                        <td><?php echo $word['jenis'];?></td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
		</div>
		
		<div class="table">
        <table>
            <thead>
                <tr>
                    <th>Urutan</th>
                    <th>Sentimen</th>
					<th>Negation</th>
                    <th>Pos</th>
					<th>Word</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($result['frase'] as $word):?>
                    <tr>
                        <td><?php echo $word[0]['urutan']+1;?></td>
						<td><?php echo $word['analysis'];?></td>
						<td><?php
							if($word['negation']){
								echo "Ada";
							}else{
								echo "Tidak";
							}
						?></td>
						<?php unset($word['analysis']);unset($word['negation']);?>
						<td><?php 
							foreach($word as $w ){
								echo $w['word']." ";
							}
						?></td>
                        <td><?php 
							foreach($word as $w ){
								echo $w['jenis']." ";
							}
						?></td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>
		</div>
		Kesimpulan : <?php echo $result['conclusion'];?>
	<?php endif;?>
</div>
