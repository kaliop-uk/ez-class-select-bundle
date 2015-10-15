<?php
/**
 *
 * Author: Daniel Clements
 * Date: 14/10/15
 * Time: 1:56 PM
 */

namespace Kaliop\ClassSelectBundle\eZ\Publish\FieldType\ClassSelect;

use eZ\Publish\Core\FieldType\Value as BaseValue;

class Value extends BaseValue
{
    /**
     * The selected classes
     *
     * @var array
     */
    public $classes;

    /**
     * Value constructor.
     *
     * Can pass in the json encoded string of selected classes. Or the correctly formed
     * params array.
     *
     * E.G. array( 'classes' => array( 'identifier_1', 'identifier_2' ) )
     *
     * @param array $params
     */
    public function __construct($params = array())
    {
        if (!is_array($params))
        {
            $params = array( 'classes' => json_decode($params) );
        }

        parent::__construct( $params );
    }

    /**
     * Returns a string representation of the field value.
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode( array( 'classes' => $this->classes ) );
    }
}