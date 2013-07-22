<script type="text/javascript">
	$(document).ready(function(){
		$("#j-repo").addClass("active");
	});
</script>
<div class="row-fluid">
    <?php $warna = '';?>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Original</th>
          <th>Preprocessing</th>
          <th>Sentiment</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($data as $repo) :?>
        <?php 
            
            if($repo['CleanRepository']['sentiment'] != null){
                switch ($repo['CleanRepository']['sentiment']) {
                    case "netral":
                        $warna = "warning";
                        break;
                    case "positif":
                        $warna = "info";;
                        break;
                    case "negatif":
                        $warna = "error";
                        break;
                }
            }
        ?>
        <tr class="<?php echo $warna;?>">
          <td><?php echo $repo['Repository']['id_repositori']?></td>
          <td class="info"><?php echo $repo['Repository']['tweet']?></td>
          <td class="warning"><?php echo $repo['CleanRepository']['content']?></td>
          <td><?php echo $repo['CleanRepository']['sentiment']?></td>
        </tr>
        <?php endforeach;?>
      </tbody>
    </table>
    <div class="pagination">
    <ul>
		<?php $this->passedArgs['page'] = $this->passedArgs['page'] -1;?>
        <li><a href="<?php echo $this->Html->url($this->passedArgs);?>">&lt;&lt; Previous</li>        
		<?php $this->passedArgs['page'] = $this->passedArgs['page'] +2;?>
		<li><a href="<?php echo $this->Html->url($this->passedArgs);?>">Next &gt;&gt;</a></li>
    </ul>
	
    </div>
</div>