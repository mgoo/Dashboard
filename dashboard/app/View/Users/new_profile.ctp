<img src="<?php echo $this->webroot;?>img/profiles/<?php echo $userId;?>?stopCahce=<?php echo rand();?>" class="profile edit">
<br>
<?php
echo $this->Form->create('User', ['type' => 'file', 'id' => 'form']);
echo $this->Form->file('newProfile', ['div' => false, 'label' => false, 'id' => 'file']);
echo $this->Form->end();
?>
<script>
    $('#file').on('change', function(){
        $('#form').submit();
    });
       
</script>
