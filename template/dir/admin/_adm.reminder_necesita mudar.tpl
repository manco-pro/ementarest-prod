{include file="_header.tpl.html"}
<script language="javascript" type="text/javascript">
{literal}
<!--
function formValidation(){
	var respuesta = document.getElementById('respuesta');
	var verificar = document.getElementById('verificar');
	var email = document.getElementById('email');
	
	if (respuesta.value == ''){alert('Complete the answer'); respuesta.focus(); return false;}
	if (email.value == '')    {alert('Complete the email');  email.focus(); return false;}
	if (verificar.value == ''){alert('Complete the image characters'); verificar.focus(); return false;}

	return true;
}
{/literal}
//-->
</script>
<br /><br /><br />
<form method="POST" action="reminder.php" onsubmit="return formValidation(this);" name="frmRecordar">
	<table cellpadding="2" cellspacing="0" align="center" width="280" class="tmDataTD" border="0">
		<tr>
			<td valign="middle" align="right" width="170">Confirm your identity</td>
			<td><img src="{$stRUTAS.images}recordar.gif" border="0"/></td>
		</tr>
	</table>
	<table cellpadding="2" cellspacing="0" align="center" border="0" width="280">
		<tr><td class="tmErrorDataTD">{$stERROR|default:'&nbsp;'}</td></tr>
		<tr>
			<td class="tmDataTD">
			<table cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td>Select</td><td width="5"></td>
				<td>
					<select name="reminder" id="reminder" class="tmSelect" style="width:225px;">
						<option value="1" {if $stREMINDER==1}selected{/if}>Mother's birthplace</option>
						<option value="2" {if $stREMINDER==2}selected{/if}>Best childhood friend</option>
						<option value="3" {if $stREMINDER==3}selected{/if}>Name of first pet</option>
						<option value="4" {if $stREMINDER==4}selected{/if}>Favorite teacher</option>
						<option value="5" {if $stREMINDER==5}selected{/if}>Favorite historical person</option>
						<option value="6" {if $stREMINDER==6}selected{/if}>Grandfather's occupation</option>
					</select>
				</td>
			</tr>
			<tr><td height="10"></td></tr>
			<tr>
				<td align="right">Answer</td><td width="5"></td>
				<td><input type="text" id="respuesta" name="respuesta" class="tmInput" value="{$stRESPUESTA}" style="width:225px;"></td>
			</tr>
			<tr><td height="10"></td></tr>
			<tr>
				<td align="right">Email</td><td width="5"></td>
				<td><input type="text" id="email" name="email" value="{$stEMAIL}" style="width:225px;" class="tmInput"></td>
			</tr>
			</table>
			</td>
		</tr>
		<tr><td height="15"></td></tr>
		<tr><td align="center">Enter the code show</td></tr>
		<tr><td height="5"></td></tr>
		<tr>
			<td class="tmDataTD" align="center">
				<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td><img src="{$stRUTAS.captcha}img.captcha.php" border="0"></td><td width="5"></td>
					<td><input type="text" value="" id="verificar" name="verificar" style="width:90px;text-align:center;" class="tmInput" maxlength="5"></td>
				</tr>
				</table>
			</td>
		</tr>
		<tr><td height="10"></td></tr>
		<tr>
			<td class="tmDataTD">
			<table cellpadding="0" cellspacing="0" border="0" width="100%">
			<tr>
				<td><input name="btn_volver" type="button" value="Cancel" class="tmButton" onclick="location.href='index.php';"></td>
				<td align="right"><input name="btn_action" type="submit" value="OK" class="tmButton" /></td>
			</tr>
			</table>
			</td>
		</tr>
	</table>
</form>
{include file="_foot.tpl.html"}