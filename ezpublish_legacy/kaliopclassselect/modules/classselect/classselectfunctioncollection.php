<?php
/**
 *
 * Author: Daniel Clements
 * Date: 14/10/15
 * Time: 10:37 PM
 */

use Symfony\Component\DependencyInjection\ContainerInterface;

class ClassSelectFunctionCollection
{
    public static function getGroupedClasses()
    {
        /** @var ContainerInterface $container */
        $container = ezpKernel::instance()->getServiceContainer();
        $params = $container->getParameter('kaliop_class_select');

        $classInclude = $classExclude = $groupInclude = $groupExclude = false;
        $cgparams = array();
        if ( !empty($params['classes']['include']) )
        {
            $classInclude = true;
            $cgparams = $params['classes']['include'];
        }
        elseif ( !empty($params['classes']['exclude']) )
        {
            $classExclude = true;
            $cgparams = $params['classes']['exclude'];
        }
        elseif ( !empty($params['class_groups']['include']) )
        {
            $groupInclude = true;
            $cgparams = $params['class_groups']['include'];
        }
        elseif ( !empty($params['class_groups']['exclude']) )
        {
            $groupExclude = true;
            $cgparams = $params['class_groups']['exclude'];
        }

        $groups = eZContentClassGroup::fetchList( false, true );
        $return = array();
        $count = 0;
        foreach ( $groups as $group )
        {
            if (
                ( $groupInclude and
                    (in_array( $group->attribute('id'), $cgparams) or in_array( $group->attribute('name'), $cgparams))
                ) or
                ( !$groupInclude and $groupExclude and
                    (!in_array( $group->attribute('id'), $cgparams) or !in_array( $group->attribute('name'), $cgparams))
                ) or
                ( !$groupInclude and !$groupExclude )
            ) {
                $array = array(
                    'name'    => $group->attribute('name'),
                    'classes' => array()
                );

                $count++;

                $classes = eZContentClassClassGroup::fetchClassList(0, $group->attribute('id'), true);

                foreach ($classes as $class)
                {
                    if (
                        ( $classInclude and
                            (in_array( $class->attribute('id'), $cgparams) or in_array( $class->attribute('identifier'), $cgparams))
                        ) or
                        ( !$classInclude and $classExclude and
                            (!in_array( $class->attribute('id'), $cgparams) or !in_array( $class->attribute('identifier'), $cgparams))
                        ) or
                        ( !$classInclude and !$classExclude )
                    )
                    {
                        $array['classes'][] = array(
                            'identifier' => $class->attribute('identifier'),
                            'name'       => $class->attribute('name')
                        );
                        $count++;
                    }
                }

                $return[] = $array;
            }
        }

        return array( 'result' => array( 'groups' => $return, 'total' => $count ) );
    }
}