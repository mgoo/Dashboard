<?php echo $this->Html->css('chores'.getenv('Chores_CSS_Version')); ?>
<h1>Dishes:</h1>
<script>
    $('document').ready(function(){
        var date = new Date();

        var startDate = new Date();
        startDate.setDate(21);
        startDate.setYear(2016);
        startDate.setMonth(1);
        $('#'+getDayString(date) + ' td:nth-child(2)').addClass('currentDay');       
       
        var i = 1;
        while (date.getDay()-i >= 0){
            var temp = new Date();
            var temp1 = new Date(date.getTime());
            temp1.setDate(date.getDate()-(i+4));
            temp.setDate(date.getDate()-i);            
            $('#'+getDayString(temp) + ' td:nth-child(2)').html(dishersRoster(temp1, startDate));
            if (dishersRoster(temp1, startDate).indexOf("<?php echo $current_user[0]['User']['first_name']; ?>") !== -1 ){
                $('#'+getDayString(temp) + ' td:nth-child(2)').addClass('currentPerson');                
            }
            i++;
        }        
                     
        for (var td = 2; td <= 3;td++){
            i = 0;             
            do {                
                temp = new Date(date.getTime());
                temp.setDate(date.getDate()+i);
                $('#'+getDayString(temp) + ' td:nth-child(' + td + ')').html(dishersRoster(temp, startDate));
                if (dishersRoster(temp, startDate).indexOf("<?php echo $current_user[0]['User']['first_name']; ?>") !== -1 ){
                    $('#'+getDayString(temp) + ' td:nth-child(' + td + ')').addClass('currentPerson');                
                }
                i++;               
            } while ((date.getDay()+i) % 7 !== 0)
            date = new Date(temp.getTime());
            date.setDate(date.getDate()+1);
        }
        
    });
</script>
<table class="roster">
    <tr id="Sun">
        <td>Sun</td>
        <td>a</td>
        <td>a</td>
    </tr>
    <tr id="Mon">
        <td>Mon</td>
        <td>a</td>
        <td>a</td>
    </tr>
    <tr id="Tues">
        <td>Tues</td>
        <td>a</td>
        <td>a</td>
    </tr>
    <tr id="Wed">
        <td>Wed</td>
        <td>a</td>
        <td>a</td>
    </tr>
    <tr id="Thurs">
        <td>Thurs</td>
        <td>a</td>
        <td>a</td>
    </tr>
    <tr id="Fri">
        <td>Fri</td>
        <td>a</td>
        <td>a</td>
    </tr>
    <tr id="Sat">
        <td>Sat</td>
        <td>a</td>
        <td>a</td>
    </tr>
</table>

<script>
    function diffDay(date1, date2){
        var timeDiff = Math.abs(date2.getTime() - date1.getTime());
        var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
        return (diffDays);
    }
    function getDayString(date){
        switch(date.getDay()){
            case 0:
                return "Sun";
            case 1:
                return "Mon";
            case 2:
                return "Tues";
            case 3:
                return "Wed";
            case 4:
                return "Thurs";
            case 5:
                return "Fri";
            case 6:
                return "Sat";
        }
    }    
    
    function dishersRoster(date, startDate){
        switch (diffDay(date, startDate) % 4){
            case 0:
                return "Washing: <?php echo $users[2]['User']['first_name']; ?><br>Drying: <?php echo $users[1]['User']['first_name']; ?>";
            case 1:
                return "Washing: <?php echo $users[3]['User']['first_name']; ?><br>Drying: <?php echo $users[2]['User']['first_name']; ?>";
            case 2:
                return "Washing: <?php echo $users[0]['User']['first_name']; ?><br>Drying: <?php echo $users[3]['User']['first_name']; ?>";
            case 3:
                return "Washing: <?php echo $users[1]['User']['first_name']; ?><br>Drying: <?php echo $users[0]['User']['first_name']; ?>";
        }
    }
    </script>