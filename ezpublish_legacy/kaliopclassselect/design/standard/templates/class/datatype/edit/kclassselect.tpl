{default
    attribute_base='ContentObjectAttribute'
    html_class='full'
}
    <select
        id="ezcoa-{if ne( $attribute_base, 'ContentObjectAttribute' )}{$attribute_base}-{/if}{$attribute.contentclassattribute_id}_{$attribute.contentclass_attribute_identifier}"
        name="{$attribute_base}_data_clsses_{$attribute.id}[]"
        multiple
    >
        <option value="">None</option>
        <option value="Test">Test</option>
    </select>

{/default}