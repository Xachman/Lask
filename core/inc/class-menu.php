<?php
class Menu {
  public $menus = array();

  public function make_menu() {
    $args = func_get_args();
    $menu_name = $args[0];
  //  var_dump($this->menus[0]);
    foreach ($this->menus as $key => $value) {
      if($this->menus[$key]['name'] == $menu_name){
        $menu = $key;
      }
    }
    ?>
    <ul id="<?php echo $menu_name ?>">
      <?php
        foreach ($this->menus[$menu]['menu'] as $key => $val) {
          if(!is_array($val)){
              echo '<li><a href="'.$val.'">'.$key.'</a></li>';
          }else{
            echo '<li><a href="'.$val['url'].'">'.$key.'</a><ul class="submenu">';
            foreach($val['sub-menu'] as $key => $val){
              echo '<li><a href="'.$val.'">'.$key.'</a>';
            }
            echo '</ul></li>';
          }
        }
      ?>
    <ul>

  <?php
  }
}
$menu = new Menu();
