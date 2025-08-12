<?php
include("../../../../../../Script/seguridad.php");
include("../../../../../../Script/conex.php");
?>
<table class="table table-hover table-condensed" id="tbl_resultEventos">
        <thead>
            <th><strong>Nombre</strong></th>
            <th><strong>Eliminar</strong></th> 
        </thead>
        <tbody>
        <?php
            $Consulta = "SELECT * 
                        FROM Taquilla.EVENTO
                        WHERE E_ESTADO = 1 AND E_TIPO = 1
                        ORDER BY E_DESCRIPCION";
            $Resultado = mysqli_query($db, $Consulta);
            while($row = mysqli_fetch_array($Resultado))
            {
                $Codigo = $row["E_ID"];?>
                <tr>             
                        <td style="font-size: 10px"><?php  echo $row["E_DESCRIPCION"]?></td>
                        <td align="center"><button type="button" class="btn btn-danger btn-circle" onclick="eliminarEvento(<?php echo "$Codigo"; ?>)"><i class="fa fa-times"></i>
                                </button> 
                                </td>
                    </tr>
                    <?php 
            }
        ?>                                  
        </tbody>
    </table>
    </div>
    <script>
    var tbl_filtrado =  { 
            mark_active_columns: true,
            highlight_keywords: true,
            filters_row_index:1,
        paging: true,             //paginar 3 filas por pagina
        paging_length: 5,  
        rows_counter: true,      //mostrar cantidad de filas
        rows_counter_text: "Registros: ", 
        page_text: "Página:",
        of_text: "de",
        btn_reset: true, 
        loader: true, 
        loader_html: "<img src='../../../../../libs/TableFilter/img_loading.gif' alt='' style='vertical-align:middle; margin-right:5px;'><span>Filtrando datos...</span>",  
        display_all_text: "-Todos-",
        results_per_page: ["# Filas por Página...",[10,20,50,100]],  
        btn_reset: true,
        col_1: "select",
        col_2: "select",
        col_3: "disabled",
    };
    var tf = setFilterGrid('tbl_resultEventos', tbl_filtrado);
</script>
       
<script>
    function eliminarEvento(idEvento)
    {
       $.ajax({
            url: 'Ajax/EliminarEventos.php',
            type: 'POST',
            dataType: 'html',
            data: {idEvento:idEvento},
            success: function(data)
            {
                if (data==1) 
                { 
                    verListadoEventos();
                }
            }
        })
               
    }
</script>