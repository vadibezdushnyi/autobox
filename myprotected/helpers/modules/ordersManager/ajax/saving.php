<?php 
class Helper {
	protected $db;
	function __construct($db) {
		$this->db=$db;
	}
        
    public function checkAdminLogin(){
        $wp_login = false;
        if(isset($_COOKIE['user_id']) && $_COOKIE['user_id'] != null && trim($_COOKIE['user_id']) !== "" && $_COOKIE['user_id']){
            $query = "SELECT M.*, 
            			T.type as userGroupName, 
            			T.block as userGroupBlock, 
            			T.admin_enter as userGroupAdminEnter  
                        FROM [pre]users as M
                        LEFT JOIN [pre]users_types as T on T.id = M.type
                        WHERE M.id='".$_COOKIE['user_id']."' 
                        LIMIT 1
                        ";
            $userData = $this->db->q($query,1);
            if(
            	$userData['block']==0 && 
            	$userData['userGroupBlock']==0 && 
            	$userData['active']==1 && 
            	$userData['userGroupAdminEnter']==1
            ){
            	$wp_login = true;
            }
        }
        return $wp_login;
    }

	public function getAdminMenuSql($parent=0) {
		$menu = $this->db->q("SELECT * FROM [pre]admin_menu WHERE `block`=0 AND `parent`=$parent ORDER BY `order_id`");
		$result = [];
		foreach($menu as &$item) {
			$item['childs'] = $this->getAdminMenuSql($item['id']);
		}
		return $menu;
	}
}