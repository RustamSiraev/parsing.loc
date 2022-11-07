@extends('layouts.app')

@php

    $url = 'https://museum.sf4.simai.ru/ru/';
    $userAgent = 'Mozilla/5.0 (X11; Linux x86_64; rv:104.0) Gecko/20100101 Firefox/104.0';

        $curl = curl_init();
            $header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
            $header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
            $header[] = "Cache-Control: max-age=0";
            $header[] = "Connection: keep-alive";
            $header[] = "Keep-Alive: 300";
            $header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
            $header[] = "Accept-Language: en-us,en;q=0.5";
            $header[] = "Pragma: ";
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_USERAGENT => $userAgent,
                CURLOPT_HTTPHEADER => $header,
                CURLOPT_REFERER => 'https://www.google.com',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CONNECTTIMEOUT => 120,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HEADER => false,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false
            ));

            $data['data'] = curl_exec($curl);
            $data['url'] = curl_getinfo($curl, CURLINFO_EFFECTIVE_URL);
            $data['code'] = curl_getinfo($curl, CURLINFO_HTTP_CODE);

            curl_close($curl);

			dd($data);
@endphp
