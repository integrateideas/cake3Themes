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
$menuItems = $sideNav;
foreach($menuItems as $key => $value) {
  $childrenExist = isset($value['children']) && count($value['children']) > 0 ? true : false ;  

  if(!$value['show']) {
    continue;
  }

?>

<li <?= $value['active'] ? 'class="active"' : 'class=""'?>   >
    <a href="<?= $this->Url->build($value['link']);?>"><i class="<?php echo $value['class']?>"></i> <span class="nav-label"><?= $key?> </span><?= $childrenExist ? '<span class="fa arrow"></span>' : '' ?></a>
    <?php 
       //if child exists
       if($childrenExist){
          echo '<ul class="nav nav-second-level collapse">';
          foreach ($value['children'] as $childKey => $childValue) {
            if(!$childValue['show']) {
              continue;
            }          
          $grandChildrenExist = isset($childValue['children']) && count($childValue['children']) > 0 ? true : false ;  
    ?>

        <li>
          <a href="<?= $this->Url->build($childValue['link']);?>"><?= $childKey;?><?= $grandChildrenExist ? '<span class="fa arrow"></span>' : '' ?></a>
              <?php 
                //if grandchild exists
               if($grandChildrenExist){
                    echo '<ul class="nav nav-third-level">';
                  foreach ($childValue['children'] as $grandChildKey => $grandChildValue) {
                    if(!$grandChildValue['show']) {
                        continue;
                      }
              ?>
              
                <li>
                    <a href="<?= $this->Url->build($grandChildValue['link']);?>"><?= $grandChildKey ?></a>
                </li>
            
            <?php }
              echo "</ul>";
            }?>
        </li>
    <?php }
        echo "</ul>";
     }
    ?>
</li>

<?php }?>
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
