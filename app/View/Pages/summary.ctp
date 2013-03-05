<div class="table">
<table id="table2">
	<caption>Emoticon \ Manual</caption>
	<thead>
	<td></td>
	<td></td>
	<th colspan="3">Manual</th>
	</thead>
	<tr>
		<td></td>
		<th></th>
		<th>Positif</th>
		<th>Netral</th>
		<th>Negatif</th>
	</tr>
	
	<tbody>
	<tr>
		<th rowspan="3"><?php echo $method; ?></th>
		<th>Positif</th>
		<td><?php echo $data['positifpositif']?></td>
		<td><?php echo $data['positifnetral']?></td>
		<td><?php echo $data['positifnegatif']?></td>
	</tr>
	<tr>
		<th>Netral</th>
		<td><?php echo $data['netralpositif']?></td>
		<td><?php echo $data['netralnetral']?></td>
		<td><?php echo $data['netralnegatif']?></td>
	</tr>
	<tr>
		<th>Negatif</th>
		<td><?php echo $data['negatifpositif']?></td>
		<td><?php echo $data['negatifnetral']?></td>
		<td><?php echo $data['negatifnegatif']?></td>
	</tr>
	</tbody>
	<tfoot>
	<tr>
		<td></td>
		<th></th>
		<th><?php echo $data['positifpositif'] + $data['netralpositif'] + $data['negatifpositif']?></th>
		<th><?php echo $data['positifnetral'] + $data['netralnetral'] + $data['negatifnetral']?></th>
		<th><?php echo $data['positifnegatif'] + $data['netralnegatif'] + $data['negatifnegatif']?></th>
		
	</tr>
	</tfoot>
</table>
</div>

<div>
	Total Data : 300
	akurasi : <?php echo ($data['positifpositif'] + $data['netralnetral'] + $data['negatifnegatif'])/300 ?>
</div>

<div>
	<?php echo $this->Html->link('Emoticon',array('controller' => 'pages','action' => 'summary','other')); ?>
	<?php echo $this->Html->link('Linguistic',array('controller' => 'pages','action' => 'summary','my')); ?>
	
</div>
