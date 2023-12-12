
$(document).ready(function(){  
 
    $(document).on("click", "#btnModal", function(){    
        $("#formDocumentos").trigger("reset");
        $(".modal-header").css("background-color", "#1cc88a");
        $(".modal-header").css("color","white");
        $(".modal-title").text("Nuevo registro");            
        $("#modalCRUD").modal("show");  
    });

    
    // Modal Subir nuevo documento | update existing product --------------------------------------------
    $(document).on("click", "#btnVersiones", function(){     
        $(".modal-header").css("background-color", "#7893ac");
        $(".modal-header").css("color","white");
        $(".modal-title").text("Versiones del documento");            
        $("#versionDocumento").modal("show");  
    }); 

    $(document).on("click","#btnEliminar",function(){
        // Obtener el id del elemento a eliminar
        var id = $(this).data("DocumentoID");
        // Mostrar una alerta de confirmación con SweetAlert2
        Swal.fire({
            title: '¿Estás seguro de querer continuar con el proceso?',
            text: "El documento sera removido",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#7893ac',
            cancelButtonColor: '#000',
            confirmButtonText: 'Sí, borrar'
        }).then((result) => {
        // Si el usuario confirma la acción, ejecutar una función para eliminar el elemento
        if (result.isConfirmed) {
            eliminarElemento(DocumentoID);
        }
        })
    });
 

    // // Msj al guardar o editar un registro  ---------------------------------- Nuevo || Editar ----------------------------------
    // $(document).on("click","#btnGuardar",function(){ 
    //     var msjNuevo= $(this).data('frm');
    //     var msjEditar = $(this).data('frm'); 

    //     if(msjNuevo) {
    //         var titulo = 'Registro almacenado';
    //         var texto = 'El documento se ha almacenado correctamente.'
    //     }
    //     if(msjEditar) {
    //         var titulo = 'Operación exitosa';
    //         var texto = 'Se ha creado una nueva versión del documento.'
    //     }
            
    //     Swal.fire({   
    //         title: titulo,
    //         text: texto,
    //         icon: 'success',
    //         showConfirmButton: false,
    //         timer: 2000
    //     }) 
        
    // });


    // Msj al guardar o editar un registro  ---------------------------------- Nuevo ----------------------------------
    $(document).on("click","#btnGuardar",function(){  
        Swal.fire({   
            title: 'Registro almacenado',
            text: response.message,
            icon: 'success',
            showConfirmButton: false,
            timer: 3000
        },  
        function () {
            location.reload();
        });
    });
 

    $(document).on("click","#btnEditar",function(){
        // Obtener el id del elemento a eliminar
        var id = $(this).data("DocumentoID");
        // Mostrar una alerta de confirmación con SweetAlert2
        Swal.fire({
            title: '¿Deseas editar este documento?',
            text: "Se creará una nueva versión del documento",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#7893ac',
            cancelButtonColor: '#000',
            confirmButtonText: 'Sí, Editar'
        }).then((result) => {
        // Si el usuario confirma la acción, ejecutar una función para eliminar el elemento
        if (result.isConfirmed) {
            // Modal Subir nuevo documento | update existing product -------------------------------------------- 
            $("#formDocumentos").trigger("reset");
            $(".modal-header").css("background-color", "#7893ac");
            $(".modal-header").css("color","white");
            $(".modal-title").text("Editar registro");            
            $("#modalCRUD").modal("show");   
        }
 
        $(".DivArchivo").hide();

        });
    });

    $(document).on("click","#NuevaVersion",function(){
        $(".DivArchivo").show();
    });

    $(document).on("click","#VersionActual",function(){
        $(".DivArchivo").hide();
    });
     
 

    function eliminarElemento(id) {
        // petición AJAX  
        $.ajax({
            url: "documento/delete/{id}",
            type: "POST",
            data: {id: id},
            success: function(response) {
            // Si la respuesta es exitosa, mostrar una alerta de éxito y actualizar la vista
            Swal.fire(
                'Borrado',
                'El elemento ha sido eliminado',
                'success'
            )
            // Aquí, Actualizar la vista
            },
            error: function(error) {
                // Si hay un error, mostrar una alerta de error
                Swal.fire(
                    'Error',
                    'No se pudo eliminar el elemento',
                    'error'
                )
            }
        });
    }
 

 

    // Crear un objeto literal para las opciones de idioma
    var languageOptions = {
        "language": {
        "lengthMenu": "Mostrar MENU registros",
        "zeroRecords": "No se encontraron resultados",
        "info": "Mostrando registros del START al END de un total de TOTAL registros",
        "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
        "infoFiltered": "(filtrado de un total de MAX registros)",
        "sSearch": "Buscar:",
        "oPaginate": {
        "sFirst": "Primero",
        "sLast":"Último",
        "sNext":"Siguiente",
        "sPrevious": "Anterior"
        },
        "sProcessing":"Procesando...",
        }
    };

    // Crear la tabla con una URL dada
    function crearTabla(url) {
        // Destruir la tabla si existe
        if ($.fn.DataTable.isDataTable('#tablaDocumentos')) {
            table.destroy();
        }
        // Crear la tabla con los datos obtenidos de la URL
        table = $('#tablaDocumentos').DataTable({
            languageOptions,  
            ajax: url,
            columns: [
                {data: 'Documento', render: function (data, type, row, meta) {
                    return '<i class="fa fa-folder" aria-hidden="true"></i> ' + data + 
                    '<p class="tipoCoordinacion"><b>Tipo de Norma: </b>' + row.Norma + 
                    ' <a class="JsDocumento_onClick" data-documentoid="' + row.DocumentoID + '">irrrr</a> ';
                }},
                {data: 'Area'},
                {data: 'TipoMateria'},
                {data: 'FechaEmision', render: function(data) {
                return '<span>' + data + '</span> ';
                }},
                {data: 'EstatusFk', render: function(data, type, row) {
                var clase = data == 1 ? 'statusActivo' : 'statusInactivo';
                var icono = data == 1 ? 'iconoActivo' : 'iconoInactivo';
                return '<span class="' + clase + '"> <i class="fa fa-circle-thin ' + icono + '" aria-hidden="true"></i> ' + row.Estatus + '</span> ';
                }}
            ],
        });
    }
    

    // Evento, Asignar (URL) tipodocumentos
    $(document).on("click", ".Lineamientos", function() {
        crearTabla('../gestor/Lineamientos');
    });
        
    $(document).on("click", ".Normas", function() {
        crearTabla('../gestor/Normas');
    });
        
    $(document).on("click", ".Manuales", function() {
        crearTabla('../gestor/Manuales');
    });
        
    $(document).on("click", ".Procedimientos", function() {
        crearTabla('../gestor/Procedimientos');
    });
        
        
    
     //METODO PARA REDIRECCIONAR A LA VISTA DEL DOCUMENTO  -------------------------------------------------------------//
    $('#tablaDocumentos tbody').on('click', 'tr', function () {  
        $data = 'documento' +'/'+ $(this).find('a.JsDocumento_onClick').data('documentoid'); 
        $(location).attr('href', $data); 
    }); 

    // Msj - tooltip en indices|columnas de la tabla
    $('[data-toggle="tooltip"]').tooltip();    

     
    
});
   