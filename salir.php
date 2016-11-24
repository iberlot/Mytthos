<?php
/**
 * @author iberlot
 * @version 20151223
 * @package Mytthos
 * @category config
 *
 * Destructor de la session
 *
 */

session_start ();
session_destroy ();

header ("location:index.php");

?>