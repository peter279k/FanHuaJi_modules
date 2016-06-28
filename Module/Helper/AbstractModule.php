<?php

/**
 * This is class is a standard for a module class.
 * @author 小斐 <admin@2d-gate.org>
 */

namespace XiaoFei\Fanhuaji\Module\Helper;

use XiaoFei\Fanhuaji\Core\Constants;
use XiaoFei\Fanhuaji\DataType\DataInput;
use XiaoFei\Fanhuaji\DataType\ModuleAnalysis;

abstract class AbstractModule implements Constants {

    ///////////////
    // interface //
    ///////////////

    // the conversion table: array('from1'=>'to1', ...)
    abstract public function conversion_table (ModuleAnalysis &$info);
    // load this module or not?
    abstract public function load_or_not (ModuleAnalysis &$info);
    // repeat replacement until there is no text changes?
    abstract public function loop_or_not ();

    ///////////
    // trait //
    ///////////

    use DictVariables;

    // module info
    public static $info = [
        'name' => 'defaultModuleName',
        'desc' => 'defaultDescription',
    ];

    // used to indicate module need to be forced enabled or disabled
    public static $needToBeForced = Constants::MODULE_NEED_TO_BE_FORCED_NO;

    /**
     * PSEUDO check a given string is a regex or not
     * this may be useful for detecting potential regex typos
     * @ref    http://php.net/manual/en/regexp.reference.meta.php
     * @param  string  $str [the given string]
     * @return boolean      [true/false = the given string is/isn't regex]
     */
    protected function isRegex ($str) {
        return strcspn($str, '\^$.[]|()?*+{}') < strlen($str);
    }

    /**
     * a general string replacing function using str_replace/preg_replace
     * @param  string  $search   [string/regex to search]
     * @param  string  $replace  [string/regex to be replaced with]
     * @param  string  &$subject [the original string]
     * @param  integer $limit    [maximum replacements could be performed]
     * @param  integer &$count   [replacement counts]
     * @return string            [the replaced string]
     */
    protected function strReplaceMixed ($search, $replace, $subject, $limit=-1, &$count=0) {
        $limit = (int) $limit;
        // if $search is a regex, use preg_replace
        if ($this->isRegex($search)) {
            $ret = preg_replace("/{$search}/uimS", $replace, $subject, $limit, $count);
            if (is_null($ret) && preg_last_error() == PREG_NO_ERROR) {
                // make debugging easier
                throw new \Exception("`{$search}` is not a legal regex");
            }
        // $search is not a regex and we want to replace all occurrences
        } else if ($limit < 0) {
            $ret = str_replace($search, $replace, $subject, $count);
        // $search is not a regex but we want to replace partial occurrences
        } else {
            $split = explode($search, $subject, $limit+1);
            $count = count($split) - 1;
            $ret = implode($replace, $split);
        }
        return $ret;
    }

    /**
     * a method to determine whether a module should be loaded or not
     * by using a keyword array, min keywords found, min average occurrence
     * and the standard deviation to filter outliers
     * @param string  &$text       [input text]
     * @param array   &$keywords   [keyword (regex or plain text) list]
     * @param integer $minKeywords [min average occurrence]
     * @param float   $minAvg      [min keywords found]
     * @param float   $stdDev      [standard deviation to filter outliers]
     */
    protected function LoadOrNotByKeywords (&$text, array &$keywords, $minKeywords=3, $minAvg=1.5, $stdDev=1.2) {
        // count all times of possible replacements
        $cntArray = [];
        foreach ($keywords as &$keyword) {
            if ($this->isRegex($keyword)) {
                preg_match_all("/{$keyword}/uim", $text, $matches);
                $cntArray[$keyword] = count($matches[0]);
            } else {
                $cntArray[$keyword] = substr_count($text, $keyword);
            }
        }
        // remove empty elements and outliers
        $cntArray = array_filter($cntArray);
        $cntArray = $this->removeOutliers($cntArray, $stdDev);
        return
            // too few types of conversion are performed
            count($cntArray) >= $minKeywords &&
            // not all conversion appears rarely
            $this->average($cntArray) >= $minAvg;
    }

    /**
     * calculate the average value of a given array
     * @param  array  &$array [the given array]
     * @return number         [the average value]
     */
    protected function average (array &$array) {
        return array_sum($array) / count($array);
    }

    /**
     * calculate the standard deviation of a given array
     * @param  array   &$array [the given array]
     * @param  boolean $sample [true/false = sample/population standard deviation]
     * @return number          [the standard deviation]
     */
    protected function standardDeviation (array &$array, $sample=false) {
        $n = count($array);
        if ($n === 0) {
            trigger_error("The array has no element!", E_USER_WARNING);
            return false;
        }
        if ($sample && $n === 1) {
            trigger_error("The array has only 1 element!", E_USER_WARNING);
            return false;
        }
        $mean = array_sum($array) / $n;
        $carry = 0.0;
        foreach ($array as &$val) {
            $diff = $val - $mean;
            $carry += $diff * $diff;
        }
        if ($sample) --$n;
        return sqrt($carry / $n);
    }

    /**
     * remove outliers elements from an array
     * @param  array   &$array    [the input array]
     * @param  integer $magnitude [elements should be removed if they out of how many standard deviations?]
     * @return array              [the array with outliers removed]
     */
    protected function removeOutliers (array &$array, $magnitude=1) {
        $n = count($array);
        if ($n === 0) return [];
        $mean = $this->average($array);
        // calculate standard deviation and times by magnitude
        $deviation = $this->standardDeviation($array) * $magnitude;
        // return filtered array of values that lie within $mean +- $deviation.
        return array_filter($array, function ($x) use (&$mean, &$deviation) {
            return $mean-$deviation < $x && $x < $mean+$deviation;
        });
    }

    /**
     * Utility function for getting random values with weighting.
     * Pass in an associative array, such as array('A'=>5, 'B'=>45, 'C'=>50)
     * An array like this means that "A" has a 5% chance of being selected, "B" 45%, and "C" 50%.
     * The return value is the array key, A, B, or C in this case.  Note that the values assigned
     * do not have to be percentages. The values are simply relative to each other. If one value
     * weight was 2, and the other weight of 1, the value with the weight of 2 has about a 66%
     * chance of being selected. Also note that weights should be integers.
     * @param  array &$array [an array whose values are positive integer weightings]
     * @return               [a randomly picked array key]
     */
    protected function getRandomWeightedElement (array &$array) {
        $rand = mt_rand(1, (int) array_sum($array));
        foreach ($array as $key => &$weighting) {
            $rand -= $weighting;
            if ($rand <= 0) {
                return $key;
            }
        }
    }

}
