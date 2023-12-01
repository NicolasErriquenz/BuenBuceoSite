angular
    .module("angularApp")
    .controller("encabezadoCampanaComponentController", ["$location", "$scope", "$rootScope", "adminService", encabezadoCampanaComponentController]);

function encabezadoCampanaComponentController($location, $scope, $rootScope, adminService ) {

    var vm = this;

    $scope.$on('cambiarEtapaEncabezado', function (event, obj) {
        //console.log("Escuché al padre");
        //console.log(obj);
        vm.EtapaId = obj;
    });

    $scope.$on('RefreshNumerosEncabezado', function (event, obj) {
        //console.log("Escuché al padre");
        //console.log(obj);
        vm.campana = obj;
    });  

    vm.ConfirmarCierreCampana = function () {
        $(".confirm_cerrar_campana").modal("show");
    };

    vm.CerrarCampana = function () {
        $(".confirm_cerrar_campana").modal("hide");
        vm.busy = {
            promise: [],
            message: ""
        };

        vm.busy.message = "CERRANDO CAMPAÑA...";

        vm.busy.promise.push(adminService.CerrarCampana(
            vm.campana,
            function (response) {
                PNotify.success({
                    title: 'CAMPAÑA CERRADA',
                    text: 'El registro se actualizo con éxito',
                    type: 'success',
                    delay: 3000
                });
                //COMUNICAR AL PADRE QUE PIDA vm.GetDatosCampana();
                vm.GetDatosCampana();

            },
            function (e) {
                console.log("ERROR CerrarCampana", e);
                showDialog(e.data.Message);
            }
        ));
    };

    vm.ConfirmarCancelarCampana = function () {
        $(".confirm_cancelar_campana").modal("show");
    };

    vm.CancelarCampana = function () {
        $(".confirm_cancelar_campana").modal("hide");
        vm.busy = {
            promise: [],
            message: ""
        };

        vm.busy.message = "CANCELANDO CAMPAÑA...";

        vm.busy.promise.push(adminService.CancelarCampana(
            vm.campana,
            function (response) {
                PNotify.success({
                    title: 'CAMPAÑA CANCELADA',
                    text: 'El registro se actualizo con éxito',
                    type: 'success',
                    delay: 3000
                });

                vm.seleccionarRuta("/campanasListado");

            },
            function (e) {
                console.log("ERROR CancelarCampana", e);
                showDialog(e.data.Message);
            }
        ));
    };

    vm.ConfirmarDescargarExcelPostulantes = function () {
        if (vm.ProcesandoReporte)
            return;
        $(".confirm_descargarExcel_campana").modal("show");
    };

    vm.ProcesandoReporte = false;
    vm.DescargarPostulantesCampana = function (TipoEstadoPostulante) {
        $(".confirm_descargarExcel_campana").modal("hide");
        var hoy = new Date();

        vm.ProcesandoReporte = true;
        vm.busy = {
            promise: [],
            message: ""
        };
        
        vm.campana.TipoEstadoPostulante = TipoEstadoPostulante;

        vm.busy.message = "PROCESANDO LISTADO DE POSTULANTES DE CAMPAÑA...";

        vm.busy.promise.push(adminService.DescargarPostulantesCampana(
            vm.campana,
            function (response) {
                //console.log(response);
                var n = replaceAll(vm.campana.Id + "_" + vm.campana.Nombre, " ", "_") +
                    "_Postulantes_" +
                    hoy.getFullYear() +
                    "_" +
                    (hoy.getMonth() + 1) +
                    "_" +
                    hoy.getDate() +
                    ".xlsx";
                //var nombreReporte = CleanStringUtf8Chars(n);
                n = n.replace("-", TipoEstadoPostulante == 2 ? "Activos" : "Historico");
                var nombreReporte = (n);
                vm.descargarResponse(response, nombreReporte);
                vm.ProcesandoReporte = false;
            },
            function (e) {
                console.log("ERROR DescargarPostulantesCampana", e);
                showDialog("hubo un error al procesar el reporte");
                vm.ProcesandoReporte = false;
            }
        ));
    };

    vm.descargarResponse = function (response, nombreReporte) {
        //console.log(response);
        //var fileName = response.headers["content-disposition"].split("=")[1].replace(/\"/gi, "");
        var fileName = nombreReporte;
        var fileType = response.headers["content-type"] + ";charset=utf-8";
        var blob = new Blob([response.data], { type: fileType });
        var objectUrl = window.URL || window.webkitURL;
        var link = angular.element("<a/>");

        link.css({ display: "none" });
        link.attr({
            href: objectUrl.createObjectURL(blob),
            target: "_blank",
            download: fileName
        });
        link[0].click();
        // clean up
        link.remove();
        objectUrl.revokeObjectURL(blob);
    };

    //vm.PostulantesParaNotificar = null;
    //vm.ConfirmarNotificacionUsuarios = function () {
    //    vm.PostulantesParaNotificar = 0;
    //    angular.forEach(vm.PostulantesCampana,
    //        function (p) {
    //            if (p.PostulanteNotificado == "NO" && p.Habilitado_sys)
    //                vm.PostulantesParaNotificar++;
    //        }
    //    );

    //    if (vm.PostulantesParaNotificar == 0) {
    //        showDialog("NO HAY POSTULANTES PENDIENTES PARA NOTIFICAR");
    //        return;
    //    }
    //    $(".confirm_dialog_notificar_usuarios").modal("show");
    //};

    vm.ReporteNotifaciones = null;

    vm.DniPorComas = null;

    vm.ProcesarDniPorComas = function () {

        vm.busy = {
            promise: [],
            message: "PROCESANDO LISTADO DE DNI..."
        };

        vm.query = {
            DniPorComas: vm.DniPorComas,
            CampanaId: vm.campana.Id
        }

        if (!vm.DniPorComas) {
            showDialog("DEBE INGRESAR AL MENOS UN DNI");
            return;
        }

        vm.DniPorComas = vm.DniPorComas.replace(/ /g, "");

        var listado = vm.DniPorComas;
        var aListados = listado.split(",");
        vm.DniPorComas = aListados[aListados.length - 1] !== ""
            ? vm.DniPorComas
            : vm.DniPorComas.slice(0, -1);

        vm.DniPorComas = vm.DniPorComas.replace(/(\r\n|\n|\r)/gm, "");
        vm.DniPorComas = vm.DniPorComas.replace(/\\n/g, '');
        vm.DniPorComas = vm.DniPorComas.replace(/\\r/g, '');
        vm.DniPorComas = vm.DniPorComas.trim();

        vm.busy.promise = adminService.AgregarPostulantesCampana(
            vm.query,
            function (response) {
                console.log(response);
                vm.DniPorComas = null;
                vm.ResumenImportacion = response;

                $("#modalResumenImportacion").modal("show");

                $scope.$emit("actualizar_postulantes");
            },
            function (e) {
                console.log("ERROR AgregarPostulantesCampana", e);
                showDialog(e.data.Message);
            }
        );

    };

    vm.volver = function () {
        $location.path("/campanasListado");
    }

    function replaceAll(str, find, replace) {
        return str.replace(new RegExp(escapeRegExp(find), 'g'), replace);
    }

    function escapeRegExp(string) {
        return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'); // $& means the whole matched string
    }

    vm.seleccionarRuta = function (ruta) {
        $scope.$parent.appCtrl.seleccionarRuta(ruta);
    };

    function showDialog(m) {
        $scope.$parent.appCtrl.showDialog(m.toUpperCase());
    };
}