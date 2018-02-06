<?php

include '../data/MapData.class.php';
include '../models/MapPin.class.php';

/*
 * MapService Class
 *  > Contains Functionality to pull data for mapped objects
 */
class MapService {

    /*
     * Initialize Map Object
     */
    public function initMap($elementID, $centerLongitude, $centerlatitude, $mapType) {
        $mapInit = "
            <script type='text/javascript'>
                map = new google.maps.Map(document.getElementById($elementID), {
                  center: {lat: $centerlatitude, lng: $centerLongitude},
                  zoom: 25,
                  mapTypeId: $mapType,
                  mapTypeControl: false,
                  streetViewControl: false
                });
            </script>
        ";

        return $mapInit;
    }

    /**
     * Gets all Mappable objects from the database and returns them as map pins.
     * @return array - returns array of map pins
     */
    public function getAllTrackableObjectsAsPins(){
        echo "MapService getAllTrackableObjectsAsPins() <br/>";

        $mapData = new MapData();
        $pinData = $mapData->getAllTrackableObjectPinData();
        $allMapPins = array();

        foreach($pinData as $pinArray){
            $pin = new MapPin(
                $pinArray['idTrackableObject'],
                $pinArray['type'],
                $pinArray['longitude'],
                $pinArray['latitude'],
                $pinArray['name'],
                $pinArray['pinColor']
            );

           array_push($allMapPins, $pin);
        }

        return $allMapPins;
    }


    public function createMapPins(pinObjectsArray) {
        $generatedMark$ers = "";
        $markerCounter = 0;
        $markerName = "marker" . $markerCounter;
        $setMarkerCode = $markerName . ".setMap(map);";
        foreach ($pinObjectsArray as $pin) {
            $markerName = "marker" . $markerCounter;
            $generatedMarkers .= "var " . $markerName . " = new google.maps.Marker({
            position: {lat: " . $pin -> getLatitude() . ", lng: " . $pin -> getLongitude() . "},
            icon:'" . $pin -> getPinDesign() . "',
            title: '" . $pin -> getName() . "' ,
            map: map });";
            $infoWidowConfig = $this -> generateInfoWindowConfig($pin, $markerName);
            $generatedMarkers .= $infoWidowConfig . $setMarkerCode;
            $markerCounter += 1;
        }
        return $generatedMarkers;
    }


}
?>