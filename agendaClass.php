<?php 
//class verifica disponibilidade

class VerificaDisponibilidade{
    public function VerificaD($dia){
        $verifica = read("agenda","WHERE data ='".$dia."' ");
        if ($verifica){
            return '<div class="cabecalho_dia reservado"> '.$dia.'<br>'.$verifica[0]['nome'].'<br>'.$verifica[0]['email'].'</div>' ;
        }else{
            return "<div class='cabecalho_dia livre'>".$dia.'</div>' ;
        }
    }
}

//Gera calendario com extensão de verificar disponibilidade

class riaCalendario extends VerificaDisponibilidade{
    public function geraCalendario($data){
                $data_explode = explode("/",$data);
                $dia = $data_explode[0];
                $mes = $data_explode[1];
                $ano = $data_explode[2];
                $calendario ="";
                $v_mes = substr($mes,0,2);
                $novo_mes = (int)$mes - 1;
                $ultimo_dia_mes = date("t", mktime(0, 0, 0, $mes, 1, $ano));
                $calendario .="<div class='cabecalho_semana'>DOM</div><div class='cabecalho_semana'>SEG</div><div class='cabecalho_semana'>TER</div><div class='cabecalho_semana'>QUA</div><div div class='cabecalho_semana'>QUI</div><div class='cabecalho_semana'>SEX</div><div class='cabecalho_semana'>SAB</div>";
                $dia_semana_primeiro_dia =  $dia_semana = date("w", mktime(0, 0, 0, $mes,1 , $ano));
                $trava = "F";
                $inicio = 1;
                for($i = 0; $i < 7;$i++){
                    if($dia_semana_primeiro_dia == $i || $trava == "T"){
                        $novaData =  $inicio.'/'.$mes.'/'.$ano;    
                        $novaData = $this->VerificaD($novaData);
                        $calendario .="<a href=".HTTP."/agenda.php?data=$inicio/$mes/$ano&mes=$mes>".$novaData."</a>";
                        $trava = "T";
                        $inicio++;
                    }else{$calendario .="<div class='cabecalho_dia vago'>&nbsp;&nbsp;</div>";}
                }
                $fim = "F";
                $linha_semana = 1;
                while($fim == "F" || $linha_semana < 6){
                    for($f = 0;$f < 7;$f++){
                        $linha_semana++;
                        if($inicio <= $ultimo_dia_mes){
                            $nData =  $inicio.'/'.$mes.'/'.$ano;    
                            $nData = $this->VerificaD($nData);
                            $calendario .="<a href=".HTTP."/agenda.php?data=$inicio/$mes/$ano&mes=$mes>".$nData."</a>";
                            if($inicio == $ultimo_dia_mes){ $fim = "T"; }
                                $inicio++;
                        }else{ $calendario .="<div class='cabecalho_dia vago'>&nbsp;&nbsp;</div>"; }
    
                    }
                }
                return $calendario;
    }
}
?>