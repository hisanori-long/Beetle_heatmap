<x-app-layout>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>heatmap</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.0/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.3.0/dist/leaflet.js"></script>
  <script src="https://d19vzq90twjlae.cloudfront.net/leaflet-0.7/leaflet.js"></script>
  <script src="{{ asset('js/leaflet-heat.js') }}"></script>

  <script>
    const reports=@json($reports); // phpの変数をjavascriptに移行


    function init(){
        var map = L.map('map').setView([33.59, 130.40], 11);
        mapLink = 
            '<a href="http://openstreetmap.org">OpenStreetMap</a>';
        L.tileLayer(
            'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; ' + mapLink + ' Contributors',
            maxZoom: 18,
        }).addTo(map);

        var reportPoints = [];
        for (const i in reports){
          const report=reports[i];
          console.log([report["lat"], report["lon"], 20]);
          reportPoints.push([report["lat"], report["lon"], 20]);
        }
        
        var heat = L.heatLayer(reportPoints,{
            radius: 20,
            blur: 15, 
            maxZoom: 17,
            minOpacity: 0.8,
            gradient:{0.7: 'blue', 0.8: 'lime', 0.85: 'red'},
        }).addTo(map);
    }

  </script>
</head>
<body onload="init()">
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('外来種の分布') }}
    </h2>
  </x-slot>
    <div class="py-12">
        <div class=" max-w-7xl mx-auto sm:w-10/12 md:w-8/10 lg:w-8/12">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div id="map" style="width: 600px; height: 400px"></div>
                    <!-- <div id="map-canvas" style="width:1100px;height:600px;margin-left:auto;margin-right:auto;"></div> -->
                    {{$reports}}
                </div>
            </div>
        </div>
    </div>
</body>
</html>
</x-app-layout>



