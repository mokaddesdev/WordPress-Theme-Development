<?php
/**
 * Number Format
 * 
 * @package lessonlms
 */

function lessonlms_count_number_format($numbers){
    if($numbers >= 1000000){
        return round($numbers/1000000, 1) . 'M';
    }elseif($numbers >= 1000){
        return round($numbers/1000, 1) . 'K';
    }else{
        return $numbers;
    }
}