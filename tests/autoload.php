<?php
require dirname(__DIR__) . '/src/autoload.php';

spl_autoload_register(
   function($class) {
      static $classes = null;
      if ($classes === null) {
         $classes = array(
            'octoshepherd\\generalshepherdtest' => '/unit/GeneralShepherdTest.php',
                'octoshepherd\\mockresponsefactory' => '/response_stubs/MockResponseFactory.php',
                'octoshepherd\\octoobjecttest' => '/unit/OctoObjectTest.php',
                'octoshepherd\\userstest' => '/unit/UsersTest.php'
          );
      }
      $cn = strtolower($class);
      if (isset($classes[$cn])) {
         require __DIR__ . $classes[$cn];
      }
   }
);