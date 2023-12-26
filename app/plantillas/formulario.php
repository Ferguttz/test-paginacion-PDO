<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>CRUD DE USUARIOS</title>
<link href="web/default.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="container" style="width: 600px;">
<div id="header">
<h1>Listado de Clientes</h1>
</div>
<div id="content">
<hr>
<form   method="POST">
<table>
<?php if ($orden != "Nuevo"): ?>
<tr><td>Id</td> 
    <td>
      <input type="number" name="id" value="<?= $cliente->id ?>" readonly >
    </td>
</tr>
<?php endif ?>
<tr>
    <td>Nombre </td> 
 <td>
 <input type="text" 	name="nombre" 	value="<?=$cliente->first_name ?>"       <?= ($orden == "Detalles")?"readonly":"" ?> size="30" autofocus></td></tr>
 <tr><td>Apellidos </td> 
 <td>
 <input type="text" 	name="apellidos" 	value="<?=$cliente->last_name ?>"       <?= ($orden == "Detalles")?"readonly":"" ?> size="30"></td></tr>
 <tr><td>Email </td> 
 <td>
 <input type="text" 	name="email" 	value="<?=$cliente->email ?>"       <?= ($orden == "Detalles")?"readonly":"" ?> size="30"></td></tr>
 <tr><td>Género </td> 
 <td>
 <input type="text" 	name="genero" 	value="<?=$cliente->gender ?>"       <?= ($orden == "Detalles")?"readonly":"" ?> size="30"></td></tr>
 <tr><td>Direccion Ip </td> 
 <td>
 <input type="text" 	name="dir_ip" 	value="<?=$cliente->ip_address ?>"       <?= ($orden == "Detalles")?"readonly":"" ?> size="30"></td></tr>
 <tr><td>Teléfono </td> 
 <td>
 <input type="text" 	name="telefono" 	value="<?=$cliente->telefono ?>"       <?= ($orden == "Detalles")?"readonly":"" ?> size="30"></td></tr>
 </table>

 <input type="submit"	 name="orden" 	value="<?=$orden?>">
 <input type="submit"	 name="orden" 	value="Volver">
</form> 
</div>
</div>
</body>
</html>
<?php exit(); ?>