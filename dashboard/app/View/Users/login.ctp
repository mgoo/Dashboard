
<?php
echo $this->Form->create();
echo '<h1>login</h1>';
echo $this->Form->input('username', ['div' => false]);
echo $this->Form->input('password', ['div' => false, 'type' => 'password']);
echo $this->Form->end('Login');