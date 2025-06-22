angular
    .module("angularApp")
    .factory("homeService", ["$resource", "urls",
        function ($resource, urls) {
            return $resource(
                urls.serverUrl + "api/home/",
                { id: "@id" },
                {
                    sendMsg: {
                        method: "POST",
                        isArray: false,
                        url: urls.serverUrl + "sendMsg.php",
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                        transformRequest: function(obj) {
                            var str = [];
                            for (var p in obj)
                            str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
                            return str.join("&");
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