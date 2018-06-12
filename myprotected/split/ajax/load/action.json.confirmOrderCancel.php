<?php // ajax json action
	
	$data = array();
	
	$orderId = $_POST['orderId'];
	
	$result  = "
				<button class='close-modal' onclick='close_modal();'>Закрыть окно</button>
    			<div class='modalW' id='modalW-1'>
					<div class='confirmWrapper'>
						<h2 align='center'>Вы уверенны что хотите отменить заказ №".($orderId+5000)." ?</h2>
						<table>
							<tr>
								<td><a href='javascript:void();' class='cancel' onclick=\"close_modal();\">Нет</a></td>
								<td><a href='javascript:void();' class='confirm' onclick=\"close_modal(); change_order_status($orderId,5);\">Да</a></td>
							</tr>
						</table>
					</div>
				</div>
				";
	
	$data['message'] = $result;
	
	$data['status'] = "success";
	
	
echo json_encode($data);
