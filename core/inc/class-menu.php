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
        $this->loop_array($this->menus[$menu]['menu']);
      ?>
    <ul>

  <?php
  }
  public function loop_array($menu) {
    foreach ($menu as $key => $val) {
      if(!is_array($val)){
          echo '<li><a href="'.$val.'">'.$key.'</a></li>';
      }else{
        echo '<li class="has-sub"><a href="'.$val['url'].'">'.$key.'</a><ul class="sub-menu">';
        $this->loop_array($val['sub-menu']);
        echo '</ul></li>';
      }
    }
  }
}
$menu = new Menu();
