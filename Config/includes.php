<?php
/**
 * @author iberlot
 * @version 20151223
 * @package Mytthos
 * @category Config
 *
 * Este archivo se encargara de contener todos los includes
 * que va a utilizar el sistema
 *
 */

include_once ("Config/variables.php"); // incluimos el archivo que contiene las variables
                                      // include_once("Config/control_session.php");
include_once ("Config/config.php"); // incluimos el archivo de configuracion
include_once ("Config/conect.php"); // incluimos el archivo de conexion
include_once ("Config/funciones.php"); // incluimos el archivo que va a contener todas las funciones del sistem
include_once ("Config/styles.css");
include_once ("inc/header.php"); // incluimos el archivo que contiene la cabezera
include_once ("inc/footer.php"); // incluimos el archivo que contiene la cabezera

include_once("Config/analyticstracking.php");
?>