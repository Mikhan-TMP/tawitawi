<meta http-equiv="refresh" content="5">
<style>
    .Available { background-color: #FFF; color: #000; }
    /* .Vacant { background-color: #ccc; color: #000; } */
    .Occupied { background-color: #C41E3A; color: #FFF; }

    .text{
        font-family: 'Verdana', serif;
    }
    body{
        background: url('<?= base_url('images/bglib.png'); ?>') no-repeat center center fixed;
    }
    .size{
        font-size: 9.5px;
    }
</style>

<body>

<div class="container-fluid m-0 p-0">
    <?php
    foreach ($areas as $area) {
        if (!empty($area['name'])) {
            echo "<div class='card m-2' style='background: #ffcf40; width: 1260px;'>
                <div class='card-header font-weight-bold m-0 pl-3 pb-1 pt-2'> {$area['name']}</div>
                <div class='card-body ml-3 mt-2 p-0'>
                    <div class='row justify-content-start'>";
                    
                    foreach ($area['list'] as $listItem) {
                        $num = $listItem['id'];
                        $status = $listItem['status'];
                        if($status == 'Occupied')
                        {
                            $timeRemaining = $listItem['timeRemaining'] ;    
                        }
                        else
                        {
                            $timeRemaining = "";
                        }
                        
                        echo generateSmallCard("{$area['name']} Card $num", $status, $num, $timeRemaining);
                    }
                    
            echo "</div></div></div>";
        }
    }
    
    function generateSmallCard($cardTitle, $status, $cardNumber, $timeRemaining) {
        $textColor = ($status == 'Occupied') ? 'text-white' : 'text-dark';
        return "
            <div class='size'>
                <div class='p-0 mr-1 mb-0' style='height: 60px; width: 55.5px;'>
                    <div class='card $status'>
                        <div class='card-body p-1 text-center $textColor' style='height: 50px; color: white;'>
                            <p class='card-number mb-1'>$cardNumber</p>
                            <p class='card-subtitle mb-0 $textColor'>$status</p>
                            <p class='card-number mb-0 $textColor'>$timeRemaining</p>
                        </div>
                    </div>
                </div>
            </div>
        ";
    }
    ?>
</div>

</body>
