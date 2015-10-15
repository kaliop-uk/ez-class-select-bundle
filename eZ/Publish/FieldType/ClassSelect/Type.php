<?php
/**
 *
 * Author: Daniel Clements
 * Date: 14/10/15
 * Time: 1:56 PM
 */

namespace Kaliop\ClassSelectBundle\eZ\Publish\FieldType\ClassSelect;

use eZ\Publish\Core\FieldType\FieldType;
use eZ\Publish\Core\FieldType\Value as CoreValue;
use eZ\Publish\SPI\FieldType\Value as SPIValue;
use eZ\Publish\SPI\Persistence\Content\FieldValue as PersistenceValue;
use eZ\Publish\Core\Base\Exceptions;

class Type extends FieldType
{
    public function getFieldTypeIdentifier()
    {
        return 'kclassselect';
    }

    public function getName(SPIValue $value)
    {
        return implode( '-', $value->classes );
    }

    protected function getSortInfo(CoreValue $value)
    {
        return $this->getName( $value );
    }

    public function fromHash($hash)
    {
        if ( $hash === null )
        {
            return $this->getEmptyValue();
        }

        return new Value( $hash );
    }

    protected function createValueFromInput($inputValue)
    {
        if ( !is_array($inputValue) )
        {
            $inputValue = array( 'classes' => json_decode($inputValue) );
        }

        $value = new Value( $inputValue );

        return $value;
    }

    protected function checkValueStructure(CoreValue $value)
    {
        if ( !is_array( $value->classes ) )
        {
            throw new Exceptions\InvalidArgumentType(
                'classes',
                'An array of class identifiers was expected.'
            );
        }
    }

    public function getEmptyValue()
    {
        return new Value();
    }

    public function toHash(SPIValue $value)
    {
        return json_encode( $value );
    }

    public function toPersistenceValue(SPIValue $value)
    {
        if ( $value === null )
        {
            return new PersistenceValue(
                array(
                    "data" => null,
                    "externalData" => null,
                    "sortKey" => null,
                )
            );
        }
        if ( $value->contents === null )
        {
            $value->contents = $this;
        }
        return new PersistenceValue(
            array(
                "data" => $this->toHash( $value ),
                "sortKey" => $this->getSortInfo( $value ),
            )
        );
    }

    /**
     * Converts a persistence $fieldValue to a Value
     *
     * @param \eZ\Publish\SPI\Persistence\Content\FieldValue $fieldValue
     *
     * @return \eZ\Publish\Core\FieldType\Value
     */
    public function fromPersistenceValue(PersistenceValue $fieldValue)
    {
        if ( $fieldValue->data === null )
        {
            return $this->getEmptyValue();
        }

        return new Value( array('classes' => $fieldValue->data) );
    }
}