   <?php 
require('agendaSis.php');
require('agendaClass.php');
?>
   <!DOCTYPE html>
   <html>
   <head>
       <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
       <title>Teste - Agenda</title>
       <link rel="stylesheet" type="text/css" href="agendaCss.css" />
   </head>
   <body>
<?php 
if($_GET['data']){
    $f['data']      = $_GET['data'];
    $agenda = read('agenda','WHERE data = "'.$f["data"].'"');
    if($agenda):
        echo'<div class="alert alert-danger">OPPSS! não foi possivel efetuar sua reserva, provavelmente a data já esteja reservada</div>';
    endif;
    if($_POST['sendForm']):
    $f['nome']      = mysql_real_escape_string(trim($_POST['nome']));
    $f['email']     = mysql_real_escape_string(trim($_POST['email']));
    $f['telefone']  = mysql_real_escape_string(trim($_POST['telefone']));
    if(in_array('', $f)){
         echo'<div class="alert alert-danger">OPPSS! preencha todos os campos.</div>';
    }else{
    create('agenda',$f);
    echo '<div class="alert alert-success">Reserva efetuada para dia '.$f['data'].'</div>';
    }
    endif;
    echo 'vai a merda';
}
?>

<?php 

echo '<h1>Agenda: '.$_GET['data'].'</h1>';

//menu para navegação dos meses
$vetor_mes = array("0","Janeiro","Fevereiro","Mar&ccedil;o","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
for ($i=01; $i < 13; $i++) { 
    $dataNemu = $i;
    echo '<a class="link" href="'.HTTP.'/agenda.php?mes='.$dataNemu.'">'.$vetor_mes[$i].'</a>';  
}
echo '<br>';
if($_GET['data'] AND !isset($_POST['sendForm'])){?>
<div class="formulario"><form action="" method="post" enctype="multipart/form-data">
    <label class="line">
        <span class="nome">Nome:</span>
        <input type="text" name="nome" value ="<?php  echo $f['nome'];?>"id="nome" />
    </label>
    <label class="line">
        <span class="email">Email:</span>
        <input type="text" name="email" value ="<?php  echo $f['email'];?>"id="email" />
    </label>
    <label class="line">
        <span class="telenone">Telenone:</span>
        <input type="text" name="telefone" value ="<?php  echo $f['telefone'];?>"id="telefone" />
    </label>
        <input type="submit" value="efetuar Reservas" name ="sendForm" class="btn" id="sendForm" />
    </form>
    <a href="<?php echo HTTP;?>/agenda.php?mes=<?php echo $_GET['mes'];?>">Fechar</a>
</div>
<?php 
}

$obj_calend = new riaCalendario();

//define data para gerar o calendario
$date = ('01/'.$_GET['mes'].'/'.date('Y'));
$datedefault = '01/'.date('n').'/'.date('Y');
$date = ($_GET['mes'] == "" ? $datedefault:$date);

echo $obj_calend->geraCalendario($date);
?>
    </div>
</div>
   </body>
   </html>