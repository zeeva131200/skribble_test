<?php

function findFrequency($str)
{
    $letters = [];

    $maxValue = 0;
    $minValue = PHP_INT_MAX;
    $maxKey = '';
    $minKey = '';
    $maxKeys = [];
    $minKeys = [];

    //store the occurence of characters
    for ($i = 0; $i < strlen($str); $i++) {
        $c = $str[$i];
        if (isset($letters[$c])) {
            $letters[$c]++;
        } else {
            $letters[$c] = 1;
        }
    }

    //count max and min
    foreach ($letters as $key => $value) {
        if ($value > $maxValue) {
            $maxValue = $value;
            $maxKey = $key;
            $maxKeys = [$key]; // Reset maxKeys array with the new max character
        } elseif ($value == $maxValue && $key > $maxKey) {
            $maxKey = $key;
            $maxKeys[] = $key;
        } elseif ($value == $maxValue) {
            $maxKeys[] = $key;
        }

        if ($value < $minValue) {
            $minValue = $value;
            $minKey = $key;
            $minKeys = [$key];
        } elseif ($value == $minValue && $key > $minKey) {
            $minKey = $key;
            $minKeys[] = $key;
        } elseif ($value == $minValue) {
            $minKeys[] = $key;
        }
    }

    // foreach($letters as $key => $value){
    //     echo "key: ".$key." value: ".$value."\n";
    // }


    echo "Most times = '" . $maxKey . "'";
    if (count($maxKeys) > 1) {
        if (count($maxKeys) == 2) {
            $notChosenKey = ($maxKeys[0] == $maxKey) ? $maxKeys[1] : $maxKeys[0];
            echo "\n'" . implode("', '", $maxKeys) . "' occur " . $maxValue . " times each, but the answer is '" . $maxKey . "' because '" . $maxKey . "' is alphabetically bigger than '" . $notChosenKey . "'\n";
        } else {
            echo "\n'" . implode("', '", $maxKeys) . "' occur " . $maxValue . " times each, but the answer is '" . $maxKey . "' because '" . $maxKey . "' is alphabetically bigger than the rest \n";
        }
    } else {
        echo "', because '" . $maxKey . "' occurs " . $maxValue . " times.\n";
    }

    echo "<br>Least times = '" . $minKey . "'";
    if (count($minKeys) > 1) {
        if (count($minKeys) == 2) {
            $notChosenKey = ($minKeys[0] == $minKey) ? $minKeys[1] : $minKeys[0];
            echo "\n'" . implode("', '", $minKeys) . "' occur " . $minValue . " times each, but the answer is '" . $minKey . "' because '" . $minKey . "' is alphabetically bigger than '" . $notChosenKey . "'.\n";
        } else {
            echo "\n'" . implode("', '", $minKeys) . "' occur " . $minValue . " times each, but the answer is '" . $minKey . "' because '" . $minKey . "' is alphabetically bigger than the rest. \n";
        }
    } else {
        echo "', because '" . $minKey . "' occurs " . $minValue . " times.\n";
    }
}

//$str = "embezzlement";
$str = "aabb";
findFrequency($str);
?>