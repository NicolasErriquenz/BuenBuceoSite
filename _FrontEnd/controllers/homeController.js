angular
    .module("angularApp")
    .controller("homeController",
        ["$location", "$scope", "ngOidcClient", "homeService",
            function ($location, $scope, ngOidcClient, homeService) {
                var vm = this;
                
                vm.query = {
                    name: "",
                    email: "",
                    msg: "",
                };

                $scope.videoSuperior = "media/pexels-adrien-jacta-6430503.mp4";
                $scope.videoInferior = "media/pexels-adrien-jacta-5358755.mp4";

                console.log(vm.videoSuperior);
                vm.busy = {
                    promise: null,
                    message: "Cargando..."
                };

                vm.usuario = $scope.$parent.appCtrl.user();
                console.log(vm.usuario);

                vm.seleccionarRuta = function (ruta) {
                    $scope.$parent.appCtrl.seleccionarRuta(ruta);
                };
                
                vm.sendMsg = function(){
                    console.log(vm.query);

                    vm.busy.promise = homeService.sendMsg(
                        vm.query,
                        function (response) {
                            //console.log(response);
                            $("#myModal").modal("show");
    
                            //vm.inicializarQuery();
                        },
                        function (e) {
                            //console.log("ERROR ProcesarEnvioMasivoMails", e);
                            console.log(e);

                            $("#myModal").modal("show");
                        }
                    );
                };

                //link whatsapp 
                //https://api.whatsapp.com/send/?text=Che%20te%20comparto%20este%20sitio%20para%20que%20aprendas%20a%20bucear%20https://buenbuceo.ar&type=custom_url&app_absent=0
            }]
    );