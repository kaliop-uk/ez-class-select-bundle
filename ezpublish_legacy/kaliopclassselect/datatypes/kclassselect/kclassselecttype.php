<?php
/**
 *
 * Author: Daniel Clements
 * Date: 14/10/15
 * Time: 4:37 PM
 */

class KClassSelectType extends eZDataType
{
    const DATA_TYPE_STRING = "kclassselect";

    const CLASSATTRIBUTE_DEFAULT = 'data_text';

    public $classes;

    function __construct( $value )
    {
        parent::__construct( self::DATATYPE_STRING, 'KClassSelectType' );
    }

    /**
     * Initializes the object attribute with some data.
     * @param eZContentObjectAttribute $objectAttribute
     * @param int $currentVersion
     * @param eZContentObjectAttribute $originalContentObjectAttribute
     */
    function initializeObjectAttribute($objectAttribute, $currentVersion, $originalContentObjectAttribute)
    {
        if ( NULL === $currentVersion )
        {
            $data = '';
        }
        else
        {
            $data = $originalContentObjectAttribute->attribute( "data_text" );
        }

        $objectAttribute->setAttribute( "data_text", $data );
    }

    function objectAttributeContent($objectAttribute)
    {
        return json_decode( $objectAttribute->attribute( 'data_text' ) );
    }


    function validateObjectAttributeHTTPInput( $http, $base, $contentObjectAttribute )
    {
        $classAttribute = $contentObjectAttribute->contentClassAttribute();
        if ( $http->hasPostVariable( $base . '_data_classes_' . $contentObjectAttribute->attribute( 'id' ).'[]' ) )
        {
            $data = $http->postVariable( $base . '_data_classes_' . $contentObjectAttribute->attribute( 'id' ).'[]' );

            if ( empty($data) )
            {
                if ( !$classAttribute->attribute( 'is_information_collector' ) and
                    $contentObjectAttribute->validateIsRequired() )
                {
                    $contentObjectAttribute->setValidationError( ezpI18n::tr( 'kernel/classes/datatypes',
                        'Input required.' ) );
                    return eZInputValidator::STATE_INVALID;
                }
            }
        }
        else if ( !$classAttribute->attribute( 'is_information_collector' ) and $contentObjectAttribute->validateIsRequired() )
        {
            $contentObjectAttribute->setValidationError( ezpI18n::tr( 'kernel/classes/datatypes', 'Input required.' ) );
            return eZInputValidator::STATE_INVALID;
        }

        return eZInputValidator::STATE_ACCEPTED;
    }

    /**
     * @param $http
     * @param $base
     * @param $contentObjectAttribute
     * @return bool
     */
    function fetchObjectAttributeHTTPInput( $http, $base, $contentObjectAttribute )
    {
        if ( $http->hasPostVariable( $base . "_data_classes_" . $contentObjectAttribute->attribute( "id" ).'[]' ) )
        {
            $data = $http->postVariable( $base . "_data_classes_" . $contentObjectAttribute->attribute( "id" ).'[]' );
            $contentObjectAttribute->setAttribute( "data_text", json_encode( $data ) );
            return true;
        }

        return false;
    }

    public function hasObjectAttributeContent( $contentObjectAttribute )
    {
        return $contentObjectAttribute
            ->content()
            ->hasContent();
    }

    /**
     * Returns a key to sort attributes.
     *
     * @param mixed $contentObjectAttribute Class eZContentObjectAttribute.
     *
     * @return string
     */
    public function sortKey( $contentObjectAttribute )
    {
        return json_encode(
            $contentObjectAttribute->content()->classes
        );
    }
    /**
     * Returns the type of the sortKey.
     *
     * I better use string in favor of integer as I do not know if the integer
     * type used by eZP is big enough.
     *
     * @return string
     */
    public function sortKeyType()
    {
        return 'string';
    }
    /**
     * Returns a MetaData string for the search functionality.
     *
     * @param mixed $contentObjectAttribute Class eZContentObjectAttribute.
     *
     * @return string
     */
    public function metaData( $contentObjectAttribute )
    {
        return $this->getName();
    }
    /**
     * IsIndexable.
     *
     * @return boolean
     */
    public function isIndexable()
    {
        return true;
    }
    /**
     * Returns a string that could be used for the object title.
     *
     * @param mixed $contentObjectAttribute ContentObjectAttribute.
     * @param mixed $name                   No idea...
     *
     * @return string
     */
    public function title( $contentObjectAttribute, $name = null )
    {
        return implode( '-', $contentObjectAttribute->content()->classes );
    }

    function __toString()
    {
        $string = '';
        if ( is_array($this->classes) and !empty($this->classes) )
        {
            $string = json_encode( $this->classes );
        }

        return $string;
    }

    protected function getName()
    {
        return implode( '-', $this->classes );
    }
}

eZDataType::register( KClassSelectType::DATA_TYPE_STRING, "KClassSelectType" );