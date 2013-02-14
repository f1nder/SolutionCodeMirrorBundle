SolutionCodeMirrorBundle
========================

Bundle not yet ready.

Integration  [CodeMirror](http://codemirror.net/) editor in you symfony2 project.

###Install

Just add the following line to your projects composer.json require section, and update vendors:
``` js
"solution/code-mirror-bundle": "dev-master"
```

Enable bundle , add to `AppKernel.php`:
``` php
 new Solution\CodeMirrorBundle\SolutionCodeMirrorBundle()
```
###Configuration
Add default parameters to `config.yml` and
``` yaml
twig:
    form:
        resources:
            - 'TPRedactorBundle:Form:redactor_widget.html.twig'

solution_code_mirror:
    parameters:
      mode: text/html
      lineNumbers: true
      lineWrapping: true
```


Install assets:
``` bash
$ ./app/console assets:install web --symlink
```

###Usage
``` php
 $builder->add('content', 'code_mirror', array(
    'required' => true,
    'parameters' => array(
         'lineNumbers' => 'true'
     )
 ));
```

