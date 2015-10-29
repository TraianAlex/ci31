<?php
// Quick and dirty navigation.
$menu_item_default = 'index';
$menu_items = [
  '../' => [
    'label' => 'Home',
    'desc' => '',
  ],
  'index' => [
    'label' => 'Magazines',
    'desc' => 'A list of all my magazines',
  ],
  'add' => [
    'label' => 'Add',
    'desc' => 'Add a magazine to my collection',
  ],
];
// Determine the current menu item.
$menu_current = $menu_item_default;
// If there is a query for a specific menu item and that menu item exists...
if (@array_key_exists($this->uri->segment(2), $menu_items)) {
  $menu_current = $this->uri->segment(2);
}
?>
<?=doctype('html5');?>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <?=meta("X-UA-Compatible", "IE=edge,chrome=1", "equiv")?>
        <title>My Magazines | <?=html_escape($menu_items[$menu_current]['label']); ?></title>
        <?=meta("description", html_escape($menu_items[$menu_current]['desc']))?>
        <?=meta("viewport", "width=device-width")?>

        <?=link_tag('assets/css/bootstrap2.min.css')?>
        <style>
            body {
                padding-top: 60px;
                padding-bottom: 40px;
            }
        </style>
        <?=link_tag('assets/css/bootstrap-responsive.min.css')?>
        <?=link_tag('assets/css/main.css')?>

        <script src="<?=base_url()?>assets/js/vendor/modernizr-2.8.3.min.js"></script>
    </head>
    <body>
        <!-- This code is taken from http://twitter.github.com/bootstrap/examples/hero.html -->

        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="brand" href="<?=base_url()?>magazine">Magazine Collection</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                          <?php
                            foreach ($menu_items as $item => $item_data) {
                              echo '<li' . ($item == $menu_current ? ' class="active"' : '') . '>';
                              echo '<a href="'.base_url().'magazine/' . $item . '" title="' . $item_data['desc'] . '">' . $item_data['label'] . '</a>';
                              echo '</li>';
                            }
                          ?>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>

        <div class="container">