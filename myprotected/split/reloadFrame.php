	<div class="underhead">  
    	 <div class="r-z-header" id="r-z-header">
        	
            <div class="admin_header_line">Меню событий на WEB PLATFORM <b><i>ICAKE</i></b></div>
            
         </div>
    </div><!-- underhead -->
        
    <div id="r-z-content">
    	<div id="sub-r-z-content">
        <div class="dashboard">
        	
            <?php 
			$table_schema 	= $db->q('SHOW TABLES');
			$all_users 		= $db->q('SELECT COUNT(id) as count FROM [pre]users',1);
			$admin_users 	= $db->q('SELECT COUNT(id) as count FROM [pre]users WHERE `type`=1',1);
			$mysqlVersion	= $db->q("SHOW VARIABLES LIKE 'version'",1);
			?>
			
            <br>
            <center>Добро пожаловать в панель администратора <b><i>ICAKE</i></b>.</center>
            
            <h2 class="dataCaption">Данные ресурса</h2>
            
            <table class="maintable">
            	<thead>
                	<tr>
                    	<th>Параметр</th>
                		<th>Значение</th>
                    </tr>
                </thead>
                <tbody>
                	<tr class="trcolor">
                    	<td class="param">Доменное имя</td>
                        <td class="value"><?= $_SERVER['HTTP_HOST'] ?></td>
                    </tr>
                    <tr class="">
                    	<td class="param">PHP версия</td>
                        <td class="value"><?= phpversion() ?></td>
                    </tr>
                    <tr class="trcolor">
                    	<td class="param">MySQL версия</td>
                        <td class="value"><?= $mysqlVersion['Value'] ?></td>
                    </tr>
                    <tr class="">
                    	<td class="param">Таблиц в базе</td>
                        <td class="value"><?= count($table_schema) ?></td>
                    </tr>
                    <tr class="trcolor">
                    	<td class="param">Количество пользователей</td>
                        <td class="value"><?= $all_users['count'] ?></td>
                    </tr>
                    <tr class="">
                    	<td class="param">Количество суперадминов</td>
                        <td class="value"><?= $admin_users['count'] ?></td>
                    </tr>
                </tbody>
            </table>
            
         </div>
         </div><!-- sub-r-z-content -->
	</div><!-- r-z-content -->