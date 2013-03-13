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
        <?php echo $this->BootstrapPaginator->prev();?>
        <?php echo $this->BootstrapPaginator->numbers();?>
        <?php echo $this->BootstrapPaginator->next();?>
    </ul>
    </div>
</div>