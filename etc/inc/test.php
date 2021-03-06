<?php
/**
 * Copyright © MIKO LLC - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by Alexey Portnov, 2 2020
 */

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require_once 'globals.php';
$g['booting']   = true;

unset($errorLogger,$g['error_logger']);
Util::get_pid_process('udhcp', '');

$if_name = 'eth1';
$pid_file= "/var/run/udhcpc_{$if_name}";
$pid_pcc = Util::get_pid_process($pid_file);
if(!empty($pid_pcc)){
    // Завершаем старый процесс.
    system("kill `cat {$pid_file}` {$pid_pcc}");
}

exit(0);

if(count($argv)===1){
    $g['booting']   = false;
    Cdr::create_db();
    Util::CreateLogDB();

    $pbx = new PBX();
    $pbx::stop();
    $pbx->configure();

    Firewall::reload_firewall();

}elseif (count($argv)===3){
    // php -f /etc/inc/test.php ModuleSmartIVR InstallDB
    // php -f /etc/inc/test.php ModuleSmartIVR unInstallDB
    // php -f /etc/inc/test.php ModuleCTIClient unInstallDB
    // php -f /etc/inc/test.php ModuleCTIClient InstallDB

    // php -f /etc/inc/test.php ModuleAutoprovision InstallDB
    // php -f /etc/inc/test.php ModuleCallTracking InstallDB
    // php -f /etc/inc/test.php ModuleTelegramNotify InstallDB
    // php -f /etc/inc/test.php ModuleTelegramNotify unInstallDB
    // php -f /etc/inc/test.php ModuleAdditionalWebAPI InstallDB
    // php -f /etc/inc/test.php ModuleAdditionalWebAPI unInstallDB

    // php -f /etc/inc/test.php ModuleWebConsole InstallDB

    // php -f /etc/inc/test.php ModuleBitrix24Notify InstallDB
    // php -f /etc/inc/test.php ModuleBitrix24Integration installModule
    // php -f /etc/inc/test.php ModuleBitrix24Integration uninstallModule
    // php -f /etc/inc/test.php ModuleBitrix24Integration uninstallModule
    $module = $argv[1] ?? '';
    $action = $argv[2] ?? '';
    $path_class = "\\Modules\\{$module}\\setup\\PbxExtensionSetup";
    if(!class_exists($path_class)){
        $path_class = false;
        echo "Класс не существует.. $path_class";
        exit(1);
    }

    $setup    = new $path_class();
    $response = $setup->$action();
}
