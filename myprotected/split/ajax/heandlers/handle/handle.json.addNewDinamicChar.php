<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = "shop_chars_prod_ref";
	
	$prodId	= (int)$_POST['prodId'];
	$charId = (int)$_POST['charId'];
	
	$data['status']="failed";
	$data['message']="<tr><td colspan='5'>Operation failed</td></tr>";
	
	if($prodId && $charId)
	{
		$query = "INSERT INTO [pre]$appTable (`char_id`,`prod_id`) VALUES ('$charId','$prodId')";
		$ah->rs($query);
		
		$refID = mysql_insert_id();
		
		if($refID)
		{
			$query = "SELECT * FROM [pre]shop_chars WHERE `id`=$charId LIMIT 1";
			$charArr = $ah->rs($query);
			
			if($charArr)
			{
				$char = $charArr[0];
				
				$charName = $char['name'];
				$charMeasure = $char['measure'];
				$charTitle = $char['title'];
			
				$data['status']="success";
				$data['message']="
						<tr id=\"dinamicChar-$refID\">
                	    	<td>$charName, $charMeasure</td>
                	        <td>
                	        	<input id='char-$refID' class='my-field' type='text' placeholder='$charTitle' value='' name='charD[$refID]' size='25' maxlength='100'>
							</td>
							<td> Новая цена (грн): </td>
                	        <td>
                	        	<input id='char2-$refID' class='my-field' type='hidden' placeholder='$charTitle' value='' name='charD2[$refID]' size='25' maxlength='100'>

								<input id='char3-$refID' class='my-field' type='text' placeholder='$charTitle' value='0' name='charD3[$refID]' size='15' maxlength='10'>
							</td>
							<td>
								<button class=\"close-option r-z-h-s-close\" type=\"button\" title=\"Удалить\" onclick=\"delete_dinamic_char($refID);\"></button>
							</td>
						</tr>
				";
			}else{
				$data['message']="<tr><td colspan='5'>Failed Char ID</td></tr>";
				}
		}else{
			$data['message']="<tr><td colspan='5'>Failed INSERT</td></tr>";
			}
	}
	