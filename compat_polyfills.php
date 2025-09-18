<?php
/**
 * PHP 5.x → 7/8 compatibility shims
 * Loaded via auto_prepend_file in php.ini (see Dockerfile).
 */

// --- mysql_* to mysqli shims (very simple global-connection mapping) ---
if (!function_exists('mysql_connect')) {
    $GLOBALS['__mysql_default_link'] = null;

    function mysql_connect($host=null, $user=null, $pass=null, $new_link=false, $client_flags=0) {
        $link = @mysqli_connect($host ?: ini_get("mysqli.default_host"),
                                $user ?: ini_get("mysqli.default_user"),
                                $pass ?: ini_get("mysqli.default_pw"));
        if ($link) { $GLOBALS['__mysql_default_link'] = $link; }
        return $link;
    }
    function mysql_pconnect($host=null, $user=null, $pass=null, $client_flags=0) {
        // mysqli doesn't support persistent by default in this image; fallback to mysql_connect
        return mysql_connect($host, $user, $pass);
    }
    function mysql_select_db($dbname, $link_identifier=null) {
        $lnk = $link_identifier ?: $GLOBALS['__mysql_default_link'];
        return @mysqli_select_db($lnk, $dbname);
    }
    function mysql_query($query, $link_identifier=null) {
        $lnk = $link_identifier ?: $GLOBALS['__mysql_default_link'];
        return @mysqli_query($lnk, $query);
    }
    function mysql_fetch_assoc($result) { return @mysqli_fetch_assoc($result); }
    function mysql_fetch_array($result, $result_type=MYSQLI_BOTH) { return @mysqli_fetch_array($result, $result_type); }
    function mysql_fetch_row($result) { return @mysqli_fetch_row($result); }
    function mysql_fetch_object($result, $class_name='stdClass', $params=[]) { return @mysqli_fetch_object($result, $class_name, $params); }
    function mysql_num_rows($result) { return @mysqli_num_rows($result); }
    function mysql_insert_id($link_identifier=null) {
        $lnk = $link_identifier ?: $GLOBALS['__mysql_default_link'];
        return @mysqli_insert_id($lnk);
    }
    function mysql_real_escape_string($escapestr, $link_identifier=null) {
        $lnk = $link_identifier ?: $GLOBALS['__mysql_default_link'];
        return @mysqli_real_escape_string($lnk, $escapestr);
    }
    function mysql_escape_string($escapestr) {
        $lnk = $GLOBALS['__mysql_default_link'];
        return $lnk ? @mysqli_real_escape_string($lnk, $escapestr) : addslashes($escapestr);
    }
    function mysql_error($link_identifier=null) {
        $lnk = $link_identifier ?: $GLOBALS['__mysql_default_link'];
        return $lnk ? @mysqli_error($lnk) : '';
    }
    if (!defined('MYSQL_ASSOC')) define('MYSQL_ASSOC', MYSQLI_ASSOC);
    if (!defined('MYSQL_NUM')) define('MYSQL_NUM', MYSQLI_NUM);
    if (!defined('MYSQL_BOTH')) define('MYSQL_BOTH', MYSQLI_BOTH);
}

// --- ereg / ereg_replace shims (basic POSIX→PCRE bridge) ---
if (!function_exists('ereg')) {
    function __posix_to_pcre($pattern) {
        // naive wrap with delimiters if not present
        $del = '/';
        // escape delimiter inside pattern
        $p = str_replace($del, r'\/', $pattern);
        return $del . $p . $del;
    }
    function ereg($pattern, $string, &$regs=null) {
        $ok = preg_match(__posix_to_pcre($pattern), $string, $m);
        if ($regs !== null) $regs = $m;
        return $ok;
    }
    function eregi($pattern, $string, &$regs=null) {
        $ok = preg_match(__posix_to_pcre('(?i)'.$pattern), $string, $m);
        if ($regs !== null) $regs = $m;
        return $ok;
    }
    function ereg_replace($pattern, $replace, $string) {
        return preg_replace(__posix_to_pcre($pattern), $replace, $string);
    }
    function eregi_replace($pattern, $replace, $string) {
        return preg_replace(__posix_to_pcre('(?i)'.$pattern), $replace, $string);
    }
}

// --- split shim ---
if (!function_exists('split')) {
    function split($pattern, $string, $limit=-1) {
        return preg_split(__posix_to_pcre($pattern), $string, $limit);
    }
}

// --- each shim ---
if (!function_exists('each')) {
    function each(&$array) {
        $key = key($array);
        if ($key === null) return false;
        $value = current($array);
        next($array);
        return array($key, $value, 'key' => $key, 'value' => $value);
    }
}

// --- get_magic_quotes_* shims ---
if (!function_exists('get_magic_quotes_gpc')) {
    function get_magic_quotes_gpc(){ return 0; }
}
if (!function_exists('get_magic_quotes_runtime')) {
    function get_magic_quotes_runtime(){ return 0; }
}
if (!function_exists('set_magic_quotes_runtime')) {
    function set_magic_quotes_runtime($new_setting){ return false; }
}

// --- HTTP_RAW_POST_DATA compatibility ---
if (!isset($HTTP_RAW_POST_DATA)) {
    $HTTP_RAW_POST_DATA = file_get_contents('php://input');
}

// --- preg_replace with /e compatibility helper (opt-in) ---
if (!function_exists('preg_replace_eval')) {
    function preg_replace_eval($pattern, $replacement, $subject) {
        // Convert '/.../e' to callback with eval on $replacement
        $pcre = $pattern;
        // strip trailing e modifier if present
        if (@preg_match('/^(.+?)e([a-z]*)$/i', $pattern, $pm)) {
            $pcre = $pm[1] . $pm[2];
        }
        return preg_replace_callback($pcre, function($m) use ($replacement) {
            // expose $m and $matches for legacy code
            $matches = $m;
            // WARNING: eval is potentially dangerous; keep legacy semantics
            return eval('return ' . $replacement . ';');
        }, $subject);
    }
}
?>
