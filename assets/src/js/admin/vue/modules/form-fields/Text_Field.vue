<template>
    <component 
        :is="getTheTheme( 'text-field' )" 
        v-bind="$props"
        v-if="canShow"
        :canChange="canChange"
        @enter="$emit( 'enter', $event )"
        @blur="$emit( 'blur', $event )"
        @update="$emit( 'update', $event )"
        @do-action="$emit( 'do-action', $event )"
        @validate="$emit( 'validate', $event )"
    />
</template>

<script>
import feild_helper from './../../mixins/form-fields/helper';
import props from './../../mixins/form-fields/input-field-props';

export default {
    name: 'text-field',
    mixins: [ props, feild_helper ]
}
</script>
