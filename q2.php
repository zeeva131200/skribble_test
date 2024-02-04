<?php

function findFrequency($str)
{

    $boolean = "";
    $positions = [];
    $start = -1;
    $end = -1;
    $sum = 0;
    $count = 0;

    //find the numbers
    for ($i = 0; $i < strlen($str); $i++) {
        if (is_numeric($str[$i])) {
            $positions[] = $i;
        }
    }

    //if no digits or only 1 digit but !=7
    if (count($positions) == 1 && $str[$positions[0]] != '7') {
        return FALSE;
    }
    //check for the conditions
    for ($i = 0; $i < count($positions) - 1; $i++) {
        $start = $positions[$i];  //get the position of number
        $end = $positions[$i + 1];
        $sum = (int)$str[$start] + (int)$str[$end];  //get the actual number

        //1. check for sum
        if ($sum == 7) {
            $count = 0; //reset count

            //2. check dollar sign count
            for ($j = $start + 1; $j < $end; $j++) {
                if ($str[$j] === '$') {
                    $count++;
                }
            }


            //if count is < 4, return false
            if ($count < 4) {
                return FALSE;
            }
        }
    }

    //additional check - if only 1 digit and = 7
    if (count($positions) == 1 && $str[$positions[0]] == '7') {
        $count = 0;
        for ($i = $positions[0] + 1; $i < strlen($str); $i++) {
            if ($str[$i] === '$') {
                $count++;
            }
        }

        //if count is < 4, return false
        if ($count < 4) {
            return FALSE;
        }
    }
    return TRUE;
}

//$str  = 'D u g $ 7 $ $ b h $ $ 0 P y 1 $$$$$ 5';
//$str = 'K d 7 $$$ns$$$f';
$str = 'B3$4knf5k$$m$$$2';
//$str = 'cp4$$$$$$9k6$$$1k'; 
$result = findFrequency($str);
echo $result ? 'TRUE' : 'FALSE';
?>