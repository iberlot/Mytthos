<?php
/**
 * @author iberlot
 * @version 20151223
 * @package Mytthos
 * @category Config
 *
 *
 * Este archivo se encargara de contener e inicializar todas las variables
 * de configuracion que va a utilizar el sistema
 */

header ('Content-Type: text/html;charset=utf-8');

date_default_timezone_set ('America/Buenos_Aires');

$dirAutores = "/Biblioteca";

session_start ();

$host = 'mysql.hostinger.com.ar';
$username = 'u530625595_ivan';
$password = 'JuliaMatilde';
$database = 'u530625595_libro';

$configured = 1;
$logging = TRUE;
$logfile = 'log.txt';
$allowcommands = TRUE;
$debug = "1";
$debugfile = 'debug.txt';
?>