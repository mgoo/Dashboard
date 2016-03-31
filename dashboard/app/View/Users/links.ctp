<a href="http://192.168.20.13/movieserver" target="mainFrame">
    <img src="<?php echo $this->webroot;?>img/movies_button.png"  class="button">
</a>
<?php if ($username != 'guest'): ?>
<a href="<?php echo $this->Html->url(['controller' => 'ShoppingLists', 'action' => 'index']);?>" target="mainFrame">
    <img src="<?php echo $this->webroot;?>img/shoppingList_button.png"  class="button">
</a>
<br>
<a href="<?php echo $this->Html->url(['controller' => 'Chores', 'action' => 'index']);?>" target="mainFrame">
    <img src="<?php echo $this->webroot;?>img/chores.png"  class="button">
</a>
<a href="<?php echo $this->Html->url(['controller' => 'Messages', 'action' => 'index']);?>" target="mainFrame">
    <img src="<?php echo $this->webroot;if ($unreadMessages == '0'){echo 'img/messages.png';}else{echo 'img/messages_unread.png';}?>" class="button" style="background-color: rgba(0,0,0,0); box-shadow: none;">
</a>
<?php endif; ?>
