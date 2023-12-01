angular
    .module("angularApp")
    .factory("homeService", ["$resource", "urls",
        function ($resource, urls) {
            return $resource(
                urls.serverUrl + "api/home/",
                { id: "@id" },
                {
                    GetEstadisticasHome: {
                        method: "GET",
                        isArray: false,
                        url: urls.serverUrl + "api/estadisticas/GetEstadisticasHome",
                        transformResponse: function (data) {
                            return { data: angular.fromJson(data) };
                        }
                    },
                    SetEstadisticasHome: {
                        method: "GET",
                        isArray: false,
                        url: urls.serverUrl + "api/estadisticas/SetEstadisticas"
                    },
                }
            );
        }
    ]);