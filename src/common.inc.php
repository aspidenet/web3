<?php
//  
// Copyright (c) ASPIDE.NET. All rights reserved.  
// Licensed under the GPLv3 License. See LICENSE file in the project root for full license information.  
//  
// SPDX-License-Identifier: GPL-3.0-or-later
//


setlocale(LC_ALL, "en_US.utf8");

require_once "../src/customs.inc.php";
require_once "../src/functions.inc.php";
if (get("custom", "none", $_GET) != "none") {
    $_SESSION["CUSTOM_CODE"] = get("custom", "default", $_GET);
}
$custom_code = get("CUSTOM_CODE", CUSTOM_CODE);
if (file_exists(BASE_DIR."/../web3-{$custom_code}/src/customs.inc.php")) {
    require_once(BASE_DIR."/../web3-{$custom_code}/src/customs.inc.php");
}
if ($custom_code != "default" && CUSTOM_CODE == "default") {
    $_SESSION["DB_NAME"] = "web3_".$custom_code;
    define("CURRENT_STATIC_URL", "/static/".$custom_code);   
}
else 
    define("CURRENT_STATIC_URL", STATIC_URL);

define('ADODB_ASSOC_CASE', 0);
require_once "../vendor/autoload.php";
// #require_once '../vendor/adodb/adodb-php/adodb-errorhandler.inc.php';
require_once '../vendor/adodb/adodb-php/adodb-exceptions.inc.php';
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
/*require_once "../src/classes/session.class.php";
require_once "../src/classes/db.class.php";
require_once "../src/classes/meta.class.php";
require_once "../src/classes/user.class.php";
require_once "../src/classes/result.class.php";

require_once "../src/classes/factory.class.php";
require_once "../src/classes/base.class.php";
require_once "../src/classes/field.class.php";
require_once "../src/classes/template.class.php";
require_once "../src/classes/wizard.class.php";
require_once "../src/classes/relation.class.php";
require_once "../src/classes/classtype.class.php";
require_once "../src/classes/ui.class.php";
require_once "../src/classes/html.class.php";
require_once "../src/classes/tablemanager.class.php";
require_once "../src/classes/tabulator.class.php";
# TEMP
require_once "../src/classes/x.class.php";*/



function my_autoload ($pClassName) {
    $custom_code = get("CUSTOM_CODE", CUSTOM_CODE);
    $filename = BASE_DIR."/../web3-{$custom_code}/src/classes/".strtolower($pClassName).".class.php";
    if (file_exists($filename)) {
        require_once($filename);
    }
    else {
        $filename = BASE_DIR."/src/classes/".strtolower($pClassName).".class.php";
        if (file_exists($filename)) {
            require_once($filename);
        }
    }
}
spl_autoload_register("my_autoload");

// $session = getSession();
// $session->log(spl_autoload_functions());

$db = null; # oggetto DB


#
# SSO login
#
/*if (!isset($_SESSION["SSO"])) {
    require_once('/var/simplesamlphp/lib/_autoload.php');
    $as = new \SimpleSAML\Auth\Simple('default-sp');
    // $as->requireAuth(array(
        // 'ReturnTo' => BASE_URL.ROOT_DIR
    // ));
    if ($as->isAuthenticated()) {
        $attributes = $as->getAttributes();
        if (count($attributes) > 0)
            $_SESSION["SSO"] = $attributes;
        #$session = getSession();
        #$session->log($attributes);
        #print_r($attributes);
        $user = new User();
        $user->load($attributes["uid"][0]);
        
        $_SESSION['USER'] = serialize($user);
        #print_r($user);
    }
    
    #$session->log($attributes);
}*/

function url_exists($url) {
    $ch = @curl_init($url);
    @curl_setopt($ch, CURLOPT_HEADER, TRUE);
    @curl_setopt($ch, CURLOPT_NOBODY, TRUE);
    @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    @curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    @curl_setopt($ch, CURLOPT_PROXY, PROXY);
    @curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    return ($code == 200);
}

function getRemoteFile($url) {
    $ch = @curl_init($url);
    @curl_setopt($ch, CURLOPT_HEADER, false);
    @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    @curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    @curl_setopt($ch, CURLOPT_PROXY, PROXY);
    $data = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($code != 200)
        return false;
    return $data;
}


################################################################################
# SendMail:
################################################################################
function SendMail($target, $subject, $message, $headers=null) {
    error_log("------------------------------------------------------------------------");
    error_log("Mail: ".$target);
    error_log($subject);
    error_log($message);
    error_log("------------------------------------------------------------------------");
}

# FUNZIONE SLUGIFY
function parseSearchInput($text) {
    $text = str_replace('@', 'XXXCHIOCCIOLAXXX', $text);
    $text = str_replace(" ", "XXXSPAZIOXXX", $text);
    
    // replace non letter or digits by ''
    $text = preg_replace('~[^\pL\d]+~u', '', $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text);

    // remove duplicate -
    $text = preg_replace('~-+~', '', $text);
    $text = str_replace('-', '', $text);
    
    $text = str_replace('XXXCHIOCCIOLAXXX', '@', $text);
    $text = str_replace('XXXSPAZIOXXX', '%', $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return '';
    }

    return $text;
}


#error_log('Load common;');