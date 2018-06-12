<?php 
	// Start header content

	$headParams = array( 'parent'=>$parent, 'alias'=>$alias, 'id'=>$id, 'item_id'=>$item_id, 'appTable'=>$appTable, 'type'=>'messages' );
	
	$data['headContent'] = $zh->getCardViewHeader($headParams);
	
	// Start body content
	
	$cardItem = $zh->getDialogItem($item_id);
	
	// Get users info
	
	$friendId = ($cardItem['from_id']==ADMIN_ID ? $cardItem['to_id'] : $cardItem['from_id']);
	
	$myInfo		= $zh->getUserInfo(ADMIN_ID);
	
	$friendInfo	= $zh->getUserInfo($friendId);
	
	$dialog 	= $zh->getDialog(ADMIN_ID,$friendId);
	
	
	$rootPath = "../../../../..";
	
	$cardViewTableStr = "";
	
	$cardViewTableStr .= "<form name='dialog-form' id='dialog-form' action='split/ajax/heandlers/handle/handle.json.sendDialogMessage.php' method='POST' enctype='multipart/form-data'>
							<input type='hidden' name='to_id' value='$friendId'>
							<div class='zen-form-item'>
								<div class='zif-wrap-date'>
                					<textarea id='save-message' class='my-field' placeholder='Сообщение' name='message'></textarea>
                        				<br><br>
                        				<button class='my-field-submit' type='submit' title='Отправить сообщение'>Отправить</button>
                					</div>
            				</div>
							<div class='zen-form-item'>
								<label for='save-editor-input-file'>Вложение</label><br>
								<div class='zif-wrap'>
									<input type='file' name='file' class='hidden' id='editor-file-input' onchange=\"split_txt($(this).val());\">
                					<input id='save-editor-input-file' class='my-field' type='text' placeholder='../' name='editor-input-file' size='25' maxlength='255' onchange=\"\" disabled='disabled'>
                        			<button class='my-field' type='button' title='Выбрать файл' onclick=\"check_file();\">Выбрать</button>
                        			<button class='my-close' type='button' title='Сбросить выбор' onclick=\"uncheck_file();\">&nbsp;</button>
                				</div>
            				</div>
						</form>";
	
	$cardViewTableStr .= "<div class='dialogContainer' id='dialogContainer-1'>";
	
	$icnt = 0;
	
	$ava_folder = "/split/files/users/crop/150x150_";
	
	foreach($dialog as $mess)
	{
		$icnt++;
		$curr_class = ($icnt%2 > 0 ? "zebra" : "");
		$curr_ava = ($mess['from_id']==ADMIN_ID ? $myInfo['avatar'] : $friendInfo['avatar']);
		$curr_name = ($mess['from_id']==ADMIN_ID ? $myInfo['name']." ".$myInfo['fname'] : $friendInfo['name']." ".$friendInfo['fname']);
		$curr_mess = $mess['message'];
		$curr_date = $zh->deformat_long_date($mess['dateCreate']);
		$curr_file = $mess['file'];
		$curr_crop = $mess['crop'];
		
		if(!file_exists($rootPath."/split/files/users/crop/150x150_".$curr_ava))
		{
			$curr_ava = "split/img/no_image.png?i=".time();
		}else
		{
			$curr_ava = $ava_folder.$curr_ava;
		}
		
		$cardViewTableStr .= "
			<div class='dialog-item $curr_class'>
            	<div class='avatar'><img alt='AVATAR' src='$curr_ava'></div>
                <div class='dialog-content'>
                	<div class='dialog-name'>$curr_name</div>
                    <div class='dialog-block'>
                    	<div class='dialog-message'>$curr_mess</div>";
					if($curr_file)
					{
						$file_ext = $zh->pseudoext($curr_file);
				
						$path_to_file = "/split/files/dialogs/crop/".$curr_crop;
				
						$target = "";
				
						if($file_ext=='pdf') 
						{
							$path_to_file = "split/img/pdf-icon.png";
							$target = " target='_blank' ";
						}
						if($file_ext=='doc' || $file_ext=='docx')
						{ 
							$path_to_file = "split/img/word-icon.png";
							$target = " target='_blank' ";
						}
						if($file_ext=='xls' || $file_ext=='xlsx' || $file_ext=='xltx')
						{
							$path_to_file = "split/img/excel-icon.png";
							$target = " target='_blank' ";
						}
						if($file_ext=='txt')
						{
							$path_to_file = "split/img/txt-icon.png";
							$target = " target='_blank' ";
						}
						
						$cardViewTableStr .= "
						<div class='dialog-files'>
                        	<div class='file'><a $target class='theater' rel='group' href='/split/files/dialogs/$curr_file' title='Вложенный файл'>
								<img alt='PHOTO' src='$path_to_file'></a>
							</div>
							<div class='clear'></div>
						</div>
						";
					}
					$cardViewTableStr .= "
					</div>
                </div>
                <div class='dialog-date'>$curr_date</div>
            </div>
		";
	}
	
	$cardViewTableStr .= "</div>";
	
	// Join content
	
	$data['bodyContent'] .= "
		<div class='ipad-20' id='order_conteinter'>
			<h3>Диалог с ".$friendInfo['name']." ".$friendInfo['fname']."</h3>";
	
	$data['bodyContent'] .= $cardViewTableStr;
				
	$data['bodyContent'] .=	"
		</div>
	";

?>