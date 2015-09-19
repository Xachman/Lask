<?php
class menu {
  public $menus = array();
  
  public function make_menu($menu_name) {?>
    <ul id="<?php echo $menu_name ?>">
      <?php
        foreach ($menu_name as $menu) {
          echo '<li><a href="'.$menu[0].'">'.$menu[1].'</a></li>';
        }
      ?>
    <ul>

  <?php
  }
}
