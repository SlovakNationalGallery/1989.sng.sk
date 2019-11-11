<template>
  <div class="item-text">
    <div v-html="displayedContent" class="item-text-content"></div>

    <div v-if="truncateable" class="item-text-read-more-link">
      <button type="button" class="btn btn-link" @click="showAll = !showAll">{{ showAll ? 'Zatvoriť ↑' : 'Celý text ↓'}}</button>
    </div>
  </div>
</template>

<script>
const MAX_LENGTH = 500
const READ_MORE_DELIMITER = '<hr />'

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
      if (this.showAll) return this.content.replace(READ_MORE_DELIMITER, '')

      const delimiterIndex = this.content.indexOf(READ_MORE_DELIMITER)
      if (delimiterIndex > -1) return this.content.substring(0, delimiterIndex)

      return _.truncate(this.content, { length: MAX_LENGTH, separator: ' '})
    },
    truncateable() {
      return this.content.length > MAX_LENGTH
    }
  }
};
</script>
