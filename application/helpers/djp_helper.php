<?php

defined('BASEPATH') or exit('No direct script access allowed');


  if (!function_exists('check_kswp')) {
      function djp_get_token()
      {
          $url = 'https://ws.pajak.go.id/djp/token?user=pelindo1&pwd=Sos7Rk1';
          $payload = [
            'user' => 'pelindo3',
            'pwd' => 'pelindo3'
          ];
          $type = 'POST';
          return djp_curl($url, $type, $payload);
      }
  }
  if (!function_exists('check_kswp')) {
      function djp_check_kswp($token, $npwp, $kdizin=0)
      {
          $url = 'https://ws.pajak.go.id/djp/kswp?npwp=000000000000&kdizin=1111';
          $payload = [
            'npwp' => $npwp,
            'kdizin' => $kdizin
          ];
          $type = 'POST';
          $header = [
            'Authorization' => $token
          ];
          return djp_curl($url, $type, $payload, $header);
      }
  }
  if (!function_exists('check_kswp')) {
      function djp_check_npwp($token, $npwp)
      {
          $url = 'https://ws.pajak.go.id/djp/npwp?npwp=000000000000';
          $payload = [
            'npwp' => $npwp,
          ];
          $type = 'POST';
          $header = [
            'Authorization' => $token
          ];
          return djp_curl($url, $type, $payload, $header);
      }
  }
  if (!function_exists('check_kswp')) {
      function djp_curl($url, $type, $payload, $header = null)
      {
          // persiapkan curl
          $ch = curl_init();

          // set url
          curl_setopt($ch, CURLOPT_URL, $url);
      
          // set user agent
          curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

          // set header
          if ($header) {
              curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
          }

          // return the transfer as a string
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

          // request type
          curl_setopt($ch, CURLOPT_POST, ($type == 'POST') ? 1 : 0);

          // parameters / payload
          curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

          // $output contains the output string
          $output = curl_exec($ch);

          // tutup curl
          curl_close($ch);

          // mengembalikan hasil curl
          return $output;
      }
  }
