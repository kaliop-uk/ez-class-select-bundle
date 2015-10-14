# Kaliop eZ Class Select Bundle

This bundle adds a Field Type to allow for the selection of classes

There are no front end templates made as of yet as it has only been used for back end purposes to allow the editor to select classes for filtering items.

## Installation

1) Update composer.json with
```
"kaliop/classselectbundle": "~1.0"
```

2) Add the class to EzPublishKernel.php
```
new \Kaliop\ClassSelectBundle\KaliopClassSelectBundle(),
```

3) Run composer update
```
composer update kaliop/classselectbundle --prefer-dist
```

4) Add "Class Selector" attribute to your ContentType.

