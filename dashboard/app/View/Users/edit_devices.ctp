<?php echo $this->Html->css('device_list'); ?>
<div class="list">
<?php foreach($devices as $device): ?>
    <div id="<?php echo $device['Device']['id'] ?>" class="device">
        <h2><?php echo $device['Device']['name'];?></h2>
        <span><?php echo $device['Device']['ip']?></span><br />
        <span>Logged In: <?php echo ($device['Device']['loggedin'] ? 'yes' : 'no'); ?></span><br />
        <button onclick="deleteDevice('<?php echo $device['Device']['id'] ?>')" style="color: red;margin-bottom: 1%;">Delete</button>
    </div>
<?php endforeach; ?>
</div>

<script>
    function deleteDevice(id){
        <?php
            echo $this->Js->request(['controller' => 'Users', 'action' => 'deleteDevice'], [
            'async' => true,
            'method' => 'post',
            'data' => '{id: id}',
            'dataExpression' => true,
            'success'=> ' 
                    $("#"+id).hide();
                    ',
            'error' => 'alert(error)'
            ]);
        ?>    
        return false;
    }
    </script>