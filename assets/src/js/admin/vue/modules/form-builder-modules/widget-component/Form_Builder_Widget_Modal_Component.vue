<template>
  <div
      v-if="modalOpened"
      class="cptm-modal-overlay"
      @click.prevent="$emit('close-modal')"
  >
      <div class="cptm-modal-content" @click.stop>
        <div class="cptm-modal-container">
          <iframe
              v-if="content.type === 'video'"
              width="560"
              height="315"
              :src="content.url"
              frameborder="0"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
              allowfullscreen
              :title="content.title"
          ></iframe>
          <div 
            v-if="content.type === 'learn_more'"
            class="cptm-modal-single-listing-header"
          >
            <!-- Render Placeholder Groups -->
            <div
              v-for="(placeholderItem, index) in placeholders"
              :key="index"
              v-if="placeholderItem.type === 'placeholder_group'"
              class="cptm-modal-single-listing-header__group cptm-modal-single-listing-header__group--top"
            >
              <div 
                v-for="(subPlaceholderItem, index) in placeholderItem.placeholders"
                class="cptm-modal-single-listing-header__item"
                :class="subPlaceholderItem.placeholder_key"
              >
                <div
                  v-for="(selectedWidget, index) in subPlaceholderItem.selectedWidgets"
                  :key="`item_${index}`"
                  class="cptm-modal-single-listing-header__btn"
                  :class="selectedWidget.widget_key"
                >
                  <span 
                    v-if="selectedWidget.icon" 
                    :class="selectedWidget.icon"
                  ></span>
                  {{selectedWidget.label}}
                </div>
              </div>
            </div>

            <!-- Render Standalone Placeholder Items -->
            <div
              v-for="(placeholderItem, index) in placeholders"
              :key="`standalone_${index}`"
              v-if="placeholderItem.type === 'placeholder_item'"
              class="cptm-modal-single-listing-header__item"
              :class="placeholderItem.placeholder_key"
            >
              <div
                v-for="(selectedWidget, index) in placeholderItem.selectedWidgets"
                :key="`group_${index}`"
                class="cptm-modal-single-listing-header__btn"
                :class="selectedWidget.widget_key"
              >
                <span 
                  v-if="selectedWidget.icon" 
                  class="cptm-modal-single-listing-header__btn__icon"
                  :class="selectedWidget.icon"
                ></span>
                {{selectedWidget.label}}
              </div>
            </div>
            <button 
              class="cptm-modal-single-listing-header__close-btn" 
              @click.prevent="$emit('close-modal')"
            >
              <span class="la la-close"></span>
            </button>
          </div>
        </div>
      </div>
      <button 
        class="close-btn" 
        v-if="content.type !== 'learn_more'"
        @click.prevent="$emit('close-modal')"
      >
        <span class="la la-close"></span>
      </button>
  </div>
</template>

<script>
export default {
  name: "form-builder-widget-modal-component",
  props: {
    modalOpened: {
      type: Boolean,
      default: false
    },
    content: {
      type: [Object, Array],
      default: () => [] // Default is an empty array
    }
  },
  computed: {
    placeholders() {
      console.log('@chk placeholders', this.content);
      return this.content || [];
    }
  },
  mounted() {
    console.log('@chk modalcontent', this.content);
  }
};
</script>
