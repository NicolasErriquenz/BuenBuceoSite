angular
    .module("angularApp")
    .controller("homeController",
        ["$location", "$scope", "ngOidcClient", "homeService",
            function ($location, $scope, ngOidcClient, homeService) {
                var vm = this;
                vm.bienvenida = "Bienvenidos";
                vm.user = ngOidcClient.getUserInfo();

                vm.mostrarTerminos = vm.user.isAuthenticated;

                vm.busy = {
                    promise: null,
                    message: "Cargando..."
                };

                vm.GetStats = function() {
                    // vm.busy.promise = homeService.GetEstadisticasHome(
                    //     function (response) {
                    //         vm.Stats = response.data;
                    //         vm.MostrarStats();
                    //         console.log(vm.Stats);
                    //     },
                    //     function (e) { console.log("ERROR GetEstadisticasHome", e); }
                    // );
                }

                vm.SetStats = function () {
                    vm.busy.promise = homeService.SetEstadisticasHome(
                        function (response) {
                            vm.GetStats();
                        },
                        function (e) { console.log("ERROR SetEstadisticasHome", e); }
                    );
                }

                vm.GetStats();

                vm.MostrarStats = function() {

                    vm.crearGrafico(vm.Stats.DetalleTotalesPorEscalafonOficiales.Items, 'pie', "DetalleTotalesPorEscalafonOficiales", true);

                    vm.crearGrafico(vm.Stats.DetalleTotalesPorEscalafonSuboficiales.Items, 'pie', "DetalleTotalesPorEscalafonSuboficiales", true);

                    vm.crearGrafico(vm.Stats.PostulantesPerfilCompleto.Items, 'pie', "DetalleTotalesPerfilesCompletados", true);

                    vm.crearGrafico(vm.Stats.InscriptosPorSexoEPN.Items, 'bar', "bar_chart_InscriptosPorSexoEPN");

                    vm.crearGrafico(vm.Stats.InscriptosPorSexoES.Items, 'bar', "bar_chart_InscriptosPorSexoES");

                };

                vm.crearGrafico = function (items, chartType, div, addCantidadToDescription) {

                    var labels = [];
                    var data = [];
                    angular.forEach(items,
                        function (item) {
                            var descripcion = item.Descripcion;
                            if (addCantidadToDescription)
                                descripcion += " (" + item.Cantidad + ")";
                            labels.push(descripcion);
                            data.push(item.Cantidad);
                        }
                    );

                    var backgroundsPie = ["#3e95cd", "#8e5ea2", "#3cba9f", "#c45850"];
                    var backgroundsBar = ["#3cba9f", "#c45850", "#3e95cd", "#8e5ea2"];

                    new Chart(document.getElementById(div), {
                        type: chartType,
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    backgroundColor: chartType == "pie" ? backgroundsPie : backgroundsBar,
                                    data: data
                                }
                            ]
                        },
                        options: {
                            legend: { display: false },
                            title: {
                                display: true,
                                text: ''
                            }
                        }
                    });

                };

                vm.usuario = $scope.$parent.appCtrl.user();
                console.log(vm.usuario);

                vm.seleccionarRuta = function (ruta) {
                    $scope.$parent.appCtrl.seleccionarRuta(ruta);
                };

            }]
    );