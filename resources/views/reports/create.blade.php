<x-app-layout>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.0/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.3.0/dist/leaflet.js"></script>
  <script type='text/javascript'>alert('危険が予想される地域には、立ち入らないでください！');</script>
  <script>
    //地図オブジェクトを入れる変数をグローバルにする
    var map;
    var addMarker = null;
    var lonlat=null;

    function init() {
      map = L.map('mapcontainer', { zoomControl: false });
      map.setView([33.59, 130.40], 11);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution:  '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
      }).addTo(map);
      L.control.scale({ maxWidth: 200, position: 'bottomright', imperial: false }).addTo(map);
      //地図のclickイベントでonMapClick関数を呼び出し
      map.on('click', onMapClick);
    }
    function onMapClick(e) {
      //地図のclickイベント呼び出される
      //クリック地点の座標にマーカーを追加、マーカーのclickイベントでonMarkerClick関数を呼び出し
      if(addMarker){
        map.removeLayer(addMarker);
        addMarker = null;
        lonlat=null;
      }

      lonlat=e.latlng;
      addMarker = L.marker(e.latlng).addTo(map);

      document.getElementById("latlon_id_lat").value = e.latlng.lat;
      document.getElementById("latlon_id_lon").value = e.latlng.lng;

    }
  </script>
</head>
<body onload="init()">
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('レポートの作成') }}
    </h2>
  </x-slot>

  <div class="py-12">
        <div class="max-w-7xl mx-auto sm:w-8/12 md:w-1/2 lg:w-5/12">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form class="mb-6" action="{{ route('reports.store', ['species_id' =>$spece_id])}}" method="POST" name="myForm" id="myForm" enctype="multipart/form-data">
                        @csrf
                        <div class="flex flex-col mb-4">
                          <label class="mb-2 uppercase font-bold text-lg text-grey-darkest">見つけた場所</label>
                          <div id="mapcontainer" style="width:1000px;height:500px"></div>
                          <label class="mb-2 uppercase font-bold text-lg text-grey-darkest" for="lat">緯度</label>
                          <input id=latlon_id_lat name="lat" type="text" placeholder="Input">

                          <label class="mb-2 uppercase font-bold text-lg text-grey-darkest" for="lon">経度</label>
                          <input id=latlon_id_lon name="lon" type="text" placeholder="Input">

                          <label class="mb-2 uppercase font-bold text-lg text-grey-darkest" for="text">大きさ[cm]</label>
                          <input class="border py-2 px-3 text-grey-darkest" type="text" name="size" id="size">

                          <label class="mb-2 uppercase font-bold text-lg text-grey-darkest" name="sex" for="tweet">性別</label>
                          {{Form::select('sex', ['オス', 'メス'])}}

                          <label class="mb-2 uppercase font-bold text-lg text-grey-darkest" for="comment">コメント</label>
                          <input class="border py-2 px-3 text-grey-darkest" type="text" name="comment" id="comment">

                          <label class="mb-2 uppercase font-bold text-lg text-grey-darkest" for="image">画像</label>
                          <input type="file" name="image" accept="image/png, image/jpeg" />
                        </div>
                        <button onclick="funcBtn();" type="submit" class="w-full py-3 mt-6 font-medium tracking-widest text-black uppercase bg-black shadow-lg focus:outline-none hover:bg-gray-900 hover:shadow-none">
                            submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
</x-app-layout>



