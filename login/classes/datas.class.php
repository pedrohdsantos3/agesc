<?php



/*

 * To change this template, choose Tools | Templates

 * and open the template in the editor.

 */



/**

 * Description of validacao



 */

class Datas {

    //put your code here

       public function ConvertePb($date){
           
           $rData = implode("-", array_reverse(explode("/", trim($date))));
           return $rData;
           
       }
       
       public function formataPSC($date){
           
           $data = str_split($date, 2);
           $datafinal = "00"."/".$data[0]."/".$data[1].$data[2];
           
          
           
           return $datafinal;
           
       }
       
       public function formatMPag($date){
           
           $data = explode("-", trim($date));
           $dataF = $data[0]."-".($data[1]-1)."-00";
           
           
           return $dataF;
           
       }

        public function ConverteParaBR($date){
           
           $rData = implode("/", array_reverse(explode("-", trim($date))));
           return $rData;
           
       }

}



?>

