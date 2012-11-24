<?php
spl_autoload_register(
   function($class) {
      static $classes = null;
      if ($classes === null) {
         $classes = array(
            'octoshepherd\\activity\\eventssubcontext' => '/Context/Activity/EventsSubContext.php',
                'octoshepherd\\activity\\eventtypessubcontext' => '/Context/Activity/EventTypesSubContext.php',
                'octoshepherd\\activity\\notificationssubcontext' => '/Context/Activity/NotificationsSubContext.php',
                'octoshepherd\\activity\\starringsubcontext' => '/Context/Activity/StarringSubContext.php',
                'octoshepherd\\activity\\watchingsubcontext' => '/Context/Activity/WatchingSubContext.php',
                'octoshepherd\\activitycontext' => '/Context/ActivityContext.php',
                'octoshepherd\\api' => '/Api.php',
                'octoshepherd\\apicontext' => '/ApiContext.php',
                'octoshepherd\\apisubcontext' => '/ApiSubContext.php',
                'octoshepherd\\gistscontext' => '/Context/GistsContext.php',
                'octoshepherd\\gitcontext' => '/Context/GitContext.php',
                'octoshepherd\\issuescontext' => '/Context/IssuesContext.php',
                'octoshepherd\\markdowncontext' => '/Context/MarkdownContext.php',
                'octoshepherd\\octoobject' => '/OctoObject.php',
                'octoshepherd\\orgscontext' => '/Context/OrgsContext.php',
                'octoshepherd\\pullcontext' => '/Context/PullContext.php',
                'octoshepherd\\repositoriescontext' => '/Context/RepositoriesContext.php',
                'octoshepherd\\requester' => '/Requester.php',
                'octoshepherd\\response' => '/Response.php',
                'octoshepherd\\searchcontext' => '/Context/SearchContext.php',
                'octoshepherd\\userscontext' => '/Context/UsersContext.php',
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