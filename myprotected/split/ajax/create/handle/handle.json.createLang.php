<?php 
	//********************
	//** WEB MIRACLE TECHNOLOGIES
	//********************
	
	// get post
	
	$appTable = $_POST['appTable'];
	
	$item_id = (isset($_POST['item_id']) ? $_POST['item_id'] : 0);

	if (!$_POST['lang_id'] && $_POST['lang_id'] == 0) {
		return $data['message'] = "Выберите язык из списка"; exit();
	}
	
	$cardUpd = array(
					'lang_id'		=> $_POST['lang_id'],
					
					'block'			=> $_POST['block'][0],

					);
	
	// Create main table item
	
	$query = "INSERT INTO [pre]$appTable ";
	
	$fieldsStr = " ( ";
	
	$valuesStr = " ( ";
	
	$cntUpd = 0;
	foreach($cardUpd as $field => $itemUpd)
	{
		$cntUpd++;
		
		$fieldsStr .= ($cntUpd==1 ? "`$field`" : ", `$field`");
		
		$valuesStr .= ($cntUpd==1 ? "'$itemUpd'" : ", '$itemUpd'");
	}
	
	$fieldsStr .= " ) ";
	
	$valuesStr .= " ) ";
	
	$query .= $fieldsStr." VALUES ".$valuesStr;
		
	$ah->rs($query);
	
	$item_id = mysql_insert_id();

	if ($item_id) {
		$new_lang_id = $_POST['lang_id'];
		// GET NEW LANGUAGE
		$q = "
			SELECT M.* FROM [pre]languages AS M WHERE M.id = $new_lang_id LIMIT 1
		";
		$new_lang = $ah->rs($q);

		// SET LANGUAGE USED
		$q = "
			UPDATE [pre]languages
			SET `used` = 1
			WHERE `id` = '$new_lang_id'
			LIMIT 1
		";
		$ah->rs($q);


		$pref = $new_lang[0]['alias']."_";
		///////////////////////////////////////////////// A R T I C L E S /////////////////////////////////////////////////
		// CREATE COLLUMNS
		$q = "
			ALTER TABLE `osc_articles` ADD `".$pref."content` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `content`;
		";
		$ah->rs($q);

		$q = "
			ALTER TABLE `osc_articles` ADD `".$pref."name` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `name`;
		";
		$ah->rs($q);

		// COPY COLLUMN
		$q = "
			UPDATE `osc_articles` SET
    		`".$pref."name` = `name`
		";
		$ah->rs($q);

		$q = "
			UPDATE `osc_articles` SET
    		`".$pref."content` = `content`
		";
		$ah->rs($q);



		///////////////////////////////////////////////// M E N U /////////////////////////////////////////////////
		
		// CREATE COLLUMNS

		$q = "
			ALTER TABLE `osc_menu`

				ADD `".$pref."name` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `name`,
				ADD `".$pref."details` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `details`,
				ADD `".$pref."meta_title` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `meta_title`,
				ADD `".$pref."meta_desc` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `meta_desc`,
				ADD `".$pref."meta_keys` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `meta_keys`

				;
		";
		$ah->rs($q);

		// COPY COLLUMN
		$q = "
			UPDATE `osc_menu` SET
    	
    			`".$pref."details` = `details`,
    			`".$pref."name` = `name`,
    			`".$pref."meta_title` = `meta_title`,
    			`".$pref."meta_desc` = `meta_desc`,
    			`".$pref."meta_keys` = `meta_keys`
    	
		";
		$ah->rs($q);


		///////////////////////////////////////////////// CONTACT CATEGORIES /////////////////////////////////////////////////
		// CREATE COLLUMNS
		$q = "
			ALTER TABLE `osc_contact_categories` ADD `".$pref."name` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `name`;
		";
		$ah->rs($q);

		// COPY COLLUMN

		$q = "
			UPDATE `osc_contact_categories` SET
    		`".$pref."name` = `name`
		";
		$ah->rs($q);


		///////////////////////////////////////////////// ARTICLE ALTS AND TITLES /////////////////////////////////////////////////
		// CREATE COLLUMNS
		$q = "
			ALTER TABLE `osc_article_images_alts` ADD `".$pref."data` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `data`;
		";
		$ah->rs($q);

		// COPY COLLUMN

		$q = "
			UPDATE `osc_article_images_alts` SET
    		`".$pref."data` = `data`
		";
		$ah->rs($q);


		///////////////////////////////////////////////// CONTACT CATEGORIES /////////////////////////////////////////////////
		// CREATE COLLUMNS
		$q = "
			ALTER TABLE `osc_banners` 
			ADD `".$pref."alt` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `alt`,
			ADD `".$pref."title` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `title`
			;
		";
		$ah->rs($q);

		// COPY COLLUMN

		$q = "
			UPDATE `osc_banners` SET
    		`".$pref."alt` = `alt`,
    		`".$pref."title` = `title`
		";
		$ah->rs($q);


		///////////////////////////////////////////////// PRIVACY POLICY /////////////////////////////////////////////////
		// CREATE COLLUMNS
		$q = "
			ALTER TABLE `osc_privacy` 
			ADD `".$pref."a` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `a`,
			ADD `".$pref."q` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `a`;
		";
		$ah->rs($q);

		// COPY COLLUMN

		$q = "
			UPDATE `osc_privacy` SET
    		`".$pref."q` = `q`,
    		`".$pref."a` = `a`
		";
		$ah->rs($q);


		///////////////////////////////////////////////// TOTAL CONFIG /////////////////////////////////////////////////
		// CREATE COLLUMNS
		$q = "
			ALTER TABLE `osc_total_config` 
			ADD `".$pref."meta_title` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `meta_title`,
			ADD `".$pref."meta_desc` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `meta_desc`,
			ADD `".$pref."meta_keys` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `meta_keys`,
			ADD `".$pref."copyright` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `copyright`,
			ADD `".$pref."alt` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `alt`,
			ADD `".$pref."title` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `title`;
		";
		$ah->rs($q);

		// COPY COLLUMN

		$q = "
			UPDATE `osc_total_config` SET
    		`".$pref."meta_title` = `meta_title`,
    		`".$pref."meta_desc` = `meta_desc`,
    		`".$pref."meta_keys` = `meta_keys`,
    		`".$pref."copyright` = `copyright`,
    		`".$pref."alt` = `alt`,
    		`".$pref."title` = `title`
		";
		$ah->rs($q);


		///////////////////////////////////////////////// STATIC TRANSLATIONS /////////////////////////////////////////////////
		// CREATE COLLUMNS
		$q = "
			ALTER TABLE `osc_static_translations` 
			ADD `".$pref."text` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `text`
			;
		";
		$ah->rs($q);

		// COPY COLLUMN

		$q = "
			UPDATE `osc_static_translations` SET
    		`".$pref."text` = `text`
		";
		$ah->rs($q);



	}
	
	if($item_id)
	{
		$data['item_id'] = $item_id;
	}else
	{
		$data['item_id'] = 0;
	}
	
	$data['message'] = "Новый язык успешно создан.";
	