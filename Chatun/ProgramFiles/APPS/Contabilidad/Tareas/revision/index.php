<?php require('header.php') ?>
<?php require('conexion.php') ?>
<div class = " card container">
    <form id = "clientes" name ="clientes" action="" method="POST">
 <h3 class= "text-danger">venta de productos</h3>
       <table class="table" name="tabla" id="tabla" style="width: 60rem;">
           <thead>
               <tr>
                   <th  style= "text-align:center">Cantidad</th>
                   <th  style= "text-align:center">Producto</th>
                   <th>Precio Unit.</th>
                   <th  style= "text-align:center">SubTotal</th>
                   <th></th>
               </tr>
               
           </thead>
           <tbody class = "row" >
             <tr class="fila-base">

             <?php $query = "SELECT * FROM productos";
  $respuesta = mysqli_query($conn, $query);
   ?>


                 <td><input onChange="CalcularTotal()" id = "Cantidad[]"name="Cantidad[]" class= "form-control" type="text" placeholder ="0" style="width: 5rem;"></td>
                 
                
                 <td><select onChange="SaberPrecio(this)" id = "Producto[]" name="Producto[]" class= "form-control" type="text" placeholder ="Ingrese un producto" style="width: 25rem;">
                 <option selected disabled>Seleccione un Producto</option>
                 <?php  while ($row = mysqli_fetch_array($respuesta)) { ?><option value="<?php echo $row['idProducto']?>"><?php echo $row['NombreP']?></option> <?php  } ?>
                 </select></td>
                 <td><input id = "PrecioUnit[] " name="PrecioUnit[]" class= "form-control" type="text" placeholder ="0.00" style="width: 8rem;"></td>
                 <td><input id = "SubTotal[]"name="SubTotal[]" class= "form-control" type="text" placeholder ="0.00" style="width: 10rem;"></td>
                 <td class="eliminar">
                     <button type="button" class="btn btn-danger btn-xs">
                         <span class="glyphicon glyphicon-remove-sign"></span> Eliminar
                     </button>
                </td>
             </tr>

           </tbody>
       </table>
        <div class="col-lg-12" align ="left">
             <button type="button" class="btn btn-success btn-xs" id="agregar">
                  <span class="glyphicon glyphicon-plus"></span> Agregar
            </button>
        </div>
       <div >
           <label style= "margin-top:1cm " for="">Total</label>
       <input id= "Total" class = "form-control" type="text" name ="Total" placeholder = "0.00" style="width: 10rem;">
       </div>
      
    </form>
      <button type = "button"  onclick ="Guardar()" class = "btn btn-success" style= "margin-top:1cm ">
      Guardar Venta
      </button>
    

</div> <!-- //final container -->

<script>
    $(function(){
        
        // Clona la fila oculta que tiene los campos base, y la agrega al final de la tabla
        $("#agregar").on('click', function(){
            $("#tabla tbody tr:eq(0)").clone().removeClass('fila-base').appendTo("#tabla tbody");
        });



        // Evento que selecciona la fila y la elimina
        $(document).on("click",".eliminar",function(){
            var parent = $(this).parents().get(0);
            $(parent).remove();
        });
    });

    function Guardar()
    { 
      
        var FormCorte = $("#clientes").serialize();
        $.ajax({
            url: 'guardarventa.php',
            type: 'POST',
            dataType: 'html',
            data: FormCorte,
            success: function(data) 
            {  /*  alert("datos"); */
                 if (data==1)
                 {
                    alert("LA VENTA HAS SIDO REGISTRADA CON EXITO");
                    location.reload();
                 }
            }
        })   
    }

        


    function SaberPrecio(x)
        {
            //Obtenemos el value del input
                var Precio = document.getElementsByName('PrecioUnit[]');
                var service = x.value;
                var dataString = 'service='+service;
                var Indice = $(x).closest('tr').index();
                //Le pasamos el valor del input al ajax
                $.ajax({
                    type: "POST",
                    url: "Pproducto.php",
                    data: dataString,
                    beforeSend: function()
                    {
                        $('#suggestions').html('<img src="../../../../../img/Preloader.gif" />');
                    },
                    success: function(data) {
                                 Precio[Indice].value = data;
                                 CalcularTotal();
                            }
                });
            }


            function CalcularTotal()
        {
            var Precio   = document.getElementsByName('PrecioUnit[]');
            var CantidadFE = document.getElementsByName('Cantidad[]');
            
            var SubTotal = document.getElementsByName('SubTotal[]');
            var Total = 0;
            var SubTotalCalculado = 0;
            var TotalDescuentoFac = 0;
            for(i = 0; i < Precio.length; i++)
            {
                SubTotalCalculado = parseFloat(CantidadFE[i].value) * parseFloat(Precio[i].value);
                SubTotal[i].value = SubTotalCalculado.toFixed(2);
                Total = Total + SubTotalCalculado;
                
            }
            $('#Total').val(Total.toFixed(2)); 
        }




</script>

<?php require('footer.php') ?>