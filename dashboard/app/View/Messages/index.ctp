<?php echo $this->Html->css('message'); 
    if(isset($mobile) && $mobile == 1){
        echo $this->Html->css('mobile');
    }?>
<h1>Flat Message Board</h1>
<?php
echo $this->Form->create('Message', ['id' => 'newMessage']);
echo $this->Form->textarea('message', ['div' => false, 'label' => false, 'class' => 'messagebox', 'id' => 'message']);
echo '<span style="display: inline;" class="find-button green-button" id="send">Send</span>';
echo $this->Form->end();
?>
<?php foreach($messages as $message): ?>
<div class="message <?php if($message['Message']['seen'] == 0){echo 'unseen';}else{echo 'seen';} ?> <?php if($message['Message']['own']==1){echo 'own';}else{echo 'notown';} ?>">
    <span class="sender"><?php echo $message['Message']['user']; ?></span>
    <p><?php echo $message['Message']['message']; ?></p>
</div>
<?php endforeach; ?>
<script>
    $("#message").keydown(function(event) {
        if(event.which === 13){
            sendMessage();
        }
    });
    $("#send").on('click', function(){
        sendMessage();
    });         
    
    function sendMessage(){
        var message = $('#message').val();
        if (message === '')return;
        <?php
        echo $this->Js->request(['controller' => 'Messages', 'action' => 'newMessage'] , [
            'async' => true,
            'method' => 'post',
            'data' => '{message: message, user: "'.$user_id.'"}',
            'dataExpression' => true,
            'update' => 'body']);
        ?>
    }
</script>

