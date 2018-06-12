<?php 
	//********************
	//** WEB INSPECTOR
	//********************
	
	require_once "../../../require.base.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>RELOAD ITEM EXTRA FIELDS - LOAD IN HTML</title>
</head>

<?php
	$extra_id = (int)$_POST['id'];
	$num = (int)$_POST['num'];
	
	$group = trim($_POST['group']);
	
	$item = unserialize(base64_decode($_POST['item_data']));
	$extra_fields = unserialize($_POST['extra_fields']);
	
	$id = $item['id'];
	
	$item[$group] = $extra_id;
?>

<body>
<?php 
		//echo '<pre>POST: '; print_r($_POST); echo '</pre>';
		
		//echo '<pre>item: '; print_r($item); echo '</pre>';
		
		//echo '<pre>EXTRA_FIELDS: '; print_r($extra_fields); echo '</pre>';
		
		//die();
		
		foreach($extra_fields as $ef_iter => $ef)
		{
			if($ef_iter != $num)
			{
				continue;
			}
			
			$refs = array(); // Буферный массив для хранения результатов SQL запросов
			
			switch($ef['type'])
			{
				case 'group':
				{
					$ef_refs	= $ef['refs'];
					$ef_group	= $ef['groups'];
						
						$ref_obj = $ef_refs[$ef_group['parent']];
						
						$query = "SELECT ";
						
						//echo '<hr> - '.$ref_obj['type'].' - <hr>';
						
						switch($ref_obj['type'])
						{
							case 'simple':
							{	
								$query_fields = "";
								$qf_cnt = 0;
								
								foreach($ref_obj['fields'] as $ro_field)
								{
									$qf_cnt++;
									if($qf_cnt == 1)
									{
										$query_fields .= $ro_field;
									}else
									{
										$query_fields .= ", ".$ro_field;
									}
								}
								
								$query .= $query_fields." FROM [pre]".$ref_obj['table'];
								
								$query_where = " WHERE 1 ";
								
								foreach($ref_obj['where'] as $ro_where)
								{
									if($ro_where['parent'] == 'item')
									{
										$query_where .= " AND `".$ro_where['ref_field']."` = '".$item[$ro_where['parent_field']]."' ";
									}else
									{
										$query_where .= " AND `".$ro_where['ref_field']."` = '".$refs[$ro_where['parent']][$ef_iter][$ro_where['parent_field']]."' ";
									}
								}
								
								$query .= $query_where." ORDER BY ".$ref_obj['order']." LIMIT ".$ref_obj['limit'];
								
									$_stmt	= $dbh->prepare($query);
									$_arr	= $_stmt->execute();
								
								$_res = $_arr->fetchallAssoc();
								
								$refs[$ef_group['parent']] = $_res;
								
								// Выполняем actions для текущей итерации
								
								break; // case SIMPLE
							}
							case 'join':
							{
								$query_fields = "";
								$qf_cnt = 0;
								
								foreach($ref_obj['fields'] as $ro_field)
								{
									$qf_cnt++;
									if($qf_cnt == 1)
									{
										$query_fields .= $ro_field;
									}else
									{
										$query_fields .= ", ".$ro_field;
									}
								}
								
								$query .= $query_fields." FROM [pre]".$ref_obj['table']." AS ".$ref_obj['as'];
								
								$query_join = "";
								$join_cnt = 0;
								
								foreach($ref_obj['join'] as $join)
								{
									$join_cnt++;
									$query_join .= " LEFT JOIN [pre]".$join['table']." AS ".$join['as']." ON ".$join['on']."  ";
								}
								
								$query .= $query_join;
								
								$query_where = " WHERE 1 ";
								
								foreach($ref_obj['where'] as $ro_where)
								{
									if($ro_where['parent'] == 'item')
									{
										$query_where .= " AND `".$ro_where['ref_field']."` = '".$item[$ro_where['parent_field']]."' ";
									}else
									{
										$query_where .= " AND `".$ro_where['ref_field']."` = '".$refs[$ro_where['parent']][$ef_iter][$ro_where['parent_field']]."' ";
									}
								}
								
								$query .= $query_where." ORDER BY ".$ref_obj['order']." LIMIT ".$ref_obj['limit'];
								
								echo $query;
								
									$_stmt	= $dbh->prepare($query);
									$_arr	= $_stmt->execute();
								
								$_res = $_arr->fetchallAssoc();
								
								$refs[$ef_group['parent']] = $_res;
								
								break; // case JOIN
							}
							default: break;
						}
						
							foreach($_res as $iter_cnt => $iter_data) // FOREACH IN GROUP
							{
								
								foreach($ef_group['actions'] as $action)
								{
									$iter_obj = $ef_refs[$action];
						
									$query = "SELECT ";
									
									//echo '<hr> --> '.$iter_obj['type'].' - <hr>';
						
									switch($iter_obj['type'])
									{
										case 'simple':
										{	
											$query_fields = "";
											$qf_cnt = 0;
								
											foreach($iter_obj['fields'] as $ro_field)
											{
												$qf_cnt++;
												if($qf_cnt == 1)
												{
													$query_fields .= $ro_field;
												}else
												{
													$query_fields .= ", ".$ro_field;
												}
											}
								
											$query .= $query_fields." FROM [pre]".$iter_obj['table'];
								
											$query_where = " WHERE 1 ";
								
											foreach($iter_obj['where'] as $ro_where)
											{
												if($ro_where['parent'] == 'item')
												{
													$query_where .= " AND ".$ro_where['ref_field']." = '".$item[$ro_where['parent_field']]."' ";
												}else
												{	
													$query_where .= " AND ".$ro_where['ref_field']." = '".$refs[$ro_where['parent']][$iter_cnt][$ro_where['parent_field']]."' ";
												}
											}
								
											$query .= $query_where." ORDER BY ".$iter_obj['order']." LIMIT ".$iter_obj['limit']; 
								
												$_stmt	= $dbh->prepare($query);
												$_arr	= $_stmt->execute();
								
											$_res = $_arr->fetchallAssoc();
								
											$refs[$action] = $_res;
								
											break; // case SIMPLE
										}
										case 'join':
										{
											$query_fields = "";
											$qf_cnt = 0;
								
											foreach($iter_obj['fields'] as $ro_field)
											{
												$qf_cnt++;
												if($qf_cnt == 1)
												{
													$query_fields .= $ro_field;
												}else
												{
													$query_fields .= ", ".$ro_field;
												}
											}
								
											$query .= $query_fields." FROM [pre]".$iter_obj['table']." AS ".$iter_obj['as'];
								
											$query_join = "";
											$join_cnt = 0;
								
											foreach($iter_obj['join'] as $join)
											{
												$join_cnt++;
												$query_join .= " LEFT JOIN [pre]".$join['table']." AS ".$join['as']." ON ".$join['on']."  ";
											}
								
											$query .= $query_join;
								
											$query_where = " WHERE 1 ";
								
											foreach($iter_obj['where'] as $ro_where)
											{
												if($ro_where['parent'] == 'item')
												{
													$query_where .= " AND ".$ro_where['ref_field']." = '".$item[$ro_where['parent_field']]."' ";
												}else
												{
													$query_where .= " AND ".$ro_where['ref_field']." = '".$refs[$ro_where['parent']][$iter_cnt][$ro_where['parent_field']]."' ";
												}
											}
								
											$query .= $query_where." ORDER BY ".$iter_obj['order']." LIMIT ".$iter_obj['limit'];
											
											//echo '<div class="clear"></div><br>'.$query.'<br><div class="clear"></div>';
											
											$_stmt	= $dbh->prepare($query);
											$_arr	= $_stmt->execute();
								
											$_res = $_arr->fetchallAssoc();
								
											$refs[$action] = $_res;
											
											break; // case JOIN
										}
										default: break;
									}
									
								}
								
								// echo '<pre>REFS: '; print_r($refs); echo '</pre>'; die();
								
								?>
								<div class="clear"></div>
                        		<h4><?php echo $refs[$ef_group['title_parent']][0][$ef_group['title_value']] ?></h4>
								<?php
								
									foreach($refs[$ef_group['field']['field_parent']] as $ref_item)
									{
										$field_val = $ef_group['field']['field_value'];
										
										$query = "SELECT ".$field_val['field']." FROM [pre]".$field_val['table']." WHERE 1";
										
										foreach($field_val['where'] as $fvw)
										{
											if($fvw['parent'] == 'item')
											{
												$query .= " AND `".$fvw['field']."` = '".$item[$fvw['parent_field']]."' ";
											}else
											{
												$query .= " AND `".$fvw['field']."` = '".$ref_item[$fvw['parent_field']]."' ";
											}
										}
										
										$query .= " LIMIT 1"; 
										
										//echo $query.'<div class="clear"></div>';
										
										$_stmt = $dbh->prepare($query);
										$_arr = $_stmt->execute();
										
										$_res = $_arr->fetchallAssoc();
										
										//$value = $ref_item[$ef_group['field']['field_value']];
										if($_res[0][$field_val['field']] != null)
										{
											$value = $_res[0][$field_val['field']];
										}else
										{
											$value = "";
										}
										
										if($ref_item[$ef_group['field']['type']] == "DATETIME")
											{
										?>
											<div class="zen-form-item">
												<label  for="<?php echo $ef_group['field']['id'] ?>-<?php echo $ref_item[$ef_group['field']['field_num']] ?>" 
                                                		title="<?php echo $ref_item[$ef_group['field']['field_title']] ?>"><?php echo $ref_item[$ef_group['field']['field_name']] ?></label><br>
												<div class="zif-wrap-date">
                								<input	id="<?php echo $ref_item[$ef_group['field']['id']] ?>-<?php echo $ref_item[$ef_group['field']['field_num']] ?>" 
                                						class="my-field"
                                						type="date" 

                                        				placeholder="Выберите дату" 
                                        				value="<?php echo date("Y-m-d",strtotime($value)) ?>" 
                                        				name="<?php echo $ef_group['field']['name'] ?>[<?php echo $ref_item[$ef_group['field']['field_num']] ?>]"
                                				/>
                								</div>
            								</div>
										<?php	
										}else
										{
										?>
											<div class="zen-form-item">
												<label  for="<?php echo $ef_group['field']['id'] ?>-<?php echo $ref_item[$ef_group['field']['field_num']] ?>" 
                                                	  	title="<?php echo $ref_item[$ef_group['field']['field_title']] ?>"><?php echo $ref_item[$ef_group['field']['field_name']] ?></label><br>
												<div class="zif-wrap">
                								<input	id="<?php echo $ref_item[$ef_group['field']['id']] ?>-<?php echo $ref_item[$ef_group['field']['field_num']] ?>" 
                                						class="my-field"
                                						type="text" 
                                        				placeholder="<?php echo $ref_item[$ef_group['field']['default']] ?>" 
                                        				value="<?php echo $value ?>" 
                                        				name="<?php echo $ef_group['field']['name'] ?>[<?php echo $ref_item[$ef_group['field']['field_num']] ?>]" 
                                        				size="<?php echo $ref_item[$ef_group['field']['size']] ?>"
                                     			  		maxlength="<?php echo $ref_item[$ef_group['field']['maxlength']] ?>"
                                				/>
                								</div>
            								</div>
										<?php
										}
									}
								
							} // END FOREACH IN GROUP
					
					break; // case GROUP
				}
				case 'list':
				{
					break; // case LIST
				}
				default: break;
			}
		}
?>
</body>
</html>