<?php  
	//********************
	//** WEB INSPECTOR
	//********************
	
	require_once "../../../require.base.php";
	
	require_once "../../library/AjaxHelp.php";
	
	$ah = new ajaxHelp($dbh);
	
	$id = $_POST['id'];
	
	$catalog = $ah->getCatalogParents();
	
	$select_html = $ah->print_select(
									"Выбрать категорию", 
									0, 
									$catalog,
									'id', 
									'name', 
									'acc_cat_id', 
									"reload_cat_complect_products_modal($(this).val(),$id);", 
									array( 'name'=>'-- Категория не выбрана --', 'id'=>0 ),
									'allCatalog',
									'float:none; width:90%; margin:0 auto; margin-bottom:25px;',
									'width:100%;'
									);
 ?>
<!DOCTYPE>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Product Complect SCRIPT</title>
</head>

<body>
	<button class="close-modal" onClick="close_modal();">Закрыть окно</button>
    <div class="modalW" id="modalW-1">
    	<h4>Выберите категорию, затем товары из списка</h4>
        
        <?php
        //echo "<pre>"; print_r($catalog); echo "</pre>";
		echo $select_html;
		?>
        
        <div id="reloadAddingProductsComplect"></div>
    </div>
</body>
</html>