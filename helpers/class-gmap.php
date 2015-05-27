<?php
namespace helpers;

class GMap {

	public static function get_latlng($address) {

		$url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&sensor=false&key='.GOOGLE_PUBLIC_KEY;
		// Make the HTTP request
		$data = @file_get_contents($url);
		// Parse the json response
		$jsondata = json_decode($data,true);
		if ($jsondata["status"] != "OK"){
			return array();
		}

		$LatLng = array(
			'lat' => $jsondata["results"][0]["geometry"]["location"]["lat"],
			'lng' => $jsondata["results"][0]["geometry"]["location"]["lng"],
		);

		return $LatLng;
	}
	public static function getLocation($address){
		$gmap_url = 'http://maps.google.com/maps/api/geocode/json?sensor=false&address=';
        $url = $gmap_url . urlencode($address);

        $resp_json = self::curl_file_get_contents($url);
        $resp = json_decode($resp_json, true);

        if($resp['status']='OK'){
			if( isset($resp['results'][0]['geometry']['location']) ){
				return $resp['results'][0]['geometry']['location'];
			}
        }else{
            return false;
        }
        return false;
    }
    private static function curl_file_get_contents($URL){
        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_URL, $URL);
        $contents = curl_exec($c);
        curl_close($c);

        if ($contents) return $contents;
            else return FALSE;
    }
} // End text
