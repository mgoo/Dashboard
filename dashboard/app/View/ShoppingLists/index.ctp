<?php echo $this->Html->css('edit_user');
    if(isset($mobile) && $mobile == 1){
        echo $this->Html->css('mobile');
    }?>
<?php echo $this->Html->css('overlay'); ?>
<h1>Shopping List</h1>
<table class="shopping_lists">
    <tr>
        <td>
            <h2>Personal</h2>
            <button id="add_personal">Add</button><button id="clear_personal" onclick="clearList('<?php echo $username ?>')">Clear All</button>
            <table style="margin-top: 5%;">
                <?php foreach ($personal_list as $item): ?>
                <?php echo $this->Html->tableCells(['<span><input type="checkbox" onclick="strike(event)">'.$item['ShoppingList']['name'].': '.$item['ShoppingList']['quantity'].'</span>','<button onclick="clearItem(\''.$item['ShoppingList']['id'].'\')">Delete</button>']);?>
                <?php endforeach; ?>
            </table>                                
        </td>
        <td>
            <h2>Flat</h2>
            <button id="add_flat">Add</button><button id="clear_flat" onclick="clearList('flat')">Clear All</button>
            <table  style="margin-top: 5%;">
                <?php foreach ($flat_list as $item): ?>
                <?php echo $this->Html->tableCells(['<span><input type="checkbox" onclick="strike(event)">'.$item['ShoppingList']['name'].': '.$item['ShoppingList']['quantity'].'</span>','<button onclick="clearItem(\''.$item['ShoppingList']['id'].'\')">Delete</button>']);?>
                <?php endforeach; ?>
            </table>
        </td>
    </tr>
</table>
<div id="overlay" class="overlay" style="display: none;">
    <div id="overlay_content">
    <?php
        echo $this->Form->create();
        ?><h2 id="heading"></h2><?php
        echo $this->Form->input('name', ['div' => false, 'id' => 'name']).'<br>';
        echo $this->Form->input('quantity', ['div' => false, 'id' => 'quantity']).'<br>';
        echo $this->Form->hidden('list', ['id' => 'list']);
        ?><span onclick="addItem()" class="large-button green-button">Save</span><?php
        echo $this->Form->end();
    ?>
    </div>
</div>
<div class="overlay_backing" id="overlay_backing">
        <img class="overlay_close_button" id="close_button" src="img/close.png">
</div>

<script>
    $('#add_personal').on('click', function(){
        $('#heading').html('Personal List');
        $('#list').val('<?php echo $username ?>');
        showOverlay()
    });
    $('#add_flat').on('click', function(){
        $('#heading').html('Flat List');
        $('#list').val('flat');
        showOverlay()
    });   
    $("#overlay_backing").on('click',function(event){
        if (event.target.id === 'overlay_backing' || event.target.id === 'close_button'){
            hideOverlay();
        }
    });
    
    function showOverlay(){
        $('#overlay').fadeIn('fast');
        $('#overlay_backing').fadeIn('fast');
    }
    function hideOverlay(){
        $('#overlay').fadeOut('fast');
        $('#overlay_backing').fadeOut('fast');
    }
    
    function addItem(){
        <?php
        echo $this->Js->request(['controller' => 'ShoppingLists', 'action' => 'addItem'] , [
            'async' => true,
            'method' => 'post',
            'data' => '{name: $("#name").val(), quantity: $("#quantity").val(), list: $("#list").val()}',
            'dataExpression' => true,
            'update' => 'body']);
        ?>
        return false;
    }
    
    function clearList(list){
        <?php
        echo $this->Js->request(['controller' => 'ShoppingLists', 'action' => 'clearList'] , [
            'async' => true,
            'method' => 'post',
            'data' => '{list: list}',
            'dataExpression' => true,
            'update' => 'body']);
        ?>
        return false;
    }
    function clearItem(id){
        <?php
        echo $this->Js->request(['controller' => 'ShoppingLists', 'action' => 'clearItem'] , [
            'async' => true,
            'method' => 'post',
            'data' => '{id: id}',
            'dataExpression' => true,
            'update' => 'body']);
        ?>
        return false;   
    }
    function strike(event){
        if ($(event.target).is(":checked")){
            $(event.target).parent().attr('style', 'text-decoration: line-through;');
        } else {
            $(event.target).parent().attr('style', 'text-decoration: none;');
        }
    }
</script>