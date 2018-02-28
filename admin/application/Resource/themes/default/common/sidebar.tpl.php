<?php

function print_menu($menus, $activePath) {
    static $depth = 0;
    foreach ($menus as $menu):
?>
    <li class="nav-item <?php if (isset($activePath) && $activePath == $menu->url):?>active<?php endif ?>">
        <a href="<?=$menu->url ? url($menu->url) : 'javascript:'?>" class="nav-link nav-toggle">
            <i class="<?=$menu->icon?>"></i>
            <span class="title"><?=$menu->title?></span>
            <span class="selected"></span>
            <span class="arrow"></span>
            <?php if ($depth > 0 && $menu->children):?>
            <i class="fa fa-angle-right" style="float: right"></i>
            <?php endif ?>
        </a>
        <?php
        if ($menu->children):
            $depth++;
            echo '<ul class="sub-menu">';
            print_menu($menu->children, $activePath);
            echo '</ul>';
        endif;
        ?>
    </li>
<?php
    endforeach;
    $depth--;
}
?>
<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
    <!-- END SIDEBAR -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-hover-submenu " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <?php print_menu($menus, $activePath) ?>
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
<!-- END SIDEBAR -->