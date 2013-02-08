<div >
    <?php echo $this->Form->create('FormalWord',array('action'=>'search'));?>
    <?php
        echo $this->Form->input('text',array('type'=>'text','id'=>'text','label'=>'Search'));
    ?>
    <?php echo $this->Form->end(__('Submit', true));?>
</div>
