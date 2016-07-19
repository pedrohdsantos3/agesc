<?php
        
        
                     $__campos = array("user", "senha");
                    
                    foreach($__campos as $c){
                        $_v_=isset($_POST[$c])?$_POST[$c]:"";
                        
                        if(is_string($_v_))
                            $_v_=trim($_v_);
                        $GLOBALS[$c]=$_v_;
                    }
                    unset($_v_);
            
        
?>