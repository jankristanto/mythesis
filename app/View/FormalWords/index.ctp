
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2 class="left">Kata Tidak Baku</h2>
        <div class="right">
            <label>search kata tidak baku</label>
            <input type="text" class="field small-field" />
            <input type="submit" class="button" value="search" />
        </div>
    </div>
    <!-- End Box Head -->    

    <!-- Table -->
    <div class="table">
        <table>
            <thead>
                <tr>
                    <th><?php echo $this->Paginator->sort('id');?></th>
                    <th><?php echo $this->Paginator->sort('text');?></th>
                    <th><?php echo $this->Paginator->sort('pos');?></th>
                   
                </tr>
            </thead>
            <tbody>
                <?php foreach($data as $informal):?>
                    <tr>
                        <td><?php echo $informal['FormalWord']['id']?></td>
                        <td><?php echo $informal['FormalWord']['text']?></td>
                        <td><?php echo $informal['FormalWord']['pos']?></td>
                        
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