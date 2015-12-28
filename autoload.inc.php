<?php

namespace XiaoFei\Fanhuaji\Autoload;

const PREFIX = "XiaoFei\\Fanhuaji\\";

// register autoload functions
spl_autoload_register(__NAMESPACE__.'\load');

////////////////////////
// autoload functions //
////////////////////////

function load ($className) {
    if (strpos($className, PREFIX) !== 0) return false;
    stripPrefix($className);
    $incl_path = __DIR__;
    $file_exts = '.php';
    loader($incl_path, $className, $file_exts);
}

//////////
// misc //
//////////

function stripPrefix (&$className) {
    $className = explode(PREFIX, $className, 2);
    if (empty($className[0])) unset($className[0]);
    $className = implode(PREFIX, $className);
}

function loader (&$incl_path, &$className, &$file_exts) {
    $className = strtr(ltrim($className, "\\"), "\\", DIRECTORY_SEPARATOR);
    $incl_path = rtrim($incl_path, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
    $file_exts = explode(',', $file_exts);
    foreach ($file_exts as &$file_ext) {
        $file = "{$incl_path}{$className}{$file_ext}";
        if (is_file($file)) {
            include $file;
        }
    }
}
