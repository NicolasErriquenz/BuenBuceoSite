angular
    .module("angularApp")
    .controller("campanaEtapasComponentController", ["$routeParams", "$scope", "$rootScope", "DTOptionsBuilder", "adminService", "datosEstaticosService", "$location", campanaEtapasComponentController]);

function campanaEtapasComponentController($routeParams, $scope, $rootScope, DTOptionsBuilder, adminService, datosEstaticosService, $location) {
    
    var vm = this;

    vm.busy = {
        promise: [],
        message: "BUSCANDO DATOS DE CAMPAÑA..."
    };

    vm.DataSeleccionada = [];
    //vm.Campana = [];
    vm.EnviandoNotifiaciones = false;
    vm.Unidades = [];
    vm.EstadosEtapaPostulante = [];
    vm.PostulantesCampana = [];
    vm.habilitarBoton = false;
    vm.cantidadElementos = 0;

    $scope.promises = [];
    vm.busy.promise = new Array();

    vm.query = {
        EtapaId: 1
    };

    $scope.$on("EtapaSeleccionada", function (event, obj) {
        //console.log("escuchando al padre");
        vm.query = obj;
        vm.PostulantesCampana = obj.PostulantesCampana;
        vm.cantidadElementos = 0;
        vm.habilitarBoton = false;
        //console.log(obj);
    });

    $scope.$on("RefreshDatatable", function (event, obj) {
        //console.log("escuchando al padre");
        vm.habilitarBoton = false;
        vm.cantidadElementos = 0;
    });

    vm.getDatosSelect = function () {
        vm.busy.promise = datosEstaticosService.GetUnidades(
            function (response) { vm.Unidades = response; },
            function (e) { console.log("ERROR GetUnidades", e); }
        );
        vm.busy.promise = datosEstaticosService.GetPostulanteCampanasEstadosTipo(
            function (response) { vm.EstadosEtapaPostulante = response; },
            function (e) { console.log("ERROR GetPostulanteCampanasEstadosTipo", e); }
        );
    };

    vm.getDatosSelect();

    vm.abrirModalIndividual = function (postulanteCampana, accion) {

        vm.PostulantesCampana.forEach(function (pc) {
            pc.Selected = false;
        });
        vm.seleccionarItem(postulanteCampana);

        vm.EjecutarAcciones(accion)
    };

    vm.EjecutarAcciones = function (tipoAccion) {
        //console.log("Pidiendo al padre que ejecute");
        var dataModal = vm.getParamsDNIselected(tipoAccion);

        obj = {
            EtapaId: vm.query.EtapaId,
            DataModalPostulantesDNI: dataModal.listaDNIs,
            DataModalNombresColumna: dataModal.listaNombreColumna,
            DataModalTitulo: dataModal.tituloModal,
            ListaPostulantesCampana: dataModal.listaPostulantesCampana,
            DataModelListaDatosEstatico: dataModal.listaDatosEstatico,
            etiquetaDatoEstatico: dataModal.etiquetaDatoEstatico,
            accionarEvento: tipoAccion
        };
        $scope.$emit('accionarEvento', obj);
    };

    vm.language = {
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ningún dato disponible en esta tabla",
        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix": "",
        "sSearch": "Buscar:",
        "sUrl": "",
        "sInfoThousands": ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Último",
            "sNext": "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
    }

    vm.dtOptions = {        
        lengthMenu: [[10, 15, 25, 50, -1], [10, 15, 25, 50, 'TODOS']], //Cantidad de registros a incluir en el datatable (select)
        language: vm.language, //Setear idioma definido arriba
        stateSave: true, //Guarda el estado de la tabla (su posición de paginación, estado de pedido, etc.)
        stateDuration: 30, //Guarda el estado del datatable durante 30 segundos
        scrollX: true, //Habilitar scroll horizontal -> requiere fix con css
        order: [[1, 'asc']], //Ordenar por DNI -> por defecto
        retrieve: true, // Las opciones de inicialización no se pueden cambiar después de la inicialización
        columnDefs: [{
            'orderable': false, targets: 0, //No permitir ordenar por la columna del check (column 0)
        }],        
    };
    
    vm.seleccionarItem = function (postulante) {
        //console.log(postulante);
        postulante.Selected = !postulante.Selected;
        vm.checkTodosSeleccionado();
        //console.log(vm.PostulantesCampana);
    };

    vm.extractContent = function (textHTML) {
        return new DOMParser()
            .parseFromString(textHTML, "text/html")
            .documentElement.textContent;
    }

    vm.CheckAll = false;
    vm.seleccionarItemAll = function () {
        //console.log(vm.CheckAll);
        var table = $('#myTable').DataTable(); //todo el datatable
        var table_filtered = table.rows({ page: 'current' }); //hoja actual
        table_filtered = table_filtered.data().pluck(1).toArray(); //Array con data de la columna de DNI (hoja actual) -> Tiene "basura"
        var DocumentosList = [];

        for (var i = 0; i < table_filtered.length; i++) { //remover basura -> solo deja DNIs
            //DocumentosList.push(table_filtered[i].substring(189, table_filtered[i].length - 41));
            DocumentosList.push(vm.extractContent(table_filtered[i]).trim());
            //DocumentosList.push($("<a>").html(table_filtered[i]).text().trim());
            //console.log(DocumentosList[i]);
        }

        for (var i = 0; i < DocumentosList.length; i++) {
            let dni = DocumentosList[i];
            let PC = vm.getPostulantePorDni(dni);
            if (!PC.PostulanteCampanasEstados[PC.PostulanteCampanasEstados.length - 1].PostulanteCampanasEstadosTipo.Eliminatorio) {
                PC.Selected = !vm.CheckAll;
            }
            //console.log(PC);
        };
        vm.checkTodosSeleccionado();
        //console.log(vm.PostulantesCampana);
    };

    vm.checkTodosSeleccionado = function () {
        var todosSeleccionados = true;

        var table = $('#myTable').DataTable(); //todo el datatable
        var table_filtered = table.rows({ page: 'current' }); //hoja actual
        table_filtered = table_filtered.data().pluck(1).toArray(); //Array con data de la columna de DNI (hoja actual) -> Tiene "basura"
        var DocumentosList = [];

        for (var i = 0; i < table_filtered.length; i++) { //remover basura -> solo deja DNIs
            //DocumentosList.push(table_filtered[i].substring(189, table_filtered[i].length - 41));
            DocumentosList.push(vm.extractContent(table_filtered[i]).trim());
        }

        if (DocumentosList.length == 0) {
            todosSeleccionados = false;
            return;
        }

        for (var i = 0; i < DocumentosList.length; i++) {
            let dni = DocumentosList[i];
            //console.log(vm.PostulantesCampana);
            //console.log(dni);
            let PC = vm.getPostulantePorDni(dni);
            //console.log(PC);
            if ((PC && !PC.PostulanteCampanasEstados[PC.PostulanteCampanasEstados.length - 1].PostulanteCampanasEstadosTipo.Eliminatorio) && (PC.Selected == false || PC.hasOwnProperty('Selected') == false)) {
                todosSeleccionados = false;
                break; 
            }
        };

        //solo para cuando la lista contiene todos sus elementos con estado eliminatorio
        if (todosSeleccionados) {
            var itemsConEstadoEliminatorio = 0;
            for (var i = 0; i < DocumentosList.length; i++) {
                let dni = DocumentosList[i];
                let PC = vm.getPostulantePorDni(dni);
                if (PC && PC.PostulanteCampanasEstados[PC.PostulanteCampanasEstados.length - 1].PostulanteCampanasEstadosTipo.Eliminatorio) {
                    itemsConEstadoEliminatorio++;
                }
            }
            if (itemsConEstadoEliminatorio == DocumentosList.length) {
                todosSeleccionados = false;
            }
        }

        vm.habilitarBoton = false;
        for (var i = 0; i < vm.PostulantesCampana.length; i++) {
            if (vm.PostulantesCampana[i].Selected == true && !vm.PostulantesCampana[i].PostulanteCampanasEstados[vm.PostulantesCampana[i].PostulanteCampanasEstados.length - 1].PostulanteCampanasEstadosTipo.Eliminatorio) {
                vm.habilitarBoton = true;
            }
        }

        if (vm.habilitarBoton) {
            vm.cantidadElementos = vm.PostulantesCampana.filter(x => x.Selected && !x.ExisteSiguienteEtapa && !x.PostulanteCampanasEstados[x.PostulanteCampanasEstados.length - 1].PostulanteCampanasEstadosTipo.Eliminatorio);
        }

        if (todosSeleccionados == true) {
            //console.log("checkAll true");
            $("#postulanteAll").prop("checked", true);
            vm.CheckAll = true;
        }
        else {
            //console.log("checkAll false");
            $("#postulanteAll").prop("checked", false);
            vm.CheckAll = false;
        }
    };        

    //al cambiar algo en la tabla (página, resultados, numero de registros) se verifica si están todos seleccionados para activar el check
    $(document).ready(function () {
        $(document).on('draw.dt', function () {
            //setTimeout(function () {
                vm.checkTodosSeleccionado();
            //}, 1000);
        });
    });

    vm.getPostulantePorDni = function (dni) {
        return vm.PostulantesCampana.find(x => x.Postulante.Documento == dni);
    };

    vm.getParamsDNIselected = function (accion) {
        var dataModal = {
            listaDNIs: null,
            listaNombreColumna: null,
            tituloModal: null,
            listaPostulantesCampana: null,
            listaDatosEstatico: null,
            etiquetaDatoEstatico: null
        };

        var array = [{ nombre: "", Id: 1 }, { nombre: "", Id: 2 }, { nombre: "", Id: 3 }, { nombre: "", Id: 4 }]
        var res = array.map(x => x.Id) //[1,2,3,4]
        var res = array.map(x => x.Id == 1)// { Id: 1, nombre: "" }

        switch (accion) {
            case 'modificar_estado_postulante':
                dataModal.listaPostulantesCampana = vm.PostulantesCampana.filter(x => x.Selected && !x.ExisteSiguienteEtapa);
                dataModal.listaDNIs = vm.PostulantesCampana.filter(x => x.Selected && !x.ExisteSiguienteEtapa && !x.PostulanteCampanasEstados[x.PostulanteCampanasEstados.length - 1].PostulanteCampanasEstadosTipo.Eliminatorio).map(function (obj) {
                    var newObject = {};
                    newObject.Documento = obj.Postulante.Documento;
                    newObject.Apellido = obj.Postulante.Apellido;
                    newObject.Nombre = obj.Postulante.Nombres;
                    newObject.EstadoPostulacion = obj.PostulanteCampanasEstados[obj.PostulanteCampanasEstados.length - 1].PostulanteCampanasEstadosTipo.Descripcion;
                    return newObject;
                });
                dataModal.listaNombreColumna = ["Documento", "Apellido", "Nombre", "EstadoPostulacion"];
                dataModal.tituloModal = "ESTADO DEL POSTULANTE";
                dataModal.listaDatosEstatico = vm.EstadosEtapaPostulante.filter(x => x.EtapasId == vm.query.EtapaId);
                //    .map(function (obj) {
                //    var newObject = {};
                //    newObject.Id = obj.Id;
                //    newObject.EtapasId = obj.EtapasId;
                //    newObject.Descripcion = obj.Descripcion;
                //    return obj.EtapasId == vm.query.EtapaId;
                //});
                dataModal.etiquetaDatoEstatico = "Seleccione estado"
                break;

            case 'modificar_unidad':
                dataModal.listaPostulantesCampana = vm.PostulantesCampana.filter(x => x.Selected && !x.ExisteSiguienteEtapa && !x.PostulanteCampanasEstados[x.PostulanteCampanasEstados.length - 1].PostulanteCampanasEstadosTipo.Eliminatorio);
                dataModal.listaDNIs = vm.PostulantesCampana.filter(x => x.Selected && !x.ExisteSiguienteEtapa && !x.PostulanteCampanasEstados[x.PostulanteCampanasEstados.length - 1].PostulanteCampanasEstadosTipo.Eliminatorio).map(function (obj) {
                    var newObject = {};
                    newObject.Documento = obj.Postulante.Documento;
                    newObject.Apellido = obj.Postulante.Apellido;
                    newObject.Nombre = obj.Postulante.Nombres;
                    newObject.Unidades = obj.Postulante.Unidades && obj.Postulante.Unidades.Nombre;
                    return newObject;
                });
                dataModal.listaNombreColumna = ["Documento", "Apellido", "Nombre", "Unidades"];
                dataModal.tituloModal = "MODIFICAR UNIDAD";
                dataModal.listaDatosEstatico = vm.Unidades.map(function (obj) {
                    var newObject = {};
                    newObject.Id = obj.Id;
                    newObject.Descripcion = obj.Nombre;
                    return newObject;
                });
                dataModal.etiquetaDatoEstatico = "Seleccione unidad"
                break;

            case 'notificar_postulante':
                dataModal.listaPostulantesCampana = vm.PostulantesCampana.filter(x => x.Selected && !x.PostulanteCampanasEstados[x.PostulanteCampanasEstados.length - 1].PostulanteCampanasEstadosTipo.Eliminatorio);
                dataModal.listaDNIs = vm.PostulantesCampana.filter(x => x.Selected && !x.PostulanteCampanasEstados[x.PostulanteCampanasEstados.length - 1].PostulanteCampanasEstadosTipo.Eliminatorio).map(function (obj) {
                    var newObject = {};
                    newObject.Documento = obj.Postulante.Documento;
                    newObject.Apellido = obj.Postulante.Apellido;
                    newObject.Nombre = obj.Postulante.Nombres;
                    newObject.EmailValido = obj.Postulante.PostulanteValidaciones.EmailValido ? "SI" : "NO";
                    return newObject;
                });
                dataModal.listaNombreColumna = ["Documento", "Apellido", "Nombre", "EmailValido"];
                dataModal.tituloModal = "NOTIFICAR POSTULANTE";
                break;

            case 'modificar_mostrar_front':
                dataModal.listaPostulantesCampana = vm.PostulantesCampana.filter(x => x.Selected && !x.PostulanteCampanasEstados[x.PostulanteCampanasEstados.length - 1].PostulanteCampanasEstadosTipo.Eliminatorio);
                dataModal.listaDNIs = vm.PostulantesCampana.filter(x => x.Selected && !x.PostulanteCampanasEstados[x.PostulanteCampanasEstados.length - 1].PostulanteCampanasEstadosTipo.Eliminatorio).map(function (obj) {
                    var newObject = {};
                    newObject.Documento = obj.Postulante.Documento;
                    newObject.Apellido = obj.Postulante.Apellido;
                    newObject.Nombre = obj.Postulante.Nombres;
                    newObject.HabilitarEtapaUsuario = obj.PostulanteFrontHabilitado ? "SI" : "NO";
                    return newObject;
                });
                dataModal.listaNombreColumna = ["Documento", "Apellido", "Nombre", "HabilitarEtapaUsuario"];
                dataModal.tituloModal = "HABILITAR VISIBILIDAD EN PERFIL DEL POSTULANTE";
                dataModal.listaDatosEstatico = [{ Id: 1, Descripcion: "SI" }, { Id: 2, Descripcion: "NO"}];
                dataModal.etiquetaDatoEstatico = "Seleccione"
                break;

            case 'aprobar_etapa':
                dataModal.listaPostulantesCampana = vm.PostulantesCampana.filter(x => x.Selected && !x.ExisteSiguienteEtapa && !x.PostulanteCampanasEstados[x.PostulanteCampanasEstados.length - 1].PostulanteCampanasEstadosTipo.Eliminatorio);
                dataModal.listaDNIs = vm.PostulantesCampana.filter(x => x.Selected && !x.ExisteSiguienteEtapa && !x.PostulanteCampanasEstados[x.PostulanteCampanasEstados.length - 1].PostulanteCampanasEstadosTipo.Eliminatorio).map(function (obj) {
                    var newObject = {};
                    newObject.Documento = obj.Postulante.Documento;
                    newObject.Apellido = obj.Postulante.Apellido;
                    newObject.Nombre = obj.Postulante.Nombres;
                    newObject.EtapaAprobada = obj.EtapaAprobada ? "SI" : "NO";
                    return newObject;
                });
                dataModal.listaNombreColumna = ["Documento", "Apellido", "Nombre", "EtapaAprobada"];
                dataModal.tituloModal = "APROBAR ETAPA";
                dataModal.listaDatosEstatico = [{ Id: 1, Descripcion: "SI" }, { Id: 2, Descripcion: "NO" }];
                dataModal.etiquetaDatoEstatico = "Seleccione"
                break;

            case 'avanzar_postulante':
                dataModal.listaPostulantesCampana = vm.PostulantesCampana.filter(x => x.Selected && !x.ExisteSiguienteEtapa && !x.PostulanteCampanasEstados[x.PostulanteCampanasEstados.length - 1].PostulanteCampanasEstadosTipo.Eliminatorio);
                dataModal.listaDNIs = vm.PostulantesCampana.filter(x => x.Selected && !x.ExisteSiguienteEtapa && !x.PostulanteCampanasEstados[x.PostulanteCampanasEstados.length - 1].PostulanteCampanasEstadosTipo.Eliminatorio).map(function (obj) {
                    var newObject = {};
                    newObject.Documento = obj.Postulante.Documento;
                    newObject.Apellido = obj.Postulante.Apellido;
                    newObject.Nombre = obj.Postulante.Nombres;
                    newObject.EtapaAprobada = obj.EtapaAprobada ? "SI" : "NO";
                    return newObject;
                });
                dataModal.listaNombreColumna = ["Documento", "Apellido", "Nombre", "EtapaAprobada"];
                dataModal.tituloModal = "AVANZAR POSTULANTE A LA SIGUIENTE ETAPA";
                break;

            case 'eliminar_postulante_etapa':
                dataModal.listaPostulantesCampana = vm.PostulantesCampana.filter(x => x.Selected && !x.ExisteSiguienteEtapa && !x.PostulanteCampanasEstados[x.PostulanteCampanasEstados.length - 1].PostulanteCampanasEstadosTipo.Eliminatorio);
                dataModal.listaDNIs = vm.PostulantesCampana.filter(x => x.Selected && !x.ExisteSiguienteEtapa && !x.PostulanteCampanasEstados[x.PostulanteCampanasEstados.length - 1].PostulanteCampanasEstadosTipo.Eliminatorio).map(function (obj) {
                    var newObject = {};
                    newObject.Documento = obj.Postulante.Documento;
                    newObject.Apellido = obj.Postulante.Apellido;
                    newObject.Nombre = obj.Postulante.Nombres;
                    newObject.FechaAgregado = new Date(obj.FechaAgregado).toISOString().slice(0, 10);
                    newObject.perfilCompletado = obj.Postulante.perfilCompletado + " %";
                    return newObject;
                });
                dataModal.listaNombreColumna = ["Documento", "Apellido", "Nombre", "FechaAgregado", "perfilCompletado"];
                dataModal.tituloModal = "QUITAR DE ETAPA";
                break;
            case 'mostrar_historial_estados':
                dataModal.listaPostulantesCampana = vm.PostulantesCampana.filter(x => x.Selected);
                dataModal.listaDNIs = vm.PostulantesCampana.filter(x => x.Selected).map(function (obj) {
                    var newObject = {};
                    newObject.Documento = obj.Postulante.Documento;
                    newObject.Apellido = obj.Postulante.Apellido;
                    newObject.Nombre = obj.Postulante.Nombres;
                    newObject.Estados = obj.PostulanteCampanasEstados;
                    return newObject;
                });
                dataModal.listaNombreColumna = ["Documento", "Apellido", "Nombre", "Estados"];
                dataModal.tituloModal = "ESTADOS DEL POSTULANTE DURANTE LA ETAPA";
                break;
            case 'eliminar_ultimo_estado':
                dataModal.listaPostulantesCampana = vm.PostulantesCampana.filter(x => x.Selected);
                dataModal.listaDNIs = vm.PostulantesCampana.filter(x => x.Selected).map(function (obj) {
                    var newObject = {};
                    newObject.Documento = obj.Postulante.Documento;
                    newObject.Apellido = obj.Postulante.Apellido;
                    newObject.Nombre = obj.Postulante.Nombres;
                    newObject.Estados = obj.PostulanteCampanasEstados;
                    return newObject;
                });
                dataModal.listaNombreColumna = ["Documento", "Apellido", "Nombre", "Estados"];
                dataModal.tituloModal = "ELIMINAR ÚLTIMO ESTADO DEL POSTULANTE";
                dataModal.etiquetaDatoEstatico = "Se eliminará solo el último estado asignado al postulante"
                break;
            case 'calificar_postulante':
                dataModal.listaPostulantesCampana = vm.PostulantesCampana.filter(x => x.Selected && !x.ExisteSiguienteEtapa && !x.PostulanteCampanasEstados[x.PostulanteCampanasEstados.length - 1].PostulanteCampanasEstadosTipo.Eliminatorio);
                dataModal.listaDNIs = vm.PostulantesCampana.filter(x => x.Selected && !x.ExisteSiguienteEtapa && !x.PostulanteCampanasEstados[x.PostulanteCampanasEstados.length - 1].PostulanteCampanasEstadosTipo.Eliminatorio).map(function (obj) {
                    var newObject = {};
                    newObject.Documento = obj.Postulante.Documento;
                    newObject.Apellido = obj.Postulante.Apellido;
                    newObject.Nombre = obj.Postulante.Nombres;
                    newObject.Unidades = obj.Postulante.Unidades && obj.Postulante.Unidades.Nombre;
                    return newObject;
                });
                dataModal.listaNombreColumna = ["Documento", "Apellido", "Nombre", "Calificación"];
                dataModal.tituloModal = "CALIFICAR POSTULANTE";
                dataModal.etiquetaDatoEstatico = ""
                break;
        }

        return dataModal;
    };

    vm.CheckDNIsFromInputModal = function () {
        if (!vm.DniPorComas) {
            showDialog("DEBE INGRESAR AL MENOS UN DNI");
            return;
        }

        vm.PostulantesCampana.forEach(function (pc) {
            pc.Selected = false;
        });

        vm.DniPorComas = vm.DniPorComas.replace(/ /g, "");

        let listado = vm.DniPorComas;
        let aListados = listado.split(",");
        vm.DniPorComas = aListados[aListados.length - 1] !== ""
            ? vm.DniPorComas
            : vm.DniPorComas.slice(0, -1);

        vm.DniPorComas = vm.DniPorComas.replace(/(\r\n|\n|\r)/gm, "");
        vm.DniPorComas = vm.DniPorComas.replace(/\\n/g, '');
        vm.DniPorComas = vm.DniPorComas.replace(/\\r/g, '');
        vm.DniPorComas = vm.DniPorComas.trim();
        
        vm.DniPorComas = vm.DniPorComas.split(',').sort();
        vm.PostulantesCampana.sort((p1, p2) => (p1.Postulante.Documento < p2.Postulante.Documento) ? 1 : (p1.Postulante.Documento > p2.Postulante.Documento) ? -1 : 0);

        vm.vecOcurrencias = [];

        for (var i = 0; i < vm.DniPorComas.length; i++) {
            for (var j = 0; j < vm.PostulantesCampana.length; j++) {
                if (vm.DniPorComas[i] == vm.PostulantesCampana[j].Postulante.Documento) {
                    vm.PostulantesCampana[j].Selected = true;
                    vm.vecOcurrencias.push(vm.DniPorComas[i]);
                }
            }
        }

        vm.noEncontrados = [];
        vm.conErrores = [];

        vm.vecOcurrencias = vm.vecOcurrencias.filter((value, idx) => {
            return vm.vecOcurrencias.indexOf(value) === idx;
        });

        vm.noEncontrados = vm.DniPorComas.filter(el => !vm.vecOcurrencias.includes(el));

        vm.conErrores = vm.noEncontrados.filter(item => /[a-zA-Z!@#\$%\^\&*\)\(+=._-]+$/g.test(item));

        vm.noEncontrados = vm.noEncontrados.filter(el => !vm.conErrores.includes(el));    
        vm.DniPorComas = null;
        $("#listDNI").val("");
        vm.checkTodosSeleccionado();
        $("#resumenDNIsImportados").modal("show");
    };

    vm.ClearTextAreaDNIs = function () {
        $("#listDNI").val("");
    };

    vm.GotoMapa = function () {
        //console.log(vm.query)
        vm.seleccionarRuta("postulanteMapa/c" + vm.query.CampanaId);
    };

    vm.seleccionarRuta = function (ruta) {
        $scope.$parent.appCtrl.seleccionarRuta(ruta);
    };

    function showDialog(m) {
        $scope.$parent.appCtrl.showDialog(m.toUpperCase());
    };

    function verifyNullUndefined(str) {
        return str === null || str === undefined || str === "";
    };

    
}