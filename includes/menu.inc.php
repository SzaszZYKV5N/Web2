<?php

Class Menu {
    public static $menu = array();
    
    public static function setMenu() {
        self::$menu = array();
        $connection = Database::getConnection();
        $stmt = $connection->query("select url, nev, szulo, jogosultsag from menu where jogosultsag like '".$_SESSION['userlevel']."'order by sorrend");
        while($menuitem = $stmt->fetch(PDO::FETCH_ASSOC)) {
            self::$menu[$menuitem['url']] = array($menuitem['nev'], $menuitem['szulo'], $menuitem['jogosultsag']);
        }
    }

    public static function getMenu($sItems) {
        $submenu = "";
        
        $menu = '<ul >';
        foreach(self::$menu as $menuindex => $menuitem)       
        {
            if($menuitem[1] == "")
            { $menu.= "<li ><a href='".SITE_ROOT.$menuindex."' ".($menuindex==$sItems[0]? "class='selected'":"").">".$menuitem[0]."</a></li>"; }
            else if($menuitem[1] == $sItems[0])
            { $submenu .= "<li ><a href='".SITE_ROOT.$sItems[0]."_".$menuindex."' ".($menuindex==$sItems[1]? "class='selected'":"").">".$menuitem[0]."</a></li>"; }
        }
        $menu.="</ul>";
        
        if($submenu != "")
            $submenu = "<ul >".$submenu."</ul>";
        
        return $menu.$submenu;;
    }
    public static function getMenu2($sItems) {
        $submenu = "";
        
        $menu = '<ul class="navbar-nav ml-auto">';
        foreach(self::$menu as $menuindex => $menuitem)       
        {
            if($menuitem[1] == "")
            { $menu.= "<li class='nav-item'><a class='nav-link' href='".SITE_ROOT.$menuindex."' ".($menuindex==$sItems[0]? "class='nav-item active'":"").">".$menuitem[0]."</a></li>"; }
            else if($menuitem[1] == $sItems[0])
            { $submenu .= "<li class='nav-item'><a class='nav-link' href='".SITE_ROOT.$sItems[0]."_".$menuindex."' ".($menuindex==$sItems[1]? "class='nav-item active'":"").">".$menuitem[0]."</a></li>"; }
        }
        $menu.="</ul>";
        
        //if($submenu != "")
         //   $submenu = "<ul class='navbar-nav ml-auto'>".$submenu."</ul>";
        
        return $menu.$submenu;;
    }
}

Menu::setMenu();
?>
