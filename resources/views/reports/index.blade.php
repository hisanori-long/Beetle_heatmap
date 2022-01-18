
<x-app-layout>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>home</title>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.0/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.3.0/dist/leaflet.js"></script>
  <script>
    const reports=@json($reports); // phpの変数をjavascriptいいこう
    const species=@json($species)

    function init() { //mapの表示
      //ズームコントロールを非表示で地図を作成
      var map = L.map('mapcontainer', { zoomControl: false });
      map.setView([33.59, 130.40], 11);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution:  '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
      }).addTo(map);
      //スケールコントロールを最大幅200px、右下、m単位で地図に追加
      L.control.scale({ maxWidth: 200, position: 'bottomright', imperial: false }).addTo(map);
      //ズームコントロールを左下で地図に追加
      L.control.zoom({ position: 'bottomleft' }).addTo(map);
      for (const i in reports){
        const report=reports[i]
        var name=species[report["species_id"]]["name"];
        var image_url="/"+report["image_url"];
        var sucontent=name+'<img src='+image_url+' style="max-width:350px;">';
        var popup = L.popup({ maxWidth: 550 }).setContent(sucontent);

        L.marker([report["lat"],report["lon"]],{title:report["id"]}).bindPopup(popup).addTo(map);
      }
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
                    <div id="mapcontainer" style="width:1100px;height:600px;margin-left:auto;margin-right:auto;"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
          @foreach($reports as $report)
            <div>
                    <?php 
                      //カブトムシ名を所得
                      $spece_id = $report->species_id; //各レポートのspece_idを定義
                      $species_array = json_decode($species, true);
                      $spece=$species_array[array_search($spece_id ,array_column($species_array, "id"))];
                      //投稿したユーザを所得
                      $user_id=$report->user_id; //各レポートのuser_idを定義
                      $users_array = json_decode($users,true);
                      $user=$users_array[array_search($user_id ,array_column($users_array, "id"))];
                    ?>
                      <p class="font-semibold text-xl text-gray-800 leading-tight">{{$spece["name"]}}</p>
                      <div style="display: flex;margin-bottom:20px;margin-top:10px;">
                        <img src="/{{$report -> image_url}}" style="width:200px;height:135px;margin-left:10px;">
                        <div style="margin-top:20px;">
                          <p class="font-semibold text-l text-gray-800 leading-tight" style="margin-left:20px;margin-top:3px;">発見者：{{$user["name"]}}</p>
                          <p class="font-semibold text-l text-gray-800 leading-tight" style="margin-left:20px;margin-top:3px;">大きさ：{{$report->size}} cm</p>
                          <p class="font-semibold text-l text-gray-800 leading-tight" style="margin-left:20px;margin-top:3px;">発見日：{{$report->created_at}}</p>
                          @if($report->sexual === 1)
                            <p class="font-semibold text-l text-gray-800 leading-tight" style="margin-left:20px;margin-top:3px;">性別　：オス</p>
                          @else
                            <p class="font-semibold text-l text-gray-800 leading-tight" style="margin-left:20px;margin-top:3px;">性別　：メス</p>
                          @endif
                          <p class="font-semibold text-m text-gray-800 leading-tight" style="margin-left:20px;margin-top:20px;">{{$report->comment}}</p>
                        </div>
                      </div>
                      <p style="border-bottom: 1px solid gray;margin-bottom:30px;"></p>
            </div>
          @endforeach
          </div>
        </div>
      </div>
    </div>
</body>
</html>
</x-app-layout>
