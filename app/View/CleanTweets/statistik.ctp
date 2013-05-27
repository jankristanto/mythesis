<div class="row-fluid">
	<table class="table">
		<caption>SVM \ Manual</caption>
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
		<tr class="error">
			<th rowspan="3">SVM</th>
			<th>Positif</th>
			<td><?php echo $positifpositif;?></td>
			<td><?php echo $positifnetral;?></td>
			<td><?php echo $positifnegatif;?></td>
		</tr>
		<tr class="warning" >
			<th>Netral</th>
			<td><?php echo $netralpositif;?></td>
			<td><?php echo $netralnetral;?></td>
			<td><?php echo $netralnegatif;?></td>
		</tr>
		<tr class="info" >
			<th>Negatif</th>
			<td><?php echo $negatifpositif;?></td>
			<td><?php echo $negatifnetral;?></td>
			<td><?php echo $negatifnegatif;?></td>
		</tr>
		</tbody>
		<tfoot>
		<tr class="info" >
			<td></td>
			<th></th>
			<th><?php echo $positifpositif + $netralpositif + $negatifpositif;?></th>
			<th><?php echo $positifnetral + $netralnetral + $negatifnetral;?></th>
			<th><?php echo $positifnegatif + $netralnegatif + $negatifnegatif;;?></th>
			
		</tr>
		</tfoot>
	</table>
	<div>
	
	Total Data : <?php 
		echo ($positifpositif + $positifnetral + $positifnegatif +
			$netralpositif + $netralnetral + $netralnegatif +
			$negatifpositif + $negatifnetral + $negatifnegatif);
	?> <br/>
	akurasi : <?php echo ($positifpositif + $netralnetral + $negatifnegatif); ?>
	</div>
</div>


