<?php
spl_autoload_register(
   function($class) {
      static $classes = null;
      if ($classes === null) {
         $classes = array(
            'phpgithubapi\\auth\\simpleauth' => '/Auth/SimpleAuth.php',
                'presta_curler' => '/vendor/presta/lib/presta/Curler.php',
                'presta_request' => '/vendor/presta/lib/presta/Request.php',
                'presta_requirements' => '/vendor/presta/lib/presta/Requirements.php',
                'presta_response' => '/vendor/presta/lib/presta/Response.php',
                'prestatestbase' => '/vendor/presta/testing/PrestaTestBase.php',
                'util_arr' => '/vendor/presta/lib/util/Arr.php'
          );
      }
      $cn = strtolower($class);
      if (isset($classes[$cn])) {
         require __DIR__ . $classes[$cn];
      }
   }
);