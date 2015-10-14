<?php
/**
 *
 * Author: Daniel Clements
 * Date: 14/10/15
 * Time: 10:36 PM
 */

$FunctionList = array();

$FunctionList['grouped_classes'] = array(
    'name' => 'grouped_classes',
    'call_method' => array(
        'class' => 'ClassSelectFunctionCollection', // Function collection class
        'method' => 'getGroupedClasses'
    ),
    'parameters' => array()
);