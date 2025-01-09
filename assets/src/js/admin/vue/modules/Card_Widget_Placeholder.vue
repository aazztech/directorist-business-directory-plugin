<template>
  <div
    class="cptm-placeholder-block"
    :class="getContainerClass"
    @drop.prevent="placeholderOnDrop()"
    @dragover.prevent="$emit('placeholder-dragover-on')"
    @dragenter="placeholderOnDragEnter()"
    @dragleave="placeholderOnDragLeave()"
  >
    <p class="cptm-placeholder-label" :class="{ hide: selectedWidgets && selectedWidgets.length }">
      {{ label }}
    </p>

    <div class="cptm-widget-preview-area chk" v-if="selectedWidgets && selectedWidgets.length">
      <template v-for="(widget, widget_index) in selectedWidgets">
        <template v-if="hasValidWidget(widget)">
          <component
            :is="availableWidgets[widget].type + '-card-widget'"
            :key="widget_index"
            :label="( typeof availableWidgets[widget] !== 'undefined' ) ? availableWidgets[widget].label : 'Not Available'"
            :icon="( typeof availableWidgets[widget].icon === 'string' ) ? availableWidgets[widget].icon : ''"
            :options="availableWidgets[widget].options"
            :read-only="true"
          >
          </component>
        </template>
      </template>
    </div>
  </div>
</template>

<script>
export default {
  name: "card-widget-placeholder",
  props: {
    id: {
      type: String,
      default: "",
    },
    containerClass: {
      // type: String,
      default: "",
    },
    placeholderKey: {
      default: "",
    },
    label: {
      type: String,
      default: "",
    },
    availableWidgets: {
      type: Object,
    },
    activeWidgets: {
      type: Object,
    },
    acceptedWidgets: {
      type: Array,
    },
    rejectedWidgets: {
      type: Array,
    },
    selectedWidgets: {
      type: Array,
    },
    showWidgetsPickerWindow: {
      type: Boolean,
      default: false,
    },
    widgetDropable: {
      type: Boolean,
      default: false,
    },
    maxWidget: {
      type: Number,
      default: 0,
    },
    maxWidgetInfoText: {
      type: String,
      default: "Up to __DATA__ item{s} can be added",
    },
  },
  created() {
    console.log("@WidgetPlaceholders (created):", {Selected: this.selectedWidgets, Available: this.availableWidgets, Active: this.activeWidgets});
  },

  // mounted() {
  //   console.log("Selected Widgets (mounted):", this.selectedWidgets);
  // },
  computed: {
    canAddMore() {
      if ( this.maxWidget < 1 ) {
        return true;
      }

      return this.selectedWidgets.length < this.maxWidget;
    },
    getContainerClass() {
      let classNames = {
        'drag-enter': this.placeholderDragEnter,
      };

      if ( this.placeholderKey ) {
        classNames[ this.placeholderKey ] = true;
      }

      if ( typeof this.containerClass === 'string' ) {
        classNames[ this.containerClass ] = true;
      }

      if ( 
        this.containerClass 
        && typeof this.containerClass === 'object' 
        && ! Array.isArray( this.containerClass )
      ) {
        classNames = {
          ...classNames,
          ...this.containerClass
        };
      }

      return classNames;
      
    }
  },
  data() {
    return {
      placeholderDragEnter: false,
    }
  },
  methods: {
    widgetHasOptions( active_widget ) {
      if ( ! active_widget.options && typeof active_widget.options !== 'object' ) { 
        return false;
      }
      if ( ! active_widget.options.fields && typeof active_widget.options.fields !== 'object' ) {
        return false;
      }
      return true;
    },
    placeholderOnDrop() {
      this.placeholderDragEnter = false;
      this.$emit('placeholder-on-drop')
    },
    placeholderOnDragEnter() {
      this.placeholderDragEnter = true;
      this.$emit('placeholder-on-dragenter');
    },
    placeholderOnDragLeave() {
      this.placeholderDragEnter = false;
      this.$emit('placeholder-on-dragleave');
    },
    hasValidWidget(widget_key) {
      if ( !this.availableWidgets[widget_key] && typeof this.availableWidgets[widget_key] !== "object" ) {
        return false;
      }
      if (typeof this.availableWidgets[widget_key].type !== "string") {
        return false;
      }
      return true;
    },
  },
};
</script>