<template>
  <div
    v-if="visible"
    class="cptm-widget-trash-confirmation-modal-overlay"
    @click="handleOverlayClick"
  >
    <div class="cptm-widget-trash-confirmation-modal" @click.stop>
      <h2>Are you sure you want to proceed?</h2>
      <p>
        Removing "<strong>{{ widgetName }}</strong
        >" field will also remove it from the single and search pages.
      </p>
      <button @click="confirmDelete">Yes, delete</button>
      <button
        class="cptm-widget-trash-confirmation-modal-action-btn__cancel"
        @click="cancelDelete"
      >
        Cancel
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: "ConfirmationModal",
  props: {
    visible: {
      type: Boolean,
      default: false,
    },
    widgetName: {
      type: String,
      default: "",
    },
  },
  methods: {
    confirmDelete() {
      this.$emit("confirm");
    },
    cancelDelete() {
      this.$emit("cancel");
    },
    handleOverlayClick() {
      this.cancelDelete();
    },
  },
};
</script>
