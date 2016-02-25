<?php

/**
 * A helper class for multi-byte string.
 * Because UTF-8 is not fix-width, I believe mb_substr() is O(n) with it.
 * Using iconv() to make it UTF-32 and work with substr() is O(1) hence this class.
 * @require libiconv (mostly supplied in modern OS)
 * @version v1.0.1
 * @author 小斐 <admin@2d-gate.org>
 */

namespace XiaoFei\Fanhuaji\DataType;

class MbString extends \ArrayObject {
    // this is an internal UTF-32 version multi-bytes string class
    // UTF-32 is a fix-width encoding (1 char = 4 bytes)
    // we do not use mb_ functions in this class
    // note that the first 4 bytes in UTF-32 are headers (endian bytes)

    private $_str; // in UTF-32, without endian bytes
    private $encoding; // the original encodinge
    private $header; // the endian bytes for UTF-32

    // ctor
    public function __construct ($str='', $encoding='UTF-8') {
        $this->encoding = $encoding;
        $this->val($str);
        $this->header = substr(iconv($encoding, 'UTF-32', ' '), 0, 4);
    }

    // dtor
    public function __destruct () { }

    // getter and setter
    public function val ($str=null) {
        if (is_null($str)) {
            return $this->outputConv($this->_str);
        } else {
            $this->_str = $this->inputConv($str);
        }
    }

    ///////////////////////////////////
    // string manipulation functions //
    ///////////////////////////////////

    public function stripos ($needle, $offset=0) {
        $needle = $this->inputConv($needle);
        $pos = stripos($this->_str, $needle, $offset<<2);
        return is_bool($pos) ? $pos : $pos>>2;
    }

    public function strlen () {
        return strlen($this->_str) >> 2;
    }

    public function strpos ($needle, $offset=0) {
        $needle = $this->inputConv($needle);
        $pos = strpos($this->_str, $needle, $offset<<2);
        return is_bool($pos) ? $pos : $pos>>2;
    }

    public function substr ($start, $length=null) {
        return $this->outputConv(
            is_null($length) ? substr($this->_str, $start<<2)
                             : substr($this->_str, $start<<2, $length<<2)
        );
    }

    public function substr_replace ($replacement, $start, $length=null) {
        $replacement = $this->inputConv($replacement);
        return $this->outputConv(
            is_null($length) ? substr_replace($this->_str, $replacement, $start<<2)
                             : substr_replace($this->_str, $replacement, $start<<2, $length<<2)
        );
    }

    public function strtolower () {
        return strtolower($this->outputConv($this->_str));
    }

    public function strtoupper () {
        return strtoupper($this->outputConv($this->_str));
    }

    ////////////////////////////////
    // non-manipulative functions //
    ////////////////////////////////

    public function at ($idx) {
        return $this->outputConv(
            substr($this->_str, $idx<<2, 4)
        );
    }

    public function atRaw ($idx) {
        return substr($this->_str, $idx<<2, 4);
    }


    public function has ($needle) {
        $needle = $this->inputConv((string) $needle);
        return strpos($this->_str, $needle) !== false;
    }

    public function startsWith ($needle) {
        $needle = $this->inputConv((string) $needle);
        return $needle === substr($this->_str, 0, strlen($needle));
    }

    public function endsWith ($needle) {
        $needle = $this->inputConv((string) $needle);
        return $needle === substr($this->_str, -strlen($needle));
    }

    /////////////////////////////////////////////
    // those functions will not return a value //
    /////////////////////////////////////////////

    public function str_insert_i ($insert, $position) {
        $insert = $this->inputConv($insert);
        $this->_str = substr_replace($this->_str, $insert, $position<<2, 0);
    }

    public function str_enclose_i ($closures, $start, $length=null) {
        // ex: $closures = array('{', '}');
        foreach ($closures as &$closure) $closure = $this->inputConv($closure);
        if (count($closures) == 1) $closures[1] = &$closures[0];
        if (is_null($length)) {
            $replacement = $closures[0].substr($this->_str, $start<<2).$closures[1];
            $this->_str = substr_replace($this->_str, $replacement, $start<<2);
        } else {
            $replacement = $closures[0].substr($this->_str, $start<<2, $length<<2).$closures[1];
            $this->_str = substr_replace($this->_str, $replacement, $start<<2, $length<<2);
        }
    }

    public function str_replace_i ($search, $replace) {
        $search  = $this->inputConv($search);
        $replace = $this->inputConv($replace);
        $this->_str = str_replace($search, $replace, $this->_str);
    }

    public function substr_replace_i ($replacement, $start, $length=null) {
        $replacement = $this->inputConv($replacement);
        $this->_str = (
            is_null($length) ? substr_replace($this->_str, $replacement, $start<<2)
                             : substr_replace($this->_str, $replacement, $start<<2, $length<<2)
        );
    }

    ////////////////////
    // misc functions //
    ////////////////////

    // convert the output string to its original encoding
    private function outputConv ($str) {
        return iconv('UTF-32', $this->encoding, "{$this->header}{$str}");
    }

    // convert the input string to UTF-32 without header
    private function inputConv ($str) {
        // we don't want the header so first 4 bytes are stripped
        return substr(iconv($this->encoding, 'UTF-32', (string) $str), 4);
    }

    /////////////////////////////////////////////////
    // DO NOT use the following functions directly //
    /////////////////////////////////////////////////

    public function offsetSet ($idx, $char) {
        if (is_null($char)) $char = "\0";
        $char = $this->inputConv($char);
        if (strlen($char) > 4) $char = substr($char, 0, 4);
        $spacesPrepend = $idx - $this->strlen();
        // set index (out of bound)
        if ($spacesPrepend > 0) {
            $this->_str .= $this->inputConv(str_repeat(' ', $spacesPrepend)).$char;
        // set index (in bound)
        } else {
            $this->_str = substr_replace($this->_str, $char, $idx<<2, 4);
        }
    }

    public function offsetGet ($idx) {
        return $this->at($idx);
    }

    public function offsetExists ($idx) {
        return is_int($idx) ? $this->strlen()>=$idx : false;
    }

    public function append ($str) {
        $this->_str .= $this->inputConv($str);
    }

    public function count () {
        return $this->strlen();
    }

    //////////////////////
    // static functions //
    //////////////////////

    public static function static_strlen ($str, $encoding='UTF-8') {
        return strlen(substr(iconv($encoding, 'UTF-32', $str), 4)) >> 2;
    }

}
