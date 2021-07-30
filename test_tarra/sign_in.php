<?php
//define("DOC_ROOT","/var/www/html/simtax");
$username = 'test1';
$password = '123456';
//$path = DOC_ROOT."/test_tarra/tmp";
$rme = TRUE;
$cookie="cookie.txt";
$base_url = 'https://efaktur.indonesiaport.co.id/';
$params= array(
           "username" => $username,
           "password" => $password,
           "rememberMe" => $rme
        );
$url = $base_url.'api/v1/sign-in';
$params_string = json_encode($params);

$cookie_file_path = $path."/cookie.txt"; //tambahan


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);                                                                    
curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file_path);                                                                     
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                       
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($params_string))                                                                       
);   
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

$request = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//curl_close($ch);
echo $httpCode;

if($httpCode == 200)
{
        
        $result = json_decode($request, true);
        $token_type = "Bearer ";
        $utoken = $result['id_token'];
        $urlwp = $base_url."api/v1/wps-mine"; 
        
        //GET WP
        $api_response = getapiwp($token_type,$utoken,$urlwp,$base_url,$username,$password);
        $data_wp = json_decode($api_response, true);
        $id_wp = "";
        foreach($data_wp as $row_wp){
                $wp_id = $row_wp['id'];
        }
        echo "<b>ID WP: ".$wp_id . "</b><p>";

        
        // Get Branch Code
        $url_get_branch = $base_url."api/v1/wps/".$wp_id."/branches";
        $api_branch = getapiwp($token_type,$utoken,$url_get_branch,$base_url,$username,$password);
        $data_branch = json_decode($api_branch, true);
        $branch_code = "";
        $branch_name = "";
        $penandatangan = "";
        $createdBy = "";
        $createdDate = "";
        foreach($data_branch as $row_branch){
                $branch_code = $row_branch['code'];
                $branch_name = $row_branch['name'];
                $penandatangan = $row_branch['penandatangan'];
                $createdBy = $row_branch['createdBy'];
                $createdDate = $row_branch['createdDate'];
        }        
        echo "Branch Code: ".$branch_code . "<br>";
        echo "Branch Name: ".$branch_name . "<br>";
        //echo "Penandatangan: ".$penandatangan . "<br>";
        echo "Created By: ".$createdBy . "<br>";
        echo "Created Date: ".$createdDate . "<br><p>";
       
       
  //Upload CSV FK
        $file = $path."/sampleFakturKeluaran.csv";
        $url_upload = $base_url."api/v1/wps/".$wp_id."/upload";

        if (function_exists('curl_file_create')) { // php 5.5+
                $cFile = curl_file_create($path."/sampleFakturKeluaran.csv");
        } else { // 
                $cFile = '@' . realpath($path."/sampleFakturKeluaran.csv");
        }
        
        $p_upl= array(
                "wp_id" => $wp_id,
                "file" => $cFile
        );

        $headers = array("Content-Type:multipart/form-data");
        $request_upl = apiuploadcsv($url_upload,$username,$password,$headers,$p_upl,$ch);
        $request_upl = json_decode($request_upl, true);

  //End Upload CSV FK

        if($request_upl['status'] === 400){
                echo "Informasi Upload CSV: ". $request_upl['detail']."<br>";
                echo "PATH: ". $request_upl['path']."<br>";
                echo "<p>";
        } else {

             $encode_file = $request_upl['name'];
             $origin_file = $request_upl['origin'];
             $origin_file = basename($origin_file);
             echo "<b>//Upload CSV Faktur Keluaran result </b><br>";    
             echo "Encode File: " .$encode_file ."<br> Origin File: ". $origin_file;

             //Import Faktur Keluaran
                $url_imp_fk = $base_url."api/v1/wps/".$wp_id."/faktur-keluaran-lives-import";
                
                $p_imp_fk= array(
                        "wpId" => "" . $wp_id . "",
                        "name" => $encode_file,
                        "origin" => $origin_file,
                        "delimiter" => ";",
                        "ext" => "csv",
                        "branchCode" => $branch_code
                );
                     
                $params_imp_fk = json_encode($p_imp_fk);
                $h_imp_fk = array("Content-Type:application/json");
                $req_imp_fk = apiimportcsv($url_imp_fk,$username,$password,$params_imp_fk,$h_imp_fk,$ch);
                $req_imp_fk = json_decode($req_imp_fk, true); 
              //End Import Faktur Keluaran    
              
                if($req_imp_fk['status'] != '') {
                        echo "<br><br>";
                        echo "<b>//Import Faktur Keluaran </b><br>";
                        if($req_imp_fk['detail'] != ''){
                                echo "Informasi Import FK: ". $req_imp_fk['detail']."<br>";
                        }
                        echo "Faktur Keluaran ID: ". $req_imp_fk['id']."<br>";
                        echo "Encode File: ". $req_imp_fk['name']."<br>";
                        echo "Origin File: ". $req_imp_fk['origin']."<br>";
                        echo "Status: ". $req_imp_fk['status']."<br>";
                        echo "Created By: ". $req_imp_fk['createdBy']."<br>";
                        echo "Created Date: ". $req_imp_fk['createdDate']."<br>";
                        echo "Last Modified By: ". $req_imp_fk['lastModifiedBy']."<br>";
                        echo "Last Modified Date: ". $req_imp_fk['lastModifiedDate']."<br>";
                        echo "Error: ". $req_imp_fk['error']."<br>";
                        echo "<p>";
                        
                }

         //UPLOAD FILE CSV Faktur Masukan
                $file = $path."/SampleFakturMasukan.csv";
                $url_upload = $base_url."api/v1/wps/".$wp_id."/upload";

                if (function_exists('curl_file_create')) { // php 5.5+
                        $cFile = curl_file_create($path."/SampleFakturMasukan.csv");
                } else { // 
                        $cFile = '@' . realpath($path."/SampleFakturMasukan.csv");
                }
                
                $p_upl= array(
                        "wp_id" => $wp_id,
                        "file" => $cFile
                );

                $headers = array("Content-Type:multipart/form-data");
                $request_upl = apiuploadcsv($url_upload,$username,$password,$headers,$p_upl,$ch);
                $request_upl = json_decode($request_upl, true);
   
                $encode_file_fm = $request_upl['name'];
                $origin_file_fm = $request_upl['origin'];
                $origin_file_fm = basename($origin_file_fm);
                echo "<b>//Upload CSV Faktur Masukan result </b><br>";  
                echo "Encode File: ".$encode_file_fm." <br> Origin File: ".$origin_file_fm;
        //END UPLOAD Faktur Masukan

                //Import Faktur Masukan
                $url_imp_fm = $base_url."api/v1/wps/".$wp_id."/faktur-masukan-lives-import";
                
                $p_imp_fm= array(
                        "wpId" => "" . $wp_id . "",
                        "name" => $encode_file_fm,
                        "origin" => $origin_file_fm,
                        "delimiter" => ";",
                        "ext" => "csv",
                        "branchCode" => $branch_code
                );
                     
                $params_imp_fm = json_encode($p_imp_fm);
                $h_imp_fm = array("Content-Type:application/json");
                $req_imp_fm = apiimportcsv($url_imp_fm,$username,$password,$params_imp_fm,$h_imp_fm,$ch);
                $req_imp_fm = json_decode($req_imp_fm, true); 
              //End Import Faktur Keluaran  
         
              if($req_imp_fm['status'] != '') {
                echo "<br><br>";
                echo "<b>//Import Faktur Masukan </b><br>";
                if($req_imp_fm['detail'] != ''){
                        echo "Informasi Import FK: ". $req_imp_fm['detail']."<br>";
                }
                echo "Faktur Masukan ID: ". $req_imp_fm['id']."<br>";
                echo "Encode File: ". $req_imp_fm['name']."<br>";
                echo "Origin File: ". $req_imp_fm['origin']."<br>";
                echo "Status: ". $req_imp_fm['status']."<br>";
                echo "Created By: ". $req_imp_fm['createdBy']."<br>";
                echo "Created Date: ". $req_imp_fm['createdDate']."<br>";
                echo "Last Modified By: ". $req_imp_fm['lastModifiedBy']."<br>";
                echo "Last Modified Date: ". $req_imp_fm['lastModifiedDate']."<br>";
                echo "Error: ". $req_imp_fm['error']."<br>";
                echo "<p>";

                //Upload file CSV Dokumen Lain Keluaran
                        $file = $path."/SampleDokLainKeluaran.csv";
                        $url_upload = $base_url."api/v1/wps/".$wp_id."/upload";

                        if (function_exists('curl_file_create')) { // php 5.5+
                                $cFile = curl_file_create($path."/SampleDokLainKeluaran.csv");
                        } else { // 
                                $cFile = '@' . realpath($path."/SampleDokLainKeluaran.csv");
                        }
                        
                        $p_upl= array(
                                "wp_id" => $wp_id,
                                "file" => $cFile
                        );

                        $headers = array("Content-Type:multipart/form-data");
                        $request_upl = apiuploadcsv($url_upload,$username,$password,$headers,$p_upl,$ch);
                        $request_upl = json_decode($request_upl, true);
        
                        $encode_file_dk = $request_upl['name'];
                        $origin_file_dk = $request_upl['origin'];
                        $origin_file_dk = basename($origin_file_dk);
                        echo "<b>//Upload CSV Dokumen Lain Keluaran </b><br>";  
                        echo "Encode File: ".$encode_file_dk." <br> Origin File: ".$origin_file_dk;
                //End upload Dokumen Lain Keluaran

                //Import Dokumen Lain Keluaran
                        $url_imp_dk = $base_url."api/v1/wps/".$wp_id."/dokumen-keluaran-lives-import";
                        
                        $p_imp_dk= array(
                                "wpId" => "" . $wp_id . "",
                                "name" => $encode_file_dk,
                                "origin" => $origin_file_dk,
                                "delimiter" => ";",
                                "ext" => "csv",
                                "branchCode" => $branch_code
                        );
                        
                        $params_imp_dk = json_encode($p_imp_dk);
                        $h_imp_dk = array("Content-Type:application/json");
                        $req_imp_dk = apiimportcsv($url_imp_dk,$username,$password,$params_imp_dk,$h_imp_dk,$ch);
                        $req_imp_dk = json_decode($req_imp_dk, true); 
                //End Import Dokumen Lain Keluaran
                        
                        if($req_imp_dk['status'] != '') {
                                echo "<br><br>";
                                echo "<b>//Import Dokumen Lain Keluaran </b><br>";
                                if($req_imp_dk['detail'] != ''){
                                        echo "Informasi Import DK: ". $req_imp_dk['detail']."<br>";
                                }
                                echo "Dokumen Keluaran ID: ". $req_imp_dk['id']."<br>";
                                echo "Encode File: ". $req_imp_dk['name']."<br>";
                                echo "Origin File: ". $req_imp_dk['origin']."<br>";
                                echo "Status: ". $req_imp_dk['status']."<br>";
                                echo "Created By: ". $req_imp_dk['createdBy']."<br>";
                                echo "Created Date: ". $req_imp_dk['createdDate']."<br>";
                                echo "Last Modified By: ". $req_imp_dk['lastModifiedBy']."<br>";
                                echo "Last Modified Date: ". $req_imp_dk['lastModifiedDate']."<br>";
                                echo "Error: ". $req_imp_dk['error']."<br>";
                                echo "<p>";
                        }
                
             }
     
        }
        
                //Upload file CSV Dokumen Lain Masukan
                $file = $path."/SampleDokLainMasukan.csv";
                $url_upload = $base_url."api/v1/wps/".$wp_id."/upload";

                if (function_exists('curl_file_create')) { // php 5.5+
                        $cFile = curl_file_create($path."/SampleDokLainMasukan.csv");
                } else { // 
                        $cFile = '@' . realpath($path."/SampleDokLainMasukan.csv");
                }
                
                $p_upl= array(
                        "wp_id" => $wp_id,
                        "file" => $cFile
                );

                $headers = array("Content-Type:multipart/form-data");
                $request_upl = apiuploadcsv($url_upload,$username,$password,$headers,$p_upl,$ch);
                $request_upl = json_decode($request_upl, true);

                $encode_file_dm = $request_upl['name'];
                $origin_file_dm = $request_upl['origin'];
                $origin_file_dm = basename($origin_file_dm);
                echo "<b>//Upload CSV Dokumen Lain Masukan </b><br>";  
                echo "Encode File: ".$encode_file_dm." <br> Origin File: ".$origin_file_dm;
                //End upload Dokumen Lain Masukan

                //Import Dokumen Lain Masukan
                $url_imp_dm = $base_url."api/v1/wps/".$wp_id."/dokumen-masukan-lives-import";
                        
                $p_imp_dm= array(
                        "wpId" => "" . $wp_id . "",
                        "name" => $encode_file_dm,
                        "origin" => $origin_file_dm,
                        "delimiter" => ";",
                        "ext" => "csv",
                        "branchCode" => $branch_code
                );
                
                $params_imp_dm = json_encode($p_imp_dm);
                $h_imp_dm = array("Content-Type:application/json");
                $req_imp_dm = apiimportcsv($url_imp_dm,$username,$password,$params_imp_dm,$h_imp_dm,$ch);
                //curl_close($ch);
                $req_imp_dm = json_decode($req_imp_dm, true);
                $id_import_dm = $req_imp_dm['id']; 

                if($req_imp_dm['status'] != '') {
                        echo "<br><br>";
                        echo "<b>//Import Dokumen Lain Masukan </b><br>";
                        if($req_imp_dm['detail'] != ''){
                                echo "Informasi Import DM: ". $req_imp_dm['detail']."<br>";
                        }
                        echo "Dokumen Masukan ID: ". $req_imp_dm['id']."<br>";
                        echo "Encode File: ". $req_imp_dm['name']."<br>";
                        echo "Origin File: ". $req_imp_dm['origin']."<br>";
                        echo "Status: ". $req_imp_dm['status']."<br>";
                        echo "Created By: ". $req_imp_dm['createdBy']."<br>";
                        echo "Created Date: ". $req_imp_dm['createdDate']."<br>";
                        echo "Last Modified By: ". $req_imp_dm['lastModifiedBy']."<br>";
                        echo "Last Modified Date: ". $req_imp_dm['lastModifiedDate']."<br>";
                        echo "Error: ". $req_imp_dm['error']."<br>";
                        echo "<p>";
                }

                //End Import Dokumen Lain Masukan

                //Log Import
                $urllogimp = $base_url."api/v1/wps/".$wp_id."/log-imports/".$id_import_dm; 
        
                //GET Log Import
                $api_response = getapiwp($token_type,$utoken,$urllogimp,$base_url,$username,$password);
                $datalog = json_decode($api_response, true);
                //var_dump($datalog);
                $idlog = "";
                $idlog = $datalog['id'];
                /*
                foreach($datalog as $row_log){
                        $idlog = $row_log['id'];
                }
                */
                
                echo "<b>ID Log Dokumen Lain Masukan: ".$idlog . "</b><p>";
                echo "WP ID: ".$datalog['wpId']."<br>";
                echo "Modul: ".$datalog['module']."<br>";
                echo "Status: ".$datalog['status']."<br>";
                echo "Description: ".$datalog['description']."<br>";
                echo "Delimiter: ".$datalog['delimiter']."<br>";
                echo "Total: ".$datalog['total']."<br>";
                echo "Error: ".$datalog['error']."<br>";

                //End Import Log

                //Detil log import
                $p_dtl_log= array(
                        "id" => "" . $idlog . ""
                );
                $params_dtl_log = json_encode($p_dtl_log);
                $h_imp_dm = array("Content-Type:application/json");
                $urldtllogimp = $base_url."api/v1/wps/".$wp_id."/log-imports/".$id_import_dm."/download"; 
                $api_response = getapiwp($token_type,$utoken,$urldtllogimp,$base_url,$username,$password);
                //$req_imp_dtl = apiimportcsv($urldtllogimp,$username,$password,$params_dtl_log,$h_imp_dm,$ch);
                $dtldatalog = json_decode($req_imp_dtl, true);
                print_r($api_response);
                                        //$insert_log['DESCRIPTION_LOG_IMPORT'] = $dtldatalog['description'];

        
} else {
        $result = json_decode($request, true);
        echo $result;
}

/*
function getapiwp($token_type,$utoken,$urlwp,$base_url,$username,$password){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urlwp); 
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_USERPWD, $username.":".$password);                                                                                                                                     
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                  
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Authorization" => $token_type . $utoken,
                "Host" => $base_url,
            ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $result = curl_exec($ch);
        
        if(!$result){die("Connection Failure");}
        curl_close($ch);

        return $result; 
}

function apiuploadcsv($url_upload,$username,$password,$headers,$p_upl,$ch){
        curl_setopt($ch, CURLOPT_URL, $url_upload);
        curl_setopt($ch, CURLOPT_USERPWD, $username.":".$password);   
        curl_setopt($ch, CURLOPT_POST,1);                                                                                            
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);                                                               
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $p_upl);  
        $request_upl = curl_exec($ch);

        return $request_upl;
}

function apiimportcsv($url_imp,$username,$password,$params_imp,$h_imp,$ch){
        curl_setopt($ch, CURLOPT_URL, $url_imp);
        curl_setopt($ch, CURLOPT_USERPWD, $username.":".$password);                                                                     
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params_imp);                                                                  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
        curl_setopt($ch, CURLOPT_HTTPHEADER, $h_imp);;   
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $req_imp = curl_exec($ch);
        if(!$req_imp){die("Connection Failure");}

        return $req_imp;
}


?>

