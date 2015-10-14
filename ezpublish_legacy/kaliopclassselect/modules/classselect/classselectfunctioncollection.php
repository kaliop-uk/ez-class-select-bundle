<?php
/**
 *
 * Author: Daniel Clements
 * Date: 14/10/15
 * Time: 10:37 PM
 */

class ClassSelectFunctionCollection
{
    public static function getGroupedClasses()
    {
        $groups = eZContentClassGroup::fetchList( false, true );
        $return = array();
        $count = 0;
        foreach ( $groups as $group )
        {
            $array = array(
                'name' => $group->attribute('name'),
                'classes' => array()
            );

            $count++;

            $classes = eZContentClassClassGroup::fetchClassList( 0, $group->attribute('id'), true );

            foreach ( $classes as $class )
            {
                $array['classes'][] = array(
                    'identifier' => $class->attribute('identifier'),
                    'name' => $class->attribute('name')
                );
                $count++;
            }

            $return[] = $array;
        }

        return array( 'result' => array( 'groups' => $return, 'total' => $count ) );
    }
}