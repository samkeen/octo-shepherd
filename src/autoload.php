<?php
spl_autoload_register(
   function($class) {
      static $classes = null;
      if ($classes === null) {
         $classes = array(
            'octoshepherd\\octoobject' => '/OctoObject.php',
                'octoshepherd\\shepherd' => '/Shepherd.php',
                'presta\\curler' => '/vendor/presta/src/Curler.php',
                'presta\\prestatestbase' => '/vendor/presta/tests/PrestaTestBase.php',
                'presta\\request' => '/vendor/presta/src/Request.php',
                'presta\\response' => '/vendor/presta/src/Response.php',
                'presta\\util\\arr' => '/vendor/presta/src/util/Arr.php'
          );
      }
      $cn = strtolower($class);
      if (isset($classes[$cn])) {
         require __DIR__ . $classes[$cn];
      }
   }
);