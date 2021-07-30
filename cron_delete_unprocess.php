<?php
	$files = glob('download/ebs_coba/unprocess/{,.}*', GLOB_BRACE);
	foreach($files as $file){ // iterate files
	  if(is_file($file))
	    unlink($file); // delete file
	}

	echo "manjiw : MANTAP JIWA";


?>