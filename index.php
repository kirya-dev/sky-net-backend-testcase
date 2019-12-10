<?php
/**
 * This application developed specially for backed test case into SkyNet company.
 *
 * @author Kirill Matasov kirill.matasov@immelman.ru
 */
require __DIR__ . '/db_cfg.php';
require __DIR__ . '/System/autoloader.php';


$kernel = new System\Kernel;
echo $kernel->handle();
