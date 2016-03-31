<?php echo $this->Html->css('edit_user');
    if(isset($mobile) && $mobile == 1){
        echo $this->Html->css('mobile');
    }?>
<?php
echo $this->Form->create('User', ['class' => 'editUser']);
?>
<table>
    <tr>
        <td><?php echo $this->Form->hidden('id', ['value' => $info['User']['id']]);?><h1>Edit User</h1>
        </td><td><iframe class="hiddenIFrame" id="newFile" src="<?php echo $this->Html->url(['controller' => 'Users', 'action' => 'newProfile']);?>"></iframe></td>
    </tr>
    <tr>
        <td><span>Username:</span></td>
        <td><?php echo $this->Form->input('username', ['label' => false, 'value' => $info['User']['username']]);?></td>
    </tr>
    <tr>
        <td><span>Old Password:</span></td>
        <td><?php echo $this->Form->input('oldpassword', ['label' => false, 'type' => 'password', 'value' => '']);?></td>
    </tr>
    <tr>
        <td colspan="2"><div style="display: none;" id="passMatchDiv"><span id="passMatch"></span></div></td>
    </tr>
    <tr>
        <td><span>New Password:</span></td>
        <td><?php echo $this->Form->input('password', ['label' => false, 'type' => 'password', 'value' => '', 'id' => 'pass']);?></td>
    </tr>
    <tr>
        <td><span>Confirm New Password:</span></td>
        <td><?php echo $this->Form->input('password2', ['label' => false, 'type' => 'password', 'value' => '', 'id' => 'pass2']);?></td>
    </tr>
    <tr>
        <td><span>First Name:</span></td>
        <td><?php echo $this->Form->input('first_name', ['label' => false, 'value' => $info['User']['first_name']]);?></td>
    </tr>
    <tr>
        <td><span>Last Name:</span></td>
        <td><?php echo $this->Form->input('last_name', ['label' => false, 'value' => $info['User']['last_name']]);?></td>
    </tr>
</table>
<?php echo $this->Form->end('Update'); ?>
?>
<script>
    $('#pass').on('input', function(){
        checkMatch();
    });
    $('#pass2').on('input', function(){
        checkMatch();
    });
    
    function checkMatch(){
        if ($('#pass').val() === $('#pass2').val()){
            $('#passMatch').html('Your Passwords Match');
            $('#passMatch').attr('style', 'color: green;');
            $('#passMatchDiv').show();
        } else {
            $('#passMatch').html('Your Passwords Do Not Match');
            $('#passMatch').attr('style', 'color: red;');
            $('#passMatchDiv').show();
        }
    }
</script>