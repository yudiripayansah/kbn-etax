<?php

defined('BASEPATH') or exit('No direct script access allowed');


  if (!function_exists('djp_get_token')) {
      function djp_get_token($user, $pwd)
      {
          $url = 'https://api-eservice.indonesiaport.co.id/api_djp/v1/getToken.php/wsdl?user='.$user.'&pwd='.$pwd.'&base_url=https://ws.pajak.go.id/djp/';
          $payload = [
            'user' => $user,
            'pwd' => $pwd,
            'base_url' => 'https://ws.pajak.go.id/djp/',
          ];
          $type = 'POST';
          return djp_curl($url, $type, $payload);
      }
  }
  if (!function_exists('djp_check_kswp')) {
      function djp_check_kswp($token, $npwp, $kdizin=1)
      {
          $url = 'https://api-eservice.indonesiaport.co.id/api_djp/v1/getKswp.php/wsdl?auth='.$token.'&npwp='.$npwp.'&kdizin='.$kdizin.'&base_url=https://ws.pajak.go.id/djp/';
          $payload = [
            'npwp' => $npwp,
            'kdizin' => $kdizin,
            'base_url' => 'https://ws.pajak.go.id/djp/',
          ];
          $type = 'POST';
          $header = [
            'Authorization' => $token
          ];
          return djp_curl($url, $type, $payload, $header);
      }
  }
  if (!function_exists('djp_check_npwp')) {
      function djp_check_npwp($token, $npwp)
      {
          $url = 'https://api-eservice.indonesiaport.co.id/api_djp/v1/getNpwp.php/wsdl?auth='.$token.'&npwp='.$npwp.'&base_url=https://ws.pajak.go.id/djp/';
          $payload = [
            'npwp' => $npwp,
            'base_url' => 'https://ws.pajak.go.id/djp/',
          ];
          $type = 'POST';
          $header = [
            'Authorization' => $token
          ];
          return djp_curl($url, $type, $payload, $header);
      }
  }
  function djp_curl($url, $type, $payload = null, $header = null)
  {
      $curl = curl_init();
      curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $type,
      ));
      $response = json_decode(curl_exec($curl));
      curl_close($curl);
      return $response;
  }
