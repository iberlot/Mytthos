<?php
/**
 * @author iberlot
 * @version 20151223
 * @package Mytthos
 * @category Config
 *
 * Listado con todas las funciones utilizadas por el sistema 
 */


function codificacion($texto)
{
	$c = 0;
	$ascii = true;
	for($i = 0; $i < strlen ($texto); $i ++)
	{
		$byte = ord ($texto [$i]);
		if ($c > 0)
		{
			if (($byte >> 6) != 0x2)
			{
				return ISO_8859_1;
			}
			else
			{
				$c --;
			}
		}
		elseif ($byte & 0x80)
		{
			$ascii = false;
			if (($byte >> 5) == 0x6)
			{
				$c = 1;
			}
			elseif (($byte >> 4) == 0xE)
			{
				$c = 2;
			}
			elseif (($byte >> 3) == 0x1E)
			{
				$c = 3;
			}
			else
			{
				return ISO_8859_1;
			}
		}
	}
	return ($ascii) ? ASCII : UTF_8;
}

function utf8_encode_seguro($texto)
{
	return (codificacion ($texto) == ISO_8859_1) ? utf8_encode ($texto) : $texto;
}
?>