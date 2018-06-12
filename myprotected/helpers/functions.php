<?php
//check for allowed list of ips 
function prf() {
	$htref= extract(parse_url($_SERVER['HTTP_REFERER']));
    $htref= $host;
    if ("$htref" != $_SERVER['HTTP_HOST']){
        exit("Error: 1001 prf ") ;
    }
}

// Правильная урезка строки по количеству символов в UTF-8
function cropStr($str, $size)
{
	return mb_substr($str,0,mb_strrpos(mb_substr($str,0,$size,'utf-8'),' ','utf-8'),'utf-8');
}

function safedata($value){

    if(!isset($value)) {
    	return '';	
    }
    
    if (is_string($value)) {
    	$value = trim($value);
    	$value=htmlentities($value, ENT_QUOTES, 'utf-8');
    }    
        
    return $value;
}

function xss_clean($data){
	
	if (is_array($data)) {
		$cleaned_array = array();
		
		foreach($data as $name => $value) {
			$cleaned_array[$name] = safedata($value);
		}
		return $cleaned_array;		
	}
	return $cleaned_data = safedata($data);
}

function _post($param,$defvalue = '') {
    if(!isset($_POST[$param])) 	{
        return $defvalue;
    }
    else {
        return safedata($_POST[$param]);
    }
}

function _get($param,$defvalue = '')
{
    if(!isset($_GET[$param])) {
        return $defvalue;
    }
    else {
        return safedata($_GET[$param]);
    }
}

function _action() {
    if(!isset($_POST['action'])) 	{
        return false;
    }
    else {
        return safedata($_POST['action']);
    }
}

function _pre( $arr, $ext=false ) {
    echo "<pre>";
	print_r($arr);
	echo "</pre>";
	
	if($ext) exit();
}

function lc($v){
    global $config;
    $c = $config[$v];
    return $c;
}

function r2($to,$ntype='e',$msg=''){
    if($msg==''){
        header("HTTP/1.1 301 Moved Permanently");
        header("location: $to"); exit;
    }
   $_SESSION['ntype']=$ntype ; $_SESSION['notify']=$msg ;
   header("HTTP/1.1 301 Moved Permanently");
   header("location: $to"); exit;
}

function r3($ntype='e',$msg=''){
	$_SESSION['ntype']=$ntype ; $_SESSION['notify']=$msg;
}

// Выводит уведомления, которые мы храним в сессии в стиле BOOTSTRAP
function notify(){
    if(isset($_SESSION['notify'])) {
        $notify = $_SESSION['notify'];
        $ntype = $_SESSION['ntype'];
        if ($ntype=='s') {
            echo "<div class=\"alert alert-success\">            
  				  <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
   				  <strong>$notify</strong>
  				  </div>";
        } else {
           echo "<div class=\"alert alert-error\">
  				 <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
  				 <strong>$notify</strong> 
				 </div>";
        }
		
		$_SESSION['notify'] = NULL;
		$_SESSION['ntype'] = NULL;
		
       // unset($_SESSION['notify']);
       // unset($_SESSION['ntype']);
    }
}

// Пишем в логи любую информацию по типу
function _log($type,$details,$userid='0') {
    global $db;
    $date = date('Y-m-d H:i:s');
    $ip=$_SERVER['REMOTE_ADDR'];
    $query = "
            INSERT INTO  [pre]logs 
            (date ,type ,description ,userid ,ip) 
            VALUES 
            ('$date', '$type', '$details', '$userid', '$ip');
            ";
    return $db->q($query,0,1,1); // INSERT PARAMS (return last insert ID)
}

// random unique id
function _raid($l){
  $r=  substr(str_shuffle(str_repeat('0123456789',$l)),0,$l);
    return $r;
    
}

// simple email template engine
function _render($template,$data){
    foreach($data as $key => $value)
    {
        $template = str_replace('{{'.$key.'}}', $value, $template);
    }

    return $template;
}

// simple encode text
function _encode ($string){
    $encoded = base64_encode(uniqid().$string);
    return $encoded;
}

// simple decode text
function _decode ($string){
    $decoded = base64_decode($string);
    $orig = substr($decoded, 13);
    return $orig;
}

// пишем в логи любую отправку на Email
function emailLog($userid,$email,$from,$subject,$message){
  global $db;
  $date = date('Y-m-d H:i:s');
  $ip=$_SERVER['REMOTE_ADDR'];
  $query = "
            INSERT INTO  [pre]email_logs 
            (`userid` , `email`, `from` ,`subject` ,`message` ,`date`,`ip`) 
            VALUES 
            ('$userid', '$email', '$from', '$subject', '$message', '$date', '$ip');
            ";
  return $db->q($query,0,1,1); // INSERT PARAMS (return last insert ID)
}

// Удаляет все лишние пробелы в тексте
function trim_all($string){
    return  preg_replace('/\s+/', '', $string);
}

function deformat_date($val){
    $result = "";
    $monthes = array('','янв.','фев.','мар.','апр.','мая','июня','июля','авг.','сен.','окт.','нбр.','дек.');

    if(strtotime($val) > strtotime(date("d.m.Y",time())." 00:00:00")){
        $result = "Сегодня, ".date("H:i",strtotime($val));
    }elseif(strtotime($val) < strtotime(date("d.m.Y",time())." 00:00:00") &&
                    strtotime($data[$item_num]['dateCreate']) > (strtotime(date("d.m.Y",time())." 00:00:00")-86400)){
            $result = "Вчера, ".date("H:i",strtotime($val));
    }
    else{
        $result = date("d",strtotime($val))." ".$monthes[(int)date("m",strtotime($val))]." ".
                                                                ", ".
                                                                date("H:i",strtotime($val));
    }
    return $result;
}

// Другой метод обрезки строки
function next_sub_str($str,$len){
    return implode(array_slice(explode('<br>',wordwrap($str,$len,'<br>',false)),0,1));
}

// Метод предназначен для создания превью файла
function dodge_ChangeImageSize($filename, $savepath, $ext, $neww, $newh){
	$idata=getimagesize($filename);
	$oldw=$idata[0];
	$oldh=$idata[1];
	$ext = strtolower($ext);
	if($ext=='jpg' or $ext=='jpeg'){ 
		$im=@imagecreatefromjpeg($filename);
			if($im)
			{
			if($oldw>$oldh) (double)$ratio=(double)$oldw/ (double)$neww;
			else(double)$ratio=(double)$oldh/ (double)$newh;
			$dest=imagecreatetruecolor($oldw/$ratio,$oldh/$ratio);
			$white = ImageColorAllocate($dest, 255,255,255);
			imagefill($dest, 1, 1, $white);
			imagecopyresampled($dest, $im, 0, 0, 0, 0, $oldw/$ratio, $oldh/$ratio, $oldw, $oldh);
			imageJPeG($dest,$savepath);
			imageDestroy($im);
			imageDestroy($dest);
			return true;
			}
	}elseif($ext=='gif'){
		$im=imagecreatefromgif($filename);
			if($oldw>$oldh) (double)$ratio=(double)$oldw/ (double)$neww;
			else(double)$ratio=(double)$oldh/ (double)$newh;
			$dest=imagecreatetruecolor($oldw/$ratio,$oldh/$ratio);
			$white = ImageColorAllocate($dest, 255,255,255);
			imagefill($dest, 1, 1, $white);
			imagecopyresampled($dest, $im, 0, 0, 0, 0, $oldw/$ratio, $oldh/$ratio, $oldw, $oldh);
			imagegif($dest,$savepath);
			imageDestroy($im);
			imageDestroy($dest);
			return true;
	}elseif($ext=='png'){
		$im=imagecreatefrompng($filename);
			if($oldw>$oldh) (double)$ratio=(double)$oldw/ (double)$neww;
			else (double)$ratio=(double)$oldh/ (double)$newh;
			$dest=imagecreatetruecolor($oldw/$ratio,$oldh/$ratio);
			$white = ImageColorAllocate($dest, 255,255,255);
			imagefill($dest, 1, 1, $white);
			imagecopyresampled($dest, $im, 0, 0, 0, 0, $oldw/$ratio, $oldh/$ratio, $oldw, $oldh);
			imagepng($dest,$savepath);
			imageDestroy($im);
			imageDestroy($dest);
			return true;
	}
	return false;
}

// Метод возвращает название разширения файла
function dodge_file_ext($filename){
		$test = $filename;
		$result = "";
		$cnt = 0;
		while($cnt < strlen($test))
		{
			if($test[strlen($test)-$cnt] == '.'){break;}
			$result .= $test[strlen($test)-$cnt];
			$cnt++;
		}
		$result = strrev($result);
		return $result;
}
	
// Метод приема картинки через массив $_FILES
function dodge_mono_file($arr,$multi = false)
{
/*	array(
			'path'			=>"Путь к каталогу",
			'name'			=>"имя картинки [1-5]",
			'pre'			=>"приставка к имени файла",
			'size'			=>"допустимый размер в Мб",
			'rule'			=>"тип правила проверки размерности [0-4]",
			'max_w'			=>"максимальная ширина",
			'max_h'			=>"максимальная высота",
			'files'			=>"имя $_FILES",
			'resize_path'	=>"путь к папке превью mid | 0",
			'resize_w'		=>"ширина mid фалйа | 0",
			'resize_h'		=>"высота mid фалйа | 0",
			'resize_path_2'	=>"путь к папке превью min | 0",
			'resize_w_2'	=>"ширина min фалйа | 0",
			'resize_h_2'	=>"высота mid фалйа | 0"
		  ) */
	/* 1  */ $path			= $arr['path'];				// путь к каталогу
	/* 2  */ $name			= $arr['name'];				// имя картинки: ->
								// 1 - оставить
								// 2 - сгенерировать используя текущую дату и время + то что было
								// 3 - сгенерировать используя текущую дату и время
								// 4 - использовать приставку (пункт 4)
								// 5 - приставка из п.4 + сгенерированное имя из даты и времени
							
	/* 3  */ $pre			= $arr['pre'];				// приставка имени файла
	/* 4  */ $size			= $arr['size'];				// допустимый размер файла в Mb
	/* 5  */ $rule			= (int)$arr['rule'];				// Тип правила проверки на правильность расзмерности файла: ->
								// 0 - без проверки
								// 1 - учитывать пункт 6 и 7
								// 2 - строго квадрат
								// 3 - строго учитывать равность пункта 6 и 7
								// 4 - учтение пропорции [W:H] между пунктами 6 и 7
							
	/* 6  */ $max_w				= (int)$arr['max_w'];			// максимальная ширина
	/* 7  */ $max_h				= (int)$arr['max_h'];			// максимальная высота
	/* 8  */ $files				= $arr['files'];			// имя $_FILES
	/* 9  */ $resize_path 		= (isset($arr['resize_path']) ? $arr['resize_path'] : "0");		// путь к папке превью mid | 0
	/* 10 */ $resize_w			= (isset($arr['resize_w']) ? $arr['resize_w'] : 0);			// ширина mid фалйа | 0
	/* 11 */ $resize_h			= (isset($arr['resize_h']) ? $arr['resize_h'] : 0);			// высота mid фалйа | 0
	/* 12 */ $resize_path_2		= (isset($arr['resize_path_2']) ? $arr['resize_path_2'] : "0");	// путь к папке превью min | 0
	/* 13 */ $resize_w_2		= (isset($arr['resize_w_2']) ? $arr['resize_w_2'] : 0);		// ширина min фалйа | 0
	/* 14 */ $resize_h_2		= (isset($arr['resize_h_2']) ? $arr['resize_h_2'] : 0);		// высота mid фалйа | 0
	
	if($name < 1 || $name > 5){$name = 1;}
	if($rule < 0 || $rule > 4){$rule = 0;}

	$filepath = $path;
	if(!$multi)$filename = $_FILES[$files]['name'];else $filename = $_FILES[$files]['name'][$multi];

	$buf_filename = $filename;

	$file_extension = dodge_file_ext($filename);

	if($name == 1){$filename = $buf_filename;}
	if($name == 2){$filename = date('YmdHis').rand(100,1000)."_".$buf_filename;}
	if($name == 3){$filename = date('YmdHis').rand(100,1000).'.'.$file_extension;}
	if($name == 4){$filename = $pre.'.'.$file_extension;}
	if($name == 5){$filename = $pre.date('YmdHis').rand(100,1000).'.'.$file_extension;}

	$filepath .= $filename;

	if($resize_path != "0"){$resize_path .= $resize_w."x".$resize_h."_".$filename;}
	if($resize_path_2 != "0"){$resize_path_2 .= $resize_w_2."x".$resize_h_2."_".$filename;}

	if(!$multi)$buf_size = $_FILES[$files]['size']; else $buf_size = $_FILES[$files]['size'][$multi];
	if(!$multi)$buf_tmp_name = $_FILES[$files]['tmp_name']; else $buf_tmp_name = $_FILES[$files]['tmp_name'][$multi];

	if($buf_size != 0 && $buf_size<=1024000*$size)
	{
		if(move_uploaded_file($buf_tmp_name, $filepath))
		{
			$size = getimagesize($filepath);
			if($rule == 0)
			{
				if($resize_path != "0"){
					dodge_ChangeImageSize($filepath, $resize_path, $file_extension, $resize_w, $resize_h);}
				if($resize_path_2 != "0"){
					dodge_ChangeImageSize($filepath, $resize_path_2, $file_extension, $resize_w_2, $resize_h_2);}
				return $filename;
			}
			if($rule == 1)
			{
				if($size[0] <= $max_w && $size[1] <= $max_h)
				{
					if($resize_path != "0"){
						dodge_ChangeImageSize($filepath, $resize_path, $file_extension, $resize_w, $resize_h);}
					if($resize_path_2 != "0"){
						dodge_ChangeImageSize($filepath, $resize_path_2, $file_extension, $resize_w_2, $resize_h_2);}
					return $filename;
				}else
				{
					echo("<p class='fail'>Файл превышает допустимый размер: ".$max_w."x".$max_h." px.</p>");
					unlink($filepath);
					return false;
				}
			}
			if($rule == 2)
			{
				if($size[0] == $size[1])
				{
					if($resize_path != "0"){
						dodge_ChangeImageSize($filepath, $resize_path, $file_extension, $resize_w, $resize_h);}
					if($resize_path_2 != "0"){
						dodge_ChangeImageSize($filepath, $resize_path_2, $file_extension, $resize_w_2, $resize_h_2);}
					return $filename;
				}else
				{
					echo("<p class='fail'>Файл не удовлетворяет правилу: ширина должна быть ровна высоте.</p>");
					unlink($filepath);
					return false;
				}
			}
			if($rule == 3)
			{
				if($size[0] == $max_w && $size[1] == $max_h)
				{
					if($resize_path != "0"){
						dodge_ChangeImageSize($filepath, $resize_path, $file_extension, $resize_w, $resize_h);}
					if($resize_path_2 != "0"){
						dodge_ChangeImageSize($filepath, $resize_path_2, $file_extension, $resize_w_2, $resize_h_2);}
					return $filename;
				}else
				{
					echo("<p class='fail'>Файл не удовлетворяет заданым параметрам: ".$max_w."x".$max_h." px.</p>");
					unlink($filepath);
					return false;
				}
			}
			if($rule == 4)
			{
				if( ($size[0]/$max_w) == ($size[1]/$max_h) )
				{
					if($resize_path != "0"){
						dodge_ChangeImageSize($filepath, $resize_path, $file_extension, $size[0], $size[1]);}
					if($resize_path_2 != "0"){
						dodge_ChangeImageSize($filepath, $resize_path_2, $file_extension, $size[0], $size[1]);}
					return $filename;
				}elseif($resize_h_2 == 1)
				{
					if( ($size[1]/$max_w) == ($size[0]/$max_h) )
					{
						if($resize_path != "0"){
							dodge_ChangeImageSize($filepath, $resize_path, $file_extension, $size[0], $size[1]);}
						if($resize_path_2 != "0"){
							dodge_ChangeImageSize($filepath, $resize_path_2, $file_extension, $size[0], $size[1]);}
						return $filename;
					}
				}else
				{
					echo("<p class='fail'>Файл не удовлетворяет пропорции: ".$max_w.":".$max_h.".</p>");
					unlink($filepath);
					return false;
				}
			}
		}else
		{
			echo("<p class='fail'>Файл не может быть сохранён по пути: ".$filepath.". Укажите другой путь или проверьте права доступа директории на запись.</p>");
			return false;
		}
	}else
	{
		echo("<p class='fail'>Файл превышает допустимый размер: ".$size." Mb.</p>");
		return false;
	}
}

// Метод MULTI-приема картинки через массив $_FILES[multiple]
function dodge_mult_files($arr)
{
	$result_arr = array();
	foreach($_FILES[$arr['files']]['name'] as $multi_cnt => $multi_cur_name)
	{
	/* 1  */ $path			= $arr['path'];				// путь к каталогу
	/* 2  */ $name			= $arr['name'];				// имя картинки: ->
								// 1 - оставить
								// 2 - сгенерировать используя текущую дату и время + то что было
								// 3 - сгенерировать используя текущую дату и время
								// 4 - использовать приставку (пункт 4)
								// 5 - приставка из п.4 + сгенерированное имя из даты и времени
							
	/* 3  */ $pre			= $arr['pre'];				// приставка имени файла
	/* 4  */ $size			= $arr['size'];				// допустимый размер файла в Mb
	/* 5  */ $rule			= $arr['rule'];				// Тип правила проверки на правильность расзмерности файла: ->
								// 0 - без проверки
								// 1 - учитывать пункт 6 и 7
								// 2 - строго квадрат
								// 3 - строго учитывать равность пункта 6 и 7
							
	/* 6  */ $max_w				= $arr['max_w'];			// максимальная ширина
	/* 7  */ $max_h				= $arr['max_h'];			// максимальная высота
	/* 8  */ $files				= $arr['files'];			// имя $_FILES
	/* 9  */ $resize_path 		= (isset($arr['resize_path']) ? $arr['resize_path'] : "0");		// путь к папке превью mid | 0
	/* 10 */ $resize_w			= (isset($arr['resize_w']) ? $arr['resize_w'] : 0);			// ширина mid фалйа | 0
	/* 11 */ $resize_h			= (isset($arr['resize_h']) ? $arr['resize_h'] : 0);			// высота mid фалйа | 0
	/* 12 */ $resize_path_2		= (isset($arr['resize_path_2']) ? $arr['resize_path_2'] : "0");	// путь к папке превью min | 0
	/* 13 */ $resize_w_2		= (isset($arr['resize_w_2']) ? $arr['resize_w_2'] : 0);		// ширина min фалйа | 0
	/* 14 */ $resize_h_2		= (isset($arr['resize_h_2']) ? $arr['resize_h_2'] : 0);		// высота mid фалйа | 0
	
	if($name < 1 || $name > 5){$name = 1;}
	if($rule < 0 || $rule > 3){$rule = 0;}

	$filepath = $path;

	//echo '<pre>files == '; print_r($_FILES[$files]); echo '</pre>';

	$filename = $_FILES[$files]['name'][$multi_cnt];

	$file_extension = $this->dodge_file_ext($filename);

	if($name == 1){$filename = $_FILES[$files]['name'][$multi_cnt];}
	if($name == 2){$filename = date('YmdHis').rand(100,1000)."_".$_FILES[$files]['name'][$multi_cnt];}
	if($name == 3){$filename = date('YmdHis').rand(100,1000).'.'.$file_extension;}
	if($name == 4){$filename = $pre.'-'.rand(1,1000).'.'.$file_extension;}
	if($name == 5){$filename = $pre.date('YmdHis').rand(100,1000).'.'.$file_extension;}

	$filepath =  $path.$filename;

	//echo '<br>MULTI PATH: '.$filepath.'<br>';

	if($resize_path != "0"){$resize_path .= $resize_w."x".$resize_h."_".$filename;}
	if($resize_path_2 != "0"){$resize_path_2 .= $resize_w_2."x".$resize_h_2."_".$filename;}

	if($_FILES[$files]['size'][$multi_cnt] != 0 && $_FILES[$files]['size'][$multi_cnt]<=1024000*$size)
	{
		if(move_uploaded_file($_FILES[$files]['tmp_name'][$multi_cnt], $filepath))
		{
			$size = getimagesize($filepath);
			if($rule == 0)
			{
				if($resize_path != "0"){
					dodge_ChangeImageSize($filepath, $resize_path, $file_extension, $resize_w, $resize_h);}
				if($resize_path_2 != "0"){
					dodge_ChangeImageSize($filepath, $resize_path_2, $file_extension, $resize_w_2, $resize_h_2);}
				array_push($result_arr,$filename);
			}
			if($rule == 1)
			{
				if($size[0] <= $max_w && $size[1] <= $max_h)
				{
					if($resize_path != "0"){
						dodge_ChangeImageSize($filepath, $resize_path, $file_extension, $resize_w, $resize_h);}
					if($resize_path_2 != "0"){
						dodge_ChangeImageSize($filepath, $resize_path_2, $file_extension, $resize_w_2, $resize_h_2);}
					array_push($result_arr,$filename);
				}else
				{
					echo("<p class='fail'>Файл превышает допустимый размер: ".$max_w."x".$max_h." px.</p>");
					unlink($filepath);
					array_push($result_arr,'fail');
				}
			}
			if($rule == 2)
			{
				if($size[0] == $size[1])
				{
					if($resize_path != "0"){
						dodge_ChangeImageSize($filepath, $resize_path, $file_extension, $resize_w, $resize_h);}
					if($resize_path_2 != "0"){
						dodge_ChangeImageSize($filepath, $resize_path_2, $file_extension, $resize_w_2, $resize_h_2);}
					array_push($result_arr,$filename);
				}else
				{
					echo("<p class='fail'>Файл не удовлетворяет правилу: ширина должна быть ровна высоте.</p>");
					unlink($filepath);
					array_push($result_arr,'fail');
				}
			}
			if($rule == 3)
			{
				if($size[0] == $max_w && $size[1] == $max_h)
				{
					if($resize_path != "0"){
						dodge_ChangeImageSize($filepath, $resize_path, $file_extension, $resize_w, $resize_h);}
					if($resize_path_2 != "0"){
						dodge_ChangeImageSize($filepath, $resize_path_2, $file_extension, $resize_w_2, $resize_h_2);}
					array_push($result_arr,$filename);
				}else
				{
					echo("<p class='fail'>Файл не удовлетворяет заданым параметрам: ".$max_w."x".$max_h." px.</p>");
					unlink($filepath);
					array_push($result_arr,'fail');
				}
			}
		}else
		{
			echo("<p class='fail'>Файл не может быть сохранён по пути: ".$filepath.". Укажите другой путь или проверьте права доступа директории на запись.</p>");
			array_push($result_arr,'fail');
		}
	}else
	{
		echo("<p class='fail'>Файл превышает допустимый размер: ".$size." Mb.</p>");
		array_push($result_arr,'fail');
	}

	} // end foreach multi name
	
	return $result_arr;
}