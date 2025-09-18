<?php
// PHP 8 compatibility shims for legacy PHP 5.3 codebase.

if (!function_exists('set_magic_quotes_runtime')) {
    function set_magic_quotes_runtime($new_setting) { return false; }
}

if (!function_exists('ereg')) {
    function ereg($pattern, $string, &$regs = null) {
        $pattern = '/'.str_replace('/', '\/', $pattern).'/';
        $ok = preg_match($pattern, $string, $m);
        if ($ok && is_array($regs)) { $regs = $m; }
        return $ok;
    }
}
if (!function_exists('eregi')) {
    function eregi($pattern, $string, &$regs = null) {
        $pattern = '/'.str_replace('/', '\/', $pattern).'/i';
        $ok = preg_match($pattern, $string, $m);
        if ($ok && is_array($regs)) { $regs = $m; }
        return $ok;
    }
}
if (!function_exists('split')) {
    function split($pattern, $string, $limit = -1) {
        $pattern = '/'.str_replace('/', '\/', $pattern).'/';
        return preg_split($pattern, $string, $limit);
    }
}

// Polyfill for each(): returns current key/value and advances array pointer.
if (!function_exists('each')) {
    function each(&$array) {
        $key = key($array);
        if ($key === null) return false;
        $value = current($array);
        next($array);
        return array(1 => $value, 'value' => $value, 0 => $key, 'key' => $key);
    }
}
?>
