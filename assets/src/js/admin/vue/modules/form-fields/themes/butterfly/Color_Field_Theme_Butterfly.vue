<template>
    <div class="cptm-form-group" :class="formGroupClass">
        <div class="atbdp-row">
            <div class="atbdp-col atbdp-col-4">
                <label v-if="( label.length )">
                    <component :is="labelType">{{ label }}</component>
                </label>
                
                <p class="cptm-form-group-info" v-if="description.length" v-html="description"></p>
            </div>
            
            <div class="atbdp-col atbdp-col-8">
                <div class="cptm-color-picker-wrap">
                    <div class="cptm-color-picker">
                        <v-input-colorpicker 
                            v-model="local_value" 
                            :value="local_value"
                            picker="sketch"
                        />
                    </div>

                    <div class="cptm-color-picker-label">{{ local_value }}</div>
                </div>
                

                <form-field-validatior 
                    :section-id="sectionId"
                    :field-id="fieldId"
                    :root="root"
                    :value="value" 
                    :rules="rules" 
                    v-model="validationLog" 
                    @validate="$emit( 'validate', $event )"
                />
            </div>
        </div>
    </div>
</template>

<script>
import color_feild from './../../../../mixins/form-fields/color-field';

export default {
    name: 'color-field-theme-butterfly',
    mixins: [ color_feild ],
    mounted() {
        // If have condition to check if this.canChange is a function.
        if (this.canChange) {
            this.canChange(); 
        }
    },
}
</script>