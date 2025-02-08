<template>
  <div
      v-if="modalOpened"
      class="cptm-modal-overlay"
      @click.prevent="$emit('close-modal')"
  >
      <div class="cptm-modal-content" @click.stop>
          <div class="cptm-modal-container">
              <iframe
                  v-if="content.url"
                  width="560"
                  height="315"
                  :src="content.url"
                  frameborder="0"
                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                  allowfullscreen
                  :title="content.title"
              ></iframe>

          </div>
      </div>
      <button 
        class="close-btn" 
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
      default: false,
    },
    content: {
      type: Object,
    },
  },
  mounted() {
    console.log('@CHK Modal Mounted', {content: this.content});
  }
};
</script>
