<?php
/**
 * @author iberlot
 * @version 20151223
 * @package Mytthos
 * @category config
 *
 * Encargado del logueo de usuarios
 *
 */

require_once ("Config/includes.php");
?>
<div id='content'>
	<div id="separadorh"></div>
	<legend>Validaci&oacute;n de usuario</legend>
	<div id="separadorh"></div>
	<div id='cuerpo' align='center'>
		<form method='post' id="logingForm" name="logingForm" action='validar_usuario.php'>
			<fieldset>
				<p></p>
				<table>
					<tr>
						<td class="items"><label><span class="mxlabel">Usuario</span></label></td>
						<td><input type='text' name='usuario' id='usuario' /></td>
					</tr>
					<tr>
						<td class="items"><label><span class="mxlabel">Contrase&ntilde;a</span></label></td>
						<td><input type='password' name='password' /></td>
					</tr>
					<tr>
						<td colspan="2" align="center">
							<p></p>
							<div id="separadorh"></div> <!--<a href="javascript:document.logingForm.submit();" class="mxlbutton">Aceptar</a>
										<a href="#" class="mxlbutton">Cancelar</a>	--> <input type='submit' value='Aceptar' /> <input type='reset' value='Cancelar' />
							<div id="separadorh"></div>
						</td>
					</tr>
				</table>
			</fieldset>
		</form>


	</div>
</div>
<?php
include ("inc/footer.php");
?>