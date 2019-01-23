<?php 

function handlefileupload($old_image, $imgfile, $folder=''){
	if (isset($imgfile) && $imgfile!= '') {
		$date = date("m-d-y-H-i-s");
		$uploadfileNameArr = explode(".", $imgfile);
		$filename = md5("image" . rand(999,9999)) . "-" . $date .'.'. $uploadfileNameArr[count($uploadfileNameArr)-1];
		$upload_to_temp = "temp_img/" . $imgfile;
		$ftp_path = '../images/'.trim($folder)."/".$filename;
		$ret_path = trim($folder)."/".$filename;
		if (file_exists($upload_to_temp)) {	
			if(copy('temp_img/'.$imgfile,$ftp_path)){
				unlink($upload_to_temp);
				$image_up = $ftp_path;
				if ($old_image != '') {
					unlink($old_image);
				}
				return $ret_path;
			}else{
				return '';
			} 
	
		}else{
			return '';
		
		}
		
	}
	return '';
}

function ins_rec($tab,$array,$disp=false)	
{	
	$conn = mysqlConncet();
	$array = ($array);
	$qry = "insert into $tab set "; 
	if (count($array) > 0)
	{
		foreach ($array as $k=>$v)
		{
			$qry .= "`$k`='".$v."',";
		}
	}
	$qry=trim($qry,",");
	if ($disp)

		echo $qry;
	$err = mysqlQuery($conn,$qry);
	if (!$err){
		return false;	
	}
	else{
		return mysqlLastId($err);

	}
}
function upd_rec($tab,$array,$where="1=1",$disp=false)
{
	$conn = mysqlConncet();
	$array = ($array);
	$qry = "update $tab set ";
	if (count($array) > 0)
	{
		foreach ($array as $k=>$v)
		{
			$qry .= "$k='".$v."',";
		}
	}
	$qry=trim($qry,",")." where ".$where;				
	if ($disp)
		echo $qry;
	$err = mysqlQuery($conn,$qry);		
	if (!$err)
	{
		return false;
	}
	else{
		return true;
	}

}

function del_rec($tab,$where="1=1",$disp=false){
	$conn = mysqlConncet();
	$qry = "delete from $tab where $where";
	if ($disp)
		echo $qry;
	$err = mysqlQuery($conn,$qry);
	if (!$err){
		return false;
	}
	else{
		return true;
	}
}

function getRequest($key)
{
	$con = mysqlConncet();
	return mysqlRealescapestring($con, trim($_REQUEST[$key]));
}

function get_current_date_time(){
	/*$conn = mysqlConncet();
	$get_current_date_time_qry = mysqlQuery($conn,"SELECT NOW() as current_date_time");
	$get_current_date_time_row = mysqlFetchArray($get_current_date_time_qry);*/
	return date("Y-m-d H:i:s"); //$get_current_date_time_row['current_date_time'];
}
function check_duplicate($table_name,$col_name,$value,$id_col,$id_col_val,$mode){
	
	$conn = mysqlConncet();
	if($mode=='insert'){
		$result = mysqlQuery($conn,"SELECT $col_name FROM $table_name WHERE $col_name='".$value."'");
	}else{
		$result = mysqlQuery($conn,"SELECT $col_name,$id_col FROM $table_name WHERE $col_name='".$value."' AND $id_col<>'".$id_col_val."'");
	}
	
	$rows = myasqlNumRow($result);
	if($rows > 0){
		echo "record_exists";
	}else{
		echo "record_not_exists";
	}
	
}

function RandomPassword($len){
	$chars = "abcdefghijklmnopqrstuvwxyz0123456789";
	for($i=0; $i<$len; $i++) 
	{
		$r_str .= substr($chars,rand(0,strlen($chars)),1);
	}
	return $r_str;
}

function get_quiz_dropdown($selected_id){
	$conn = mysqlConncet();
	$select_quiz_qry_var = "SELECT aq_id,aq_quizname FROM aq_quiz WHERE aq_status='Active'";
	$select_quiz_qry = mysqlQuery($conn,$select_quiz_qry_var);
	while($select_quiz_row =  mysqlFetchArray($select_quiz_qry)){
	?>
    <option value="<?php echo $select_quiz_row['aq_id']?>" <?php if($selected_id==$select_quiz_row['aq_id']){echo "selected";}?>><?php echo $select_quiz_row['aq_quizname']?></option>
    <?php
	}
}

function encode($string)
{
 for($i=0;$i<strlen($string);$i++)
	{
		$var1 = (48)+(3+$string[$i]);
		$var2 = chr($var1);
		$encodedCC .= $var2;
	}
	return base64_encode($encodedCC);
}

function decode($string)
{
  $string = base64_decode($string);
  for($i=0;$i<strlen($string);$i++)
  {
	  $var1 = ord($string[$i]);
	  $var2 = $var1 - (48+(3));
	  $decodedCC .= $var2;
  }
  return $decodedCC;
}

/*function safe_encode($string) {
    return strtr(base64_encode($string), '+/=', '-_-');
}

function safe_decode($string) {
    return base64_decode(strtr($string, '-_-', '+/='));
}*/

function SendHTMLMail($to,$subject,$content,$headers)
{
			$from1 = "noreply@webzexperts.com";
			$headers  = "MIME-Version: 1.0"."\r\n";
			$headers .= "Content-type:text/html;charset=UTF-8"."\r\n";
			$headers .= "From: $from1\r\n";
			mail($to,$subject,$content,$headers);
}
function generateimageuserftp($imgbase64,$location,$addurl){

	$urlofimg="";
	$date = date("m-d-Y");
	$filename = md5("imgscsa" . rand(999,9999)) . "_" . $date.trand(6) . ".jpg";

	$imgData = base64_decode($imgbase64);
	$file=$location. $filename;
	$fp = fopen($file, 'w');
	fwrite($fp, $imgData);
	fclose($fp); 
	$urlofimg="user_photo/" . $filename;



if ($addurl){
	if ($urlofimg !=''){
	   $urlofimg=API."images/".$urlofimg;	
	}
}else{
	
}
return $urlofimg;
}


function my_simple_crypt( $string, $action = 'e' ) {
    // you may change these values to your own
    $secret_key = 'Qu1ZC4';
     $secret_iv = '2018';
	
 
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash( 'sha1', $secret_key );
    $iv = substr( hash( 'sha1', $secret_iv ), 0, 16 );
 
    if( $action == 'e' ) {
        $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
    }
    else if( $action == 'd' ){
        $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
    }
 
    return $output;
}


/* Encryption Class */
class MCrypt {

    private $iv = '1111111111111111'; #Same as in JAVA              
    private $key = 'Qu1ZC4'; #Same as in JAVA

    function __construct() {
        $this->key = hash('sha256', $this->key, true);
    }

    function encrypt($str) {
        $iv = $this->iv;
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
        mcrypt_generic_init($td, $this->key, $iv);
        $block = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
        $pad = $block - (strlen($str) % $block);
        $str .= str_repeat(chr($pad), $pad);
        $encrypted = mcrypt_generic($td, $str);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return base64_encode($encrypted);
    }

    function decrypt($code) {
        $iv = $this->iv;
        $td = mcrypt_module_open('rijndael-128', '', 'cbc', '');
        mcrypt_generic_init($td, $this->key, $iv);
        $str = mdecrypt_generic($td, base64_decode($code));
        $block = mcrypt_get_block_size('rijndael-128', 'cbc');
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return $str;
        //return $this->strippadding($str);             
    }

    /*
      For PKCS7 padding
     */
    private function addpadding($string, $blocksize = 16) {
        $len = strlen($string);
        $pad = $blocksize - ($len % $blocksize);
        $string .= str_repeat(chr($pad), $pad);
        return $string;
    }

    private function strippadding($string) {
        $slast = ord(substr($string, -1));
        $slastc = chr($slast);
        $pcheck = substr($string, -$slast);
        if (preg_match("/$slastc{" . $slast . "}/", $string)) {
            $string = substr($string, 0, strlen($string) - $slast);
            return $string;
        } else {
            return false;
        }
    }

}
/* End*/

?>