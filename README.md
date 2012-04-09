# PHP projects inital scaffold


```
$ ant
Buildfile: /Users/sam/Projects/banner/build.xml

requirements:
     [echo] Found required executable: /usr/local/Cellar/php/5.3.6/bin/phpab
     [echo] Found required executable: /usr/local/Cellar/php/5.3.6/bin/phploc
     [echo] Found required executable: /usr/local/Cellar/php/5.3.6/bin/pdepend
     [echo] Found required executable: /usr/local/bin/phpmd
     [echo] Found required executable: /usr/local/bin/phpcs
     [echo] Found required executable: /usr/local/bin/phpcpd
     [echo] Found required executable: /usr/local/bin/phpunit
     [echo] Found required executable: /usr/local/bin/phpdoc
     [echo] Found required executable: /usr/local/Cellar/php/5.3.6/bin/phpcb

clean:
   [delete] Deleting directory /Users/sam/Projects/banner/build/api
   [delete] Deleting directory /Users/sam/Projects/banner/build/code-browser
   [delete] Deleting directory /Users/sam/Projects/banner/build/coverage
   [delete] Deleting directory /Users/sam/Projects/banner/build/logs
   [delete] Deleting directory /Users/sam/Projects/banner/build/pdepend

phpab:
     [exec] Autoload file '/Users/sam/Projects/banner/src/autoload.php' generated.
     [exec] 
     [exec] Autoload file '/Users/sam/Projects/banner/tests/autoload.php' generated.
     [exec] 

prepare:
    [mkdir] Created dir: /Users/sam/Projects/banner/build/api
    [mkdir] Created dir: /Users/sam/Projects/banner/build/code-browser
    [mkdir] Created dir: /Users/sam/Projects/banner/build/coverage
    [mkdir] Created dir: /Users/sam/Projects/banner/build/logs
    [mkdir] Created dir: /Users/sam/Projects/banner/build/pdepend

lint:
    [apply] No syntax errors detected in /Users/sam/Projects/banner/src/ClassOne.php
    [apply] No syntax errors detected in /Users/sam/Projects/banner/src/autoload.php
    [apply] No syntax errors detected in /Users/sam/Projects/banner/tests/autoload.php
    [apply] No syntax errors detected in /Users/sam/Projects/banner/tests/unit/ClassOneTest.php

phploc:
     [exec] phploc 1.6.4 by Sebastian Bergmann.
     [exec] 
     [exec] Lines of Code (LOC):                                 29
     [exec]   Cyclomatic Complexity / Lines of Code:           0.10
     [exec] Comment Lines of Code (CLOC):                         8
     [exec] Non-Comment Lines of Code (NCLOC):                   21
     [exec] 
     [exec] Namespaces:                                           1
     [exec] Interfaces:                                           0
     [exec] Classes:                                              1
     [exec]   Abstract:                                           0 (0.00%)
     [exec]   Concrete:                                           1 (100.00%)
     [exec]   Average Class Length (NCLOC):                       3
     [exec] Methods:                                              0
     [exec]   Scope:
     [exec]     Non-Static:                                       0 (0.00%)
     [exec]     Static:                                           0 (0.00%)
     [exec]   Visibility:
     [exec]     Public:                                           0 (0.00%)
     [exec]     Non-Public:                                       0 (0.00%)
     [exec]   Average Method Length (NCLOC):                      0
     [exec]   Cyclomatic Complexity / Number of Methods:       0.00
     [exec] 
     [exec] Anonymous Functions:                                  1
     [exec] Functions:                                            0
     [exec] 
     [exec] Constants:                                            0
     [exec]   Global constants:                                   0
     [exec]   Class constants:                                    0

pdepend:
     [exec] PHP_Depend 0.10.9 by Manuel Pichler
     [exec] 
     [exec] Parsing source files:
     [exec] ..                                                               2
     [exec] 
     [exec] Executing Coupling-Analyzer:
     [exec]                                                                  3
     [exec] 
     [exec] Executing CyclomaticComplexity-Analyzer:
     [exec]                                                                  3
     [exec] 
     [exec] Executing Dependency-Analyzer:
     [exec]                                                                  2
     [exec] 
     [exec] Executing Inheritance-Analyzer:
     [exec]                                                                  2
     [exec] 
     [exec] Executing NodeCount-Analyzer:
     [exec]                                                                  2
     [exec] 
     [exec] Executing NodeLoc-Analyzer:
     [exec]                                                                  3
     [exec] 
     [exec] Generating pdepend log files, this may take a moment.
     [exec] 
     [exec] Time: 00:00; Memory: 6.75Mb

phpmd-ci:

phpcs-ci:

phpcpd:
     [exec] phpcpd 1.3.5 by Sebastian Bergmann.
     [exec] 
     [exec] 0.00% duplicated lines out of 29 total lines of code.
     [exec] 
     [exec] Time: 0 seconds, Memory: 2.25Mb

phpunit:
     [exec] PHPUnit 3.6.10 by Sebastian Bergmann.
     [exec] 
     [exec] Configuration read from /Users/sam/Projects/init/phpunit.xml
     [exec] 
     [exec] .
     [exec] 
     [exec] Time: 0 seconds, Memory: 6.75Mb
     [exec] 
     [exec] OK (1 test, 1 assertion)
     [exec] 
     [exec] Writing code coverage data to XML file, this may take a moment.
     [exec] 
     [exec] Generating code coverage report, this may take a moment.

phpdoc:
     [exec] PHP Version 5.3.6
     [exec] phpDocumentor version 1.4.4
     [exec] 
     [exec] Parsing configuration file phpDocumentor.ini...
     [exec]    (found in /usr/local/Cellar/php/5.3.6/lib/php/data/PhpDocumentor/)...
     [exec] 
     [exec] done
     [exec] Maximum memory usage set at 256M after considering php.ini...
     [exec] using tokenizer Parser
     [exec] File /Users/sam/Projects/init/src/autoload.php Ignored
     [exec] 
     [exec] 
     [exec] Grabbing README/INSTALL/CHANGELOG
     [exec] 
     [exec] done
     [exec] 
     [exec] 
     [exec] Tutorial/Extended Documentation Parsing Stage
     [exec] 
     [exec] done
     [exec] 
     [exec] 
     [exec] General Parsing Stage
     [exec] 
     [exec] Reading file /Users/sam/Projects/banner/src/ClassOne.php -- Parsing file
     [exec] WARNING in ClassOne.php on line 11: no @package tag was used in a DocBlock for file /Users/sam/Projects/banner/src/ClassOne.php
     [exec] WARNING in ClassOne.php on line 12: no @package tag was used in a DocBlock for class ClassOne
     [exec] done
     [exec] 
     [exec] Converting From Abstract Parsed Data
     [exec] 
     [exec] Processing Class Inheritance
     [exec] 
     [exec] 
     [exec] Processing Root Trees
     [exec] 
     [exec] 
     [exec] Processing leftover classes (classes that extend root classes not found in the same package)
     [exec] done processing leftover classes
     [exec] 
     [exec] Processing Procedural Page Element Name Conflicts
     [exec] 
     [exec] 
     [exec] Sorting page elements...done
     [exec] Formatting @uses list...done
     [exec] 
     [exec] creating /Users/sam/Projects/banner/build/api/media
     [exec] Creating Directory /Users/sam/Projects/banner/build/api/media
     [exec] copying /Users/sam/Projects/banner/build/api/media/background.png
     [exec] copying /Users/sam/Projects/banner/build/api/media/empty.png
     [exec] copying /Users/sam/Projects/banner/build/api/media/style.css
     [exec] Building indexes...done
     [exec] 
     [exec] Sorting Indexes...done
     [exec] 
     [exec] Sorting @todo list...done
     [exec] Converting tutorials/extended docs
     [exec] Formatting Package Indexes...    Writing /Users/sam/Projects/banner/build/api/elementindex_default.html
     [exec] 
     [exec] done
     [exec] Formatting Index...
     [exec]     Writing /Users/sam/Projects/banner/build/api/elementindex.html
     [exec] 
     [exec]     Writing /Users/sam/Projects/banner/build/api/li_default.html
     [exec] 
     [exec]     Writing /Users/sam/Projects/banner/build/api/index.html
     [exec] done
     [exec] 
     [exec] Formatting Left Quick Index...
     [exec]     Writing /Users/sam/Projects/banner/build/api/classtrees_default.html
     [exec] 
     [exec] done
     [exec] 
     [exec] Converting /Users/sam/Projects/banner/src/ClassOne.php Procedural Page Elements... Classes...
     [exec] Creating Directory /Users/sam/Projects/banner/build/api/default
     [exec]     Writing /Users/sam/Projects/banner/build/api/default/ClassOne.html
     [exec]  done
     [exec]     Writing /Users/sam/Projects/banner/build/api/default/_ClassOne.php.html
     [exec] 
     [exec] Converting @todo List...done
     [exec] 
     [exec] Converting Error Log...    Writing /Users/sam/Projects/banner/build/api/errors.html
     [exec] 
     [exec] 
     [exec] To view errors and warnings, look at /Users/sam/Projects/banner/build/api/errors.html
     [exec] done
     [exec] 
     [exec] Parsing time: 0 seconds
     [exec] 
     [exec] Conversion time: 1 seconds
     [exec] 
     [exec] Total Documentation Time: 1 seconds
     [exec] done

phpcb:

build:

BUILD SUCCESSFUL
Total time: 12 seconds
```
