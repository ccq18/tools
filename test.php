<?php
// $p = '/api/2.0/midnight-draw/count-down?vendorId=141357&appId=100016&timestamp=1512699466&sign=eWyDAVBPBd6wGgxpMH%2FgWhX85AoSM4F0aeJalG53wdQ%3D&token=DmpEP7619dHjRMiYiYOpWX8lvC2E+v47JoMkN/QEeybhy5c6kk9JRJdrpfhZF/c0DkqWsdD7S+alvi/3RoCVHHAt+Z7Me9CpoA2MXv2Ouvu/JvhO91s5sTW4GI/8iZwv';
// $rs = preg_match('/(\/api\/2\.0[a-zA-z\/0-9\-]+)/',$p,$match);
// var_dump($match);

for($i=0;$i<=100000;$i++){
    if($i%10000==0){
        echo $s;
        $s = '';
    }
    $s.= '<div>1</div>';
    // echo '<div>1</div>';

}
echo $s;

