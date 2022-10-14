<?php
$conexao=mysqli_connect("localhost","root","","sistema");
$Tipo		= $_GET['Tipo'];
$user_id	= $_GET['user_id'];
if ($Tipo == "excluir")
{
	$RSS = mysqli_query($conexao,"DELETE FROM usuario where user_id=$user_id");
}

if ($Tipo == "salva")
{
	$SQL = "select * from usuario where user_id=".$user_id;
	$RSS = mysqli_query($conexao,$SQL)or print(mysqli_error());
	$RSX = mysqli_fetch_assoc($RSS); 
	
	If ( $RSX["user_id"] == $user_id )
	{
		$SQL  = "update usuario set nome='".str_replace("'","",$_GET['nome'])."',";
		$SQL .= "cargo='".str_replace("'","",$_GET['cargo'])."' ";
		$SQL .= "where user_id = '". $RSX["user_id"]."'";
		$RSS = mysqli_query($conexao,$SQL)or die($SQL);

		echo "<script language='JavaScript'>alert('Operacao realizada com sucesso.');</script>";
	} 
	Else
	{
		$SQL  = "Insert into usuario (nome,cargo) "   ; 
		$SQL .= "VALUES ('".str_replace("'","",$_GET['nome'])."',";
		$SQL .= "'".str_replace("'","",$_GET['cargo'])."')";
		$RSS = mysqli_query($conexao,$SQL) or die('erro');

		$SQL = "select * from usuario  order by user_id desc limit 1";
		$RSS = mysqli_query($conexao,$SQL)or print(mysqli_error());
		$RSX = mysqli_fetch_assoc($RSS); 
		$user_id = $RSX["user_id"];
		echo "<script>alert('Registro Inserido.');</script>";
	}
}
?>

<body style="scroll-x:hidden;" >
<br><font style='font-size:24px; font-family:Arial;'><center>.: Meu cadastros  Nº <b><?=$user_id?></b>:.</center></font>
<fieldset><legend style='font-size:9px; font-family:Arial;'>Meu cadastros </legend>
	<form name="forma" action="usuario.php">
	<input type="hidden" name="user_id" id="user_id" value="<?=$user_id;?>">
	<input type="hidden" name="Tipo" id="Tipo" value="salva">
	<table border=0 align="center" width="80%" style="font-family:verdana;font-size:10px;" cellpadding='1' cellspacing='0'>
	<tr> 
	  <td align="right">Nome </td>
	  <td><input type="text" id="nome" name="nome" 
	  size="60" value="<?=$RS["nome"];?>" maxlength="70" style="background-color:#FFFFBB;"></td>
	</tr>
	<tr> 
	  <td align="right">Fone </td>
		<td><input type="text" id="cargo" name="cargo" size="13" value="<?=$RS["cargo"];?>" maxlength="12" style="background-color:#FFFFBB;"></td>
	</tr>	
	</table>

	<div align="center">
	  <input value="Novo" id="BtNovo" name="BtNovo"  type="button" onClick="window.open('usuario.php','_self');" style="position: relative; width: 70">
	  <input type="button" value='Salvar' onclick='salvar()'>
	  <input type="button" value='Excluir' onclick='exclui(<?=$user_id;?>);'>
	</div>
</form>
</fieldset>
<script language="javascript">
function Clica(user_id)
{
	window.open('usuario.php?user_id='+user_id, "_self");
}
function exclui(user_id)
{
	if (confirm('Confirma a exclusao'))
	{
	   window.open('usuario.php?Tipo=excluir&user_id='+user_id, "_self");
	}
}
function salvar()
{
	if (forma.nome.value.length == 0) { alert('Preencha o nome'); }
	else if (forma.cargo.value.length == 0) { alert('Preencha o fone'); }
	else { forma.submit(); }
}
</script>


<?php
$conexao=mysqli_connect("localhost","root","","sistema");
$Tipo		= $_GET['Tipo'];
$user_id	= $_GET['user_id'];
echo "<table id='grid' name='grid' width='90%'  border style='font-family:verdana; font-size:10px;'>";

$SQL = "select * from usuario  order by nome";
$RSS = mysqli_query($conexao,$SQL)or print(mysqli_error());
while($RS = mysqli_fetch_array($RSS))
{
	echo "<tr onClick='Clica(".$RS["user_id"].")' >";
	echo "<td>".$RS["nome"]."</td>";
	echo "<td>".$RS["cargo"]."</td>";
	echo "</tr>";
}
echo "</table><hr>";

if ( strlen($user_id) == 0 )  $user_id = 0;
$RSS = mysqli_query($conexao,"Select * from usuario  where user_id = $user_id")or print(mysqli_error());
$RS = mysqli_fetch_assoc($RSS);	


?>