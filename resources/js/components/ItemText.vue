<template>
  <div class="item-text block-paper">
    <div v-html="displayedContent" class="item-text-content"></div>

    <div v-if="truncateable" class="item-text read-more-link">
      <button type="button" class="btn btn-link" @click="showAll = !showAll">{{ showAll ? 'Zatvoriť ↑' : 'Celý text ↓'}}</button>
    </div>
  </div>
</template>

<script>
const MAX_LENGTH = 500

export default {
  name: "ItemText",
  props: {
    content: {
      type: String,
      required: true,
    },
  },
  data() {
    return {
      showAll: !this.content.length > MAX_LENGTH
    };
  },
  computed: {
    displayedContent() {
      if (this.showAll) return this.content
      return _.truncate(this.content, { length: MAX_LENGTH, separator: ' '})
    },
    truncateable() {
      return this.content.length > MAX_LENGTH
    }
  }
};
</script>
