<?php
include('save.php');
define('STRATEGY', 'strategy'); // constant
$strategies = ["Smart", "Random"]; // supported strategies
if (!array_key_exists(STRATEGY, $_GET)) { 
        
    $response = array("response" => false, "reason" => "Strategy not specified");
    echo json_encode($response);
    exit; 
}
else{
    $strategy = $_GET[STRATEGY];
    if($strategy===$strategies[0] or $strategy===$strategies[1] ){
        $game = new new_Game();
        $pid=uniqid();
        echo '{"response": true, "pid": '. $pid. '}';
        $game->savePid($pid);
    }
    else{
        echo '{"response": false, "reason": "Unknown strategy"}';
    }

}
?>


