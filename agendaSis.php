<?php
/*****************************
CONFIGURAÇÃO DO BANCO
*****************************/

define(HOST,'localhost');
define(USER,'root');
define(PASS,'');
define(DBSA,'github');

/*****************************
DEFINE INFORMAÇÕES DO SITE
*****************************/

define(BASE,'http://localhost/GitHub');
define(SITETAGS,'Agenda, Reservas, ');

/*****************************
FUNÇÃO PARA CONECTAR AO BANCO
*****************************/

$conn = mysql_connect(HOST, USER, PASS) or die ('Erro ao conectar: '.mysql_error());
$dbsa = mysql_select_db(DBSA) or die ('Erro ao selecionar banco: '.mysql_error());
	
/*****************************
FUNÇÃO DE CADASTRO NO BANCO
*****************************/

function create($tabela, array $datas){
	$fields = implode(", ",array_keys($datas));
	$values = "'".implode("', '",array_values($datas))."'";			
	$qrCreate = "INSERT INTO {$tabela} ($fields) VALUES ($values)";
	$stCreate = mysql_query($qrCreate) or die ('Erro ao cadastrar em '.$tabela.' '.mysql_error());
	if($stCreate){
		return true;
	}
}

?>