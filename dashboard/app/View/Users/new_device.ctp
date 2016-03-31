<?php
echo $this->Form->create('Device');
?>
<h1>Device</h1>
<p>You have not logged on, on this device before please enter a name for it.</p>
<?php
echo $this->Form->input('name', ['div' => false]);
echo $this->Form->end('Save');
