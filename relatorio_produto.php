
<html>

<?php date_default_timezone_set('America/Sao_Paulo'); ?>
<head>
<meta charset="utf-8">

<script type="text/javascript">

    function imprimir(){

        var pagina = document.getElementById("buscacomanda").innerHTML;

        var novaJanela = window.open('','_blank',		'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no');

        novaJanela.document.write("<head>");

        novaJanela.document.write("<meta http-equiv='content-type' content='text/html; charset=iso-8859-1' />");

        novaJanela.document.write("<style tyle='text/css' media='print'>button{display: none;}</style>");

        novaJanela.document.write("<style tyle='text/css' media='all'>a{color: #0000FF;}</style>");

        novaJanela.document.write("</head>");

        novaJanela.document.write("<button type='button' onclick='javascript:window.print();'>Imprimir P�gina</button>");

        novaJanela.document.write("<h3></h3>");

        novaJanela.document.write(pagina);



    }



    ////////////////////// MASCARA DE IMPUTS /////////////////////////

    jQuery(function($){

        $("#hora1").mask("99:99");

        $("#hora2").mask("99:99");

    });

    function validar() {

        var datai = form.datai.value;

        var dataf = form.dataf.value;

        var hora1 = form.hora1.value;

        var hora2 = form.hora2.value;



        if (datai == "") {

            alert('Escolha a data inicial');

            form.datai.focus();

            return false;

        }



        if (dataf == "") {

            alert('Escolha a data final');

            form.dataf.focus();

            return false;

        }





    } ////////////// FIM DA FUNCTION /////////////////////


</script>
</head>
<body>
<div class="naomostra">

    <form action="?btn=relatorioproduto&busca=data" method="post" enctype="multipart/form-data" id="form">



        Data Inicio: <input name="datai" type="text" size="12" id="datai">

        Data Final: <input name="dataf" type="text" size="12" id="dataf">

        <select name="produtop">
            <option>--Selecione o Produto--</option>
            <?php

            $consulta = mysql_query("SELECT * FROM tbl_produtos GROUP BY nome");
            while($consulta1 = mysql_fetch_array($consulta)) {

                $nom = $consulta1['nome'];


                ?>

                <option><?php echo $nom; ?></option>
                <?php
            }


            ?>

        </select>



        <input name="buscar" type="submit" value="Buscar" id="buscar" onclick="return validar()">

    </form>

</div>

<br/>

<div id="buscacomanda">



    <table width="95%" align="center" cellpadding="3" cellspacing="0" style="margin-top:5px; border:1px solid #f2f2f2; font-size:13px;">

        <tr style="border:1px solid #f2f2f2;">

            <td width="15%" align="center" bgcolor="#66CCFF"  style="border:1px solid #CCC;"><strong>Data</strong></td>

            <td width="40%" align="center" bgcolor="#66CCFF" style="border:1px solid #CCC;"><strong>Produto</strong></td>

            <td width="7%" align="center" bgcolor="#66CCFF" style="border:1px solid #CCC;"><strong>QTD.</strong></td>

            <td width="19%" align="center" bgcolor="#66CCFF" style="border:1px solid #CCC;"><strong>Preco un</strong></td>

            <td width="19%" align="center" bgcolor="#66CCFF" style="border:1px solid #CCC;"><strong>Preco total</strong></td>

        </tr>





        <?php

        if($_GET['busca'] == "data"){

            $datai = date('Y/m/d', strtotime($_POST['datai']));

            $dataf = date('Y/m/d', strtotime($_POST['dataf']));
            $produtop = $_POST['produtop'];


            $query = mysql_query("SELECT data, nome, preco, SUM(preco) AS pr, SUM(qtd) AS qtd, date_format(data, '%d/%m/%Y') AS data FROM tbl_carrinho WHERE data BETWEEN '$datai' AND '$dataf' AND nome = '$produtop' GROUP BY nome") or die(mysql_error());



            while($resultado = mysql_fetch_array($query)){

                $data = $resultado['data'];

                $nome = $resultado['nome'];

                $qtd = $resultado['qtd'];

                $preco_unitario = $resultado['preco'];

                $precototal = $resultado['pr'];

                $total_produto = $qtd * $preco_unitario;

                $total += $total_produto;

                ?>

                <tr style="border:1px solid #f2f2f2;">

                    <td align="center" style="border:1px solid #f2f2f2;"><?php echo $data ?></td>

                    <td align="left" style="border:1px solid #f2f2f2;"><?php echo $nome ?></td>

                    <td align="center" style="border:1px solid #f2f2f2;"><?php echo $qtd ?></td>

                    <td align="center" style="border:1px solid #f2f2f2;"><?php echo str_replace(".",",",$preco_unitario);  ?></td>

                    <td align="right" style="border:1px solid #f2f2f2;"><?php echo str_replace(".",",",$total_produto); ?></td>

                </tr>





            <?php }  ?>

            <tr>

                <td colspan="3" align="center">&nbsp;</td>

                <td align="center" style="border:1px solid #f2f2f2;"><strong>Total do periodo</strong></td>

                <td align="right" style="border:1px solid #f2f2f2;"><strong><?php echo number_format($total, 2, ',', '.'); ?></strong></td>

            </tr>



        <?php } ?>

    </table>









</div>

<div style="text-align:center; margin-top:5px;"><button type="button" onclick="javascript:imprimir();">Imprimir relatorio</button></div>

</div>
</body>
</html>