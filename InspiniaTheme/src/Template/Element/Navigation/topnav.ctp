<nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" href="#"><i class="fa fa-bars"></i> </a>
            <form role="search" class="navbar-form-custom" action="">
                <div class="form-group">
                    
                </div>
            </form>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li>
             <?= $this->Html->link(__('Logout'), ['controller' => 'Users', 'action' => 'logout'], ['class' => ['fa', 'fa-sign-out']]) ?>
            </li>
        </ul>
</nav>