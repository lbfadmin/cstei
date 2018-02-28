/**
 * Created by kevin on 17-3-14.
 */
(function () {
    // chart3
    var $chart3 = $('#chart3');
    var chart3 = echarts.init($chart3[0]);
    var mapStyles = {
        styleJson: [{
            "featureType": "water",
            "elementType": "all",
            "stylers": {
                "color": "#044161"
            }
        }, {
            "featureType": "land",
            "elementType": "all",
            "stylers": {
                "color": "#091934"
            }
        }, {
            "featureType": "boundary",
            "elementType": "geometry",
            "stylers": {
                "color": "#064f85"
            }
        }, {
            "featureType": "railway",
            "elementType": "all",
            "stylers": {
                "visibility": "off"
            }
        }, {
            "featureType": "highway",
            "elementType": "geometry",
            "stylers": {
                "color": "#004981"
            }
        }, {
            "featureType": "highway",
            "elementType": "geometry.fill",
            "stylers": {
                "color": "#005b96",
                "lightness": 1
            }
        }, {
            "featureType": "highway",
            "elementType": "labels",
            "stylers": {
                "visibility": "on"
            }
        }, {
            "featureType": "arterial",
            "elementType": "geometry",
            "stylers": {
                "color": "#004981",
                "lightness": -39
            }
        }, {
            "featureType": "arterial",
            "elementType": "geometry.fill",
            "stylers": {
                "color": "#00508b"
            }
        }, {
            "featureType": "poi",
            "elementType": "all",
            "stylers": {
                "visibility": "off"
            }
        }, {
            "featureType": "green",
            "elementType": "all",
            "stylers": {
                "color": "#056197",
                "visibility": "off"
            }
        }, {
            "featureType": "subway",
            "elementType": "all",
            "stylers": {
                "visibility": "off"
            }
        }, {
            "featureType": "manmade",
            "elementType": "all",
            "stylers": {
                "visibility": "off"
            }
        }, {
            "featureType": "local",
            "elementType": "all",
            "stylers": {
                "visibility": "off"
            }
        }, {
            "featureType": "arterial",
            "elementType": "labels",
            "stylers": {
                "visibility": "off"
            }
        }, {
            "featureType": "boundary",
            "elementType": "geometry.fill",
            "stylers": {
                "color": "#029fd4"
            }
        }, {
            "featureType": "building",
            "elementType": "all",
            "stylers": {
                "color": "#1a5787"
            }
        }, {
            "featureType": "label",
            "elementType": "all",
            "stylers": {
                "visibility": "off"
            }
        }, {
            "featureType": "poi",
            "elementType": "labels.text.fill",
            "stylers": {
                "color": "#ffffff"
            }
        }, {
            "featureType": "poi",
            "elementType": "labels.text.stroke",
            "stylers": {
                "color": "#1e1c1c"
            }
        }, {
            "featureType": "administrative",
            "elementType": "labels",
            "stylers": {
                "visibility": "on"
            }
        },{
            "featureType": "road",
            "elementType": "labels",
            "stylers": {
                "visibility": "off"
            }
        }]
    };
    var geo = new BMap.Geocoder();

    geo.getPoint('中国', function (point) {
        var map = new BMap.Map("chart3", {
            enableMapClick: false

        });

         point = new BMap.Point(117.2923462035,34.2101460969); 
        //map.point();
        map.setMapStyle(mapStyles);
       // map.centerAndZoom('济南');
        map.centerAndZoom(point, 5);
        //map.centerAndZoom('济南');
        map.enableScrollWheelZoom(false); // 开启鼠标滚轮缩放
        $.getJSON('/home/ajax/monitoring-point/get-all').then(function (result) {
            var data = [];
            var points = [];
            $.each(result.data.list, function (k, item) {
              //  alert(item.lng);
                points.push([item.lat,item.lng]);
                // points.push([item.lng, item.lat]);
            });
            for (var i = 0; i < points.length; i++) {
                var geoCoord = points[i];
                data.push({
                    geometry: {
                        type: 'Point',
                        coordinates: geoCoord
                    },
                    time: Math.random() * 10
                });
            }

            var dataSet = new mapv.DataSet(data);
            var options = {
                fillStyle: 'rgba(255, 250, 50, 0.6)',
                shadowColor: 'rgba(255, 250, 50, 0.5)',
                shadowBlur: 2,
                updateCallback: function (time) {
                    time = time.toFixed(2);
                    $('#time').html('时间' + time);
                },
                size: 3,
                draw: 'simple',
                animation: {
                    type: 'time',
                    stepsRange: {
                        start: 0,
                        end: 10
                    },
                    trails: 3,
                    duration: 2
                }
            };
            var mapvLayer = new mapv.baiduMapLayer(map, dataSet, options);
        });

    });
 
})();