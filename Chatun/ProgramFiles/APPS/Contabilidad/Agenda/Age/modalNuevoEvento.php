<div class="modal" id="exampleModal"  tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <div class="col-lg-12">
      <div class="card-head style-primary">
						<h2 class="text-center"> Datos de la Reunión </h2>
					</div>
      
  <form name="formEvento" id="formEvento" action="nuevoEvento.php" class="form-horizontal" method="POST">
		<div class="form-group">
    <div class="col-lg-2">
    </div>
    <div class="col-lg-8">
			<label for="evento" >Titulo</label>

				<input type="text" class="form-control" name="evento" id="evento" placeholder="Nombre de la reunión" required/>

		</div>
    <div class="col-lg-12">
    <div class="col-lg-2">
    </div>
    <div class="col-lg-8">
			<label for="Lugar" >Lugar</label>

				<input type="text" class="form-control" name="Lugar" id="Lugar" placeholder="Nombre de la reunión" required/>

		</div>
		</div>
    <div class="col-lg-2">
    </div>
    <div class="col-lg-8">
			<label for="Observaciones" >Observaciones</label>

      <textarea class="form-control" name="Observaciones" id="Observaciones" rows="2" cols="40"><?php echo $Observaciones; ?></textarea>

		</div>
		</div>
    <div class="form-group">
    <div class="col-lg-2">
    </div>
    <div class="col-lg-8">
    <label for="fecha_inicio" >Fecha Inicio</label>
    <input type="text" class="form-control" name="fecha_inicio" id="fecha_inicio" placeholder="Fecha Inicio">

		</div>
		</div>

    <div class="form-group">
    <div class="col-lg-2">
    </div>
    
    <div class="col-lg-4">
    <label for="fecha_inicio" >Hora Inicio</label>
        <input type="time" class="form-control" name="hora_inicio" id="hora_inicio">
      </div>
      <div class="col-lg-4">
    <label for="hora_fin" >Hora Fin</label>
        <input type="time" class="form-control" name="hora_fin" id="hora_fin">
      </div>
    </div>


    
  <div class="col-md-12" id="grupoRadio">
  <div class="col-lg-2">
    </div>
    <div class="col-lg-8">
  
  <input type="radio" name="color_evento" id="orange" value="#FF5722" checked>
  <label for="orange" class="circu" style="background-color: #FF5722;"> </label>

  <input type="radio" name="color_evento" id="amber" value="#FFC107">  
  <label for="amber" class="circu" style="background-color: #FFC107;"> </label>

  <input type="radio" name="color_evento" id="lime" value="#8BC34A">  
  <label for="lime" class="circu" style="background-color: #8BC34A;"> </label>

  <input type="radio" name="color_evento" id="teal" value="#009688">  
  <label for="teal" class="circu" style="background-color: #009688;"> </label>

  <input type="radio" name="color_evento" id="blue" value="#2196F3">  
  <label for="blue" class="circu" style="background-color: #2196F3;"> </label>

  <input type="radio" name="color_evento" id="indigo" value="#9c27b0">  
  <label for="indigo" class="circu" style="background-color: #9c27b0;"> </label>

</div>
</div>

<table class="table" name="tabla" id="tabla">
																<thead>
																	<tr>
																		<th>Participantes</th>
																	</tr>
																</thead>
																<tbody>
																	<tr class="fila-base">
                                  <td> <h6><input type="text" class="form-control" name="Participante[]" id="Participante[]" style="width: 300px" onchange="BuscarParticipante(this)"></h6></td>
                                      <td class="eliminar">
                                        <button type="button" class="btn btn-danger btn-lg" onclick="EliminarLinea(this)">
                                            <span class="glyphicon glyphicon-trash"></span>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                               <td> <h6><input type="text" class="form-control" name="Participante[]" id="Participante[]" style="width: 300px" onchange="BuscarParticipante(this)"></h6></td>
                                        <td class="eliminar">
                                            <button type="button" class="btn btn-danger btn-lg" onclick="EliminarLinea(this)">
                                                <span class="glyphicon glyphicon-trash"></span>
                                            </button>
                                        </td>
                                    </tr>
																</tbody>
																
															</table>
															<div class="col-lg-12" align="left">
						                                        <button type="button" class="btn btn-success btn-md" id="agregar" onclick="AgregarLinea()">
						                                            <span class="glyphicon glyphicon-plus"></span> Agregar
						                                        </button>
						                                    </div>
		
	   <div class="modal-footer">
      	<button type="submit" class="btn btn-success">Guardar Evento</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
    	</div>
	</form>
      
    </div>
    
  </div>
</div>
  </div></div>

