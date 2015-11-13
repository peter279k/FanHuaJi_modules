<?php

namespace XiaoFei\Fanhuaji\Module\Helper;

trait ModuleTrait {

    /**
     * check a given string is a regex or not
     * @param  string  $str [the given string]
     * @return boolean      [true/false = the given string is/isn't regex]
     */
    private function isRegex ($str) {
        return preg_match('/[\\\[\](){}+\-|!?:=.*<^]/uS', $str) === 1;
    }

    /**
     * calculate the average value of a given array
     * @param  array   $a [the given array]
     * @return number     [the average value]
     */
    private function average (array $a) {
        return array_sum($a) / count($a);
    }

    /**
     * calculate the standard deviation of a given array
     * @param  array   $a      [the given array]
     * @param  boolean $sample [true/false = sample/population standard deviation]
     * @return number          [the standard deviation]
     */
    private function standardDeviation (array $a, $sample=false) {
        $n = count($a);
        if ($n === 0) {
            trigger_error("The array has no element!", E_USER_WARNING);
            return false;
        }
        if ($sample && $n === 1) {
            trigger_error("The array has only 1 element!", E_USER_WARNING);
            return false;
        }
        $mean = array_sum($a) / $n;
        $carry = 0.0;
        foreach ($a as &$val) {
            $d = $val - $mean;
            $carry += $d * $d;
        }
        if ($sample) --$n;
        return sqrt($carry / $n);
    }

    /**
     * remove outliers elements from an array
     * @param  array   $a         [the input array]
     * @param  integer $magnitude [elements should be removed if they out of how many standard deviations?]
     * @return array              [the array with outliers removed]
     */
    private function removeOutliers (array $a, $magnitude=1) {
        $n = count($a);
        if ($n === 0) return [];
        $mean = $this->average($a);
        // calculate standard deviation and times by magnitude
        $deviation = $this->standardDeviation($a) * $magnitude;
        // return filtered array of values that lie within $mean +- $deviation.
        return array_filter($a, function ($x) use (&$mean, &$deviation) {
            return $mean-$deviation < $x && $x < $mean+$deviation;
        });
    }

}
