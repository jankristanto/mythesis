<?php echo $jumlah; ?> Data Telah dipreprocessing. <br/>
<?php
  echo $this->Html->link('Next',array('controller' => 'Repositories','action' => 'preprocessingDataTraining',$limit,$after+$limit));
?>
