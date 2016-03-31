<div id="topbar">
    <img src="<?php echo $this->webroot;?>img/backarrow.png" id="backArrow" style="display: none;">
    <img src="<?php echo $this->webroot;?>img/cog.png" id="showSidebar">
    Logged in as <?php echo $username?>
</div>
<div id="sidebar">
    <img src="<?php echo $this->webroot;?>img/profiles/<?php echo $userId;?>?stopCahce=<?php echo rand();?>" class="profile" id="profilePic"><br>
    <a href="<?php echo $this->Html->url(['controller' => 'Users', 'action' => 'logout']);?>" onclick="hideSidebar()">
        <img src="<?php echo $this->webroot;?>img/logout.png" class="icon">
        Logout
    </a><br>
    <?php if ($username != 'guest'): ?>
    <a href="<?php echo $this->Html->url(['controller' => 'Users', 'action' => 'editUser']);?>" target="mainFrame" onclick="hideSidebar()" id="editUser">
        <img src="<?php echo $this->webroot;?>img/edit-icon.png" class="icon">
        Update info
    </a><br>
    <?php endif; ?>
    <a href="<?php echo $this->Html->url(['controller' => 'Users', 'action' => 'editDevices']);?>" target="mainFrame" onclick="hideSidebar()" id="editDevices">
        <img src="<?php echo $this->webroot;?>img/device-icon.png" class="icon">
        Edit Devices
    </a>
</div>
<div id="sidebarHide"></div>
<iframe id="mainFrame" name="mainFrame" src="<?php echo $this->Html->url(['controller' => 'Users', 'action' => 'links']);?>"></iframe>
<script>
    $("#mainFrame").on('load', function(){
        $('#profilePic').attr('src', 'notfound');
        $('#profilePic').attr('src', '<?php echo $this->webroot;?>img/profiles/<?php echo $userId;?>?stopCahce=<?php echo rand();?>');
        
        var mainFrame = $('#mainFrame').contents().get(0);
        $(mainFrame).bind('click', function(event){
            if (event.target.tagName === 'A' || event.target.tagName === 'IMG'){
                $('#backArrow').fadeIn();
            }
        });
    });
    
    $('#sidebar').on('click', function(event){
        if (event.target.id === 'editUser' || event.target.id === 'editDevices'){
            $('#backArrow').fadeIn();
        }
    });
    
    $('#backArrow').on('click', function(){
        $('#backArrow').hide();
        $('#mainFrame').attr('src', '<?php echo $this->Html->url(['controller' => 'Users', 'action' => 'links']);?>');
    });
    
    $('#showSidebar').on('click', function(){
       showSidebar(); 
    });
    
    $('#sidebarHide').on('click', function(){
        hideSidebar();
    });
    
    function hideSidebar(){
        $("#sidebar").hide('slide', {direction: 'left'}, 500);
        $('#sidebarHide').hide();
    }
    function showSidebar(){
        $('#profilePic').attr('src', '<?php echo $this->webroot;?>img/profiles/<?php echo $userId;?>?timestamp=' + new Date().getTime()); //relaod img
        $("#sidebar").show('slide', {direction: 'left'}, 500);  
        $('#sidebarHide').show();
    }
    
</script>
