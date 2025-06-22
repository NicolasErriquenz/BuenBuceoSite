angular
    .module("angularApp")
    .controller("campanasListadoController",
        ["$location", "$scope", "ngOidcClient", "adminService",
            function ($location, $scope, ngOidcClient, adminService) {
                var vm = this;

                vm.busy = {
                    promise: [],
                    message: "Cargando..."
                };

                vm.CampanasOficial = [];
                vm.CampanasSuboficial = [];

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

                vm.CargarCampanas = function () {

                    vm.busy.message = "CARGANDO DATOS DE CAMPAÑAS...";

                    vm.busy.promise.push(adminService.CargarCampanas(
                        vm.query,
                        function (response) {
                            vm.Campanas = response;

                            angular.forEach(vm.Campanas, function(campana) {

                                if (campana.CarrerasId == 1)
                                    vm.CampanasOficial.push(campana);
                                if (campana.CarrerasId == 2)
                                    vm.CampanasSuboficial.push(campana);
                            });
                        },
                        function (e) {
                            console.log("ERROR CargarCampanas", e);
                            showDialog(e.data.Message);
                        }
                    ));
                };

                vm.CargarCampanas();

                vm.etapasConPostulantesFn = function (value) {
                    return value.cantPostulantes !== 0;
                };

                vm.checkPermiso = function(permiso) {
                    $scope.$parent.appCtrl.checkPermiso(permiso);
                };

                vm.seleccionarRuta = function (ruta) {
                    $scope.$parent.appCtrl.seleccionarRuta(ruta);
                };

                function verifyNullUndefined(str) {
                    return str === null || str === undefined || str === "";
                };

                function showDialog(m) {
                    $scope.$parent.appCtrl.showDialog(m.toUpperCase());
                };
            }
        ]
    );