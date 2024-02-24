<?php // index.php
    require_once('C:\Users\diego\OneDrive\Desktop\Hello World\OmokService\src\new\save.php');
    $pid = $_GET["pid"];
    $x = $_GET["x"];
    $y = $_GET["y"];
    // echo("pid=".$pid."&x=".$x."&y=".$y);
    
    $pids = new new_Game();
    $id_s = $pids -> showNotes();
    
    for( $i = 0; $i < sizeof($id_s); $i++ ){ //eliminates any trash in the player ids
        $id_s[$i] = trim($id_s[$i]);
    }
    if($pid){
        if(in_array(trim($pid),$id_s)){ //compares pids removing trash that could afffect the comparing
            if($x){
                if($y){
                    if($y>14){
                        echo('{"response": false, "reason": "Invalid y coordinate '. $y.'}');
                    }elseif($x>14){
                        echo('{"response": false, "reason": "Invalid x coordinate '. $x.'}');
                    }
                    else{
                        echo('succesfully make a movement');
                    }
                }elseif(!$y){
                    echo('{"response": false, "reason": "y not specified"}');
                }
            }else{
                echo('{"response": false, "reason": "x not specified"}');
            }

        }else{
            echo('{"response": false, "reason": "Unknown pid"}');
        }
    }else{
        echo('{"response": false, "reason": "Pid not specified"}');
    }
  

    
    
    
?>