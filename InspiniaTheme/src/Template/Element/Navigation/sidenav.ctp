<nav class="navbar-default navbar-static-side" role="navigation">
  <div class="sidebar-collapse">
    <ul class="nav metismenu" id="side-menu">
      <li class="nav-header">
        <div class="dropdown profile-element">
          <a data-toggle="dropdown" class="dropdown-toggle" href="javascript:void(0)">
            <span class="clear"> 
              <span class="block m-t-xs"> 
                <strong class="font-bold">
                  <h2><?= $sideNavData['first_name']." ".$sideNavData['last_name']?></h2>
                </strong>
              </span> 
              <span class="text-muted text-xs block"><?= $sideNavData['role_name']; ?> <b class="caret"></b></span> </span> </a>
              <ul class="dropdown-menu animated fadeInRight m-t-xs">
                <li><?= $this->Html->link(__('Profile'), ['controller' => 'Users', 'action' => 'edit', $sideNavData['id'] ]) ?></li>
                <li class="divider"></li>
                <li><?= $this->Html->link(__('Logout'), ['controller' => 'Users', 'action' => 'logout']) ?></li>
              </ul>
            </div>
            <div class="logo-element">
              <?= $this->Html->image('icon-reverse-low-rez.png', ['style' => 'width:30px; height:30px;', 'alt'=>'image'])?>
            </div>
          </li>
<?php
// pr($sideNav); die; 
  $controllers = $sideNav;

  foreach($controllers as $key => $value) {
    $underscore = \Cake\Utility\Inflector::underscore($key);
    $humanize = \Cake\Utility\Inflector::humanize($underscore);
    $controllerName = $key;
    $actionCount = count($value['actions']);
    if(!isset($value['class'])) {
      $value['class'] = '';
    }
?>

<li class="">
<a href="#"><i class=<?= '"fa '.$value['class'].'"' ?>></i> <span class="nav-label"><?= $humanize ?></span>
  <?= $actionCount ? '<span class="fa arrow"></span>' : '' ?>
</a>    
  <?php if($actionCount) { ?> 
    <ul class="nav nav-second-level">
      <?php foreach ($value['actions'] as $key => $value) {?>
      <li><?= $this->Html->link(__($key), ['controller'=>$controllerName,'action' => $value]) ?></li>
      <?php } ?>
    </ul>
   <?php } ?>
</li>
<?php } ?>
</ul>
</div>
</nav>


<?php 
$this->end();

$this->Html->scriptStart(['block' => 'scriptBottom']);
echo "$(function () {
  $('#side-menu').metisMenu();
});";
$this->Html->scriptEnd();

?>