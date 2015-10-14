{default
attribute_base='ContentObjectAttribute'
html_class='full'}
{def
    $groups = fetch( 'classselect', 'grouped_classes' )
    $content = $attribute.content
}
<select
        id="ezcoa-{if ne( $attribute_base, 'ContentObjectAttribute' )}{$attribute_base}-{/if}{$attribute.contentclassattribute_id}_{$attribute.contentclass_attribute_identifier}"
        name="{$attribute_base}_data_classes_{$attribute.id}[]"
        size="{$groups.total}"
        multiple
>
    {foreach $groups.groups as $group}
        <optgroup label="{$group.name}">
            {foreach $group.classes as $class}
                <option
                    value="{$class.identifier}"
                    {if $content|contains($class.identifier)} selected{/if}
                >{$class.name}</option>
            {/foreach}
        </optgroup>
    {/foreach}
</select>
{/default}