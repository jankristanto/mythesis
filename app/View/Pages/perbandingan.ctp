<h2>Perbandingan</h2>
<?php echo $this->Html->link('next',array('controller' => 'pages','action' =>'perbandingan',$limit,$page+1));?>
<div class="table">
<table>
	<thead>
		<tr>
			<th>Id</th>
			<th>Orginal</th>
			<th>Content</th>
			<th>Other</th>
			<th>My</th>
			<th>Manual</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($data as $d):?>
		<tr>
			<td width ="10%"><?php echo $d['Comparison']['id']?></td>
			<td width ="30%"><?php echo $d['Comparison']['original']?></td>
			<td width ="30%"><?php echo $d['Comparison']['content']?></td>
			<td width ="10%"><?php echo $d['Comparison']['other']?></td>
			<td width ="10%"><?php echo $d['Comparison']['my']?></td>
			<td width ="10%">
				<?php if(is_null($d['Comparison']['manual'])):?>
				<input class="manual"  rel="<?php echo $d['Comparison']['id']?>" />
				<?php else: ?>
				<input class="manual" value="<?php echo $d['Comparison']['manual']?>" rel="<?php echo $d['Comparison']['id']?>" />
				<?php endif;?>
			</td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>
</div>

<?php echo $this->Html->script('updatesentiment');?>
