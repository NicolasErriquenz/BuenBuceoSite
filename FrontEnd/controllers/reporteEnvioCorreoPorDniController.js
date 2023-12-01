angular
    .module("angularApp")
    .controller("reporteEnvioCorreoPorDniController", ["$scope", "datosEstaticosService", "adminService", "$location", "$document",
        function ($scope, datosEstaticosService, adminService, $location, $document) {
            var vm = this;

            vm.busy = {
                promise: [],
                message: "Cargando..."
            };

            vm.EnvioActual = null;

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
                lengthMenu: [[10, 15, 25, 50, -1], [10, 15, 25, 50, 'TODOS']],
                language: vm.language,
                scrollX: true,
                order: [0, 'desc'],
            };

            vm.busy.message = "Obteniendo datos...";
            vm.busy.promise.push(adminService.GetReporteMails(
                vm.query,
                function (response) {
                    console.log(response);
                    vm.ResumenEnvioMails = response;
                },
                function (e) {
                    console.log("ERROR ProcesarEnvioMasivoMails", e);
                    showDialog(e.data.Message);
                }
            ));

            vm.seleccionarElemento = function (e) {
                vm.EnvioActual = e;
            }

            vm.seleccionarRuta = function (ruta) {
                $scope.$parent.appCtrl.seleccionarRuta(ruta);
            };

            function showDialog(m) {
                $scope.$parent.appCtrl.showDialog(m);
            };

            vm.checkPermiso = function (permiso) {
                return $scope.$parent.appCtrl.user().data ? $scope.$parent.appCtrl.user().data.profile.role.includes(permiso) : false;
            };

            function verifyNullUndefined(str) {
                return str === null || str === undefined || str === "";
            };
        }
    ]);