SolutionCodeMirrorBundle
========================

Integration  [CodeMirror](http://codemirror.net/) editor in you symfony2 project.

###Install

Just add the following line to your projects composer.json require section, and update vendors:
~~~~
"solution/code-mirror-bundle": "dev-master"
~~~~

Enable bundle , add to AppKernel.php:
~~~~
 new Solution\CodeMirrorBundle\SolutionCodeMirrorBundle()
~~~~

Install assets:
~~~~
$ ./app/console assets:install web --symlink
~~~~

###Configuration
Add default parameters to app/config.yml
~~~~
solution_code_mirror:
    parameters:
      mode: text/html
      lineNumbers: true
      lineWrapping: true
~~~~

###Usage
~~~~
 $builder->add('content', 'code_mirror', array(
    'required' => true,
    'parameters' => array(
         'lineNumbers' => 'true'
     )
 ));
~~~~

