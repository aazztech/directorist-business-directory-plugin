<template>
    <div class="cptm-form-group cptm-preview-wrapper">
        <div class="cptm-preview-radio-area">
            <label v-if="( label.length )">
                <component :is="labelType">{{ label }}</component>
            </label>
            
            <p class="cptm-info-text" v-if="description.length" v-html="description"></p>
    
            <div class="cptm-radio-area">
                <div class="cptm-radio-item" v-for="( option, option_index ) in theOptions" :key="option_index">
                    <input type="radio" class="cptm-radio" 
                        :id="getOptionID( option, option_index, sectionId )"
                        :name="name"
                        :value="( typeof option.value !== 'undefined' ) ? option.value : ''"
                        v-model="local_value"
                    >
                    <label :for="getOptionID( option, option_index, sectionId )">
                        {{ option.label }}
                    </label>
                </div>
            </div>
    
            <p class="cptm-info-text" v-if="! theOptions.length">{{ infoTextForNoOption }}</p>
    
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

        <div 
            v-if="preview"
            class="cptm-preview-area-archive" 
        >
            <img 
                v-for="previewKey in Object.keys( preview )" 
                v-if="local_value === previewKey" 
                :src='preview[previewKey]'
            />
        </div>
    </div>
</template>

<script>
import radio_feild from './../../../../mixins/form-fields/radio-field';

export default {
    name: 'radio-field-theme-default',
    mixins: [ radio_feild ],
}
</script>