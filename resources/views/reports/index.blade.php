
<x-app-layout>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>home</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.0/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.3.0/dist/leaflet.js"></script>
  <script>
    function init() {
      //ズームコントロールを非表示で地図を作成
      var map = L.map('mapcontainer', { zoomControl: false });
      map.setView([33.59, 130.40], 10);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution:  '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
      }).addTo(map);
      //スケールコントロールを最大幅200px、右下、m単位で地図に追加
      L.control.scale({ maxWidth: 200, position: 'bottomright', imperial: false }).addTo(map);
      //ズームコントロールを左下で地図に追加
      L.control.zoom({ position: 'bottomleft' }).addTo(map);
    }
  </script>
</head>
<body onload="init()">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('カブトムシの分布図') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                <div id="mapcontainer" style="width:600px;height:600px"></div>
                
                </div>
            </div>
        </div>
    </div>
</body>
</html>
</x-app-layout>
