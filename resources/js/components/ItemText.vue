<template>
  <div class="item-text">
    <div v-html="displayedContent" class="item-text-content"></div>

    <div :class="{ 'item-fade': !showAll }"  v-if="truncateable"></div>
    <div class="item-credits" v-if="credits" v-html="credits"></div>
    <div v-if="truncateable" class="item-text-read-more-link">
      <button type="button" class="btn btn-link" @click="showAll = !showAll">
        {{ showAll ? "Zatvoriť ↑" : "Celý text ↓" }}
      </button>
    </div>
  </div>
</template>

<script>
const READ_MORE_DELIMITER = "<hr />";

export default {
  name: "ItemText",
  props: {
    content: {
      type: String,
      required: true
    },
    credits: {
      type: String,
      required: false
    }
  },
  data() {
    return {
      showAll: false
    };
  },
  computed: {
    displayedContent() {
      if (this.showAll) return this.content.replace(READ_MORE_DELIMITER, "");

      const delimiterIndex = this.content.indexOf(READ_MORE_DELIMITER);
      if (delimiterIndex > -1) return this.content.substring(0, delimiterIndex);

      return this.content;
    },
    truncateable() {
      return this.content.indexOf(READ_MORE_DELIMITER) > -1;
    }
  }
};
</script>
