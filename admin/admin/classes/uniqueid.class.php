<?php
class Uniqueid{

    public function gera_id(){
        $timestamp = time("U");
        $microtime = microtime();
        $matches = md5(sha1($timestamp.$microtime));

        return $matches;
    }

}
?>
