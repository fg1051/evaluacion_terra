<?php
echo '
    <form id="formNuevaTarea" onsubmit="event.preventDefault(); agregarTask();">
        <div class="form">
                <label class="lblTittle" for="txtTarea">Tarea a Realizar:</label>
            <input type="text" class="txtForm" id="txtTarea" name="txtTarea" required><br>
        </div>

        <button class ="btnNuevo" id="btnNuevo" > Guardar </button>    
    </form>        
    <button class="btnCancelar" onclick="cancelarNuevaTarea()">Cancelar</button>
';
        