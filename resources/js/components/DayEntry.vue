<template>
  <div>
    <h2>{{ date | romanize }}</h2>
    <div class="day-content">
      <div class="block-paper">
        <div class="ruled" :is="contentCompiled"></div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "DayEntry",
  props: ["date", "content"],
  computed: {
    contentCompiled() {
      const regex = /<a\s+href="tag:\/\/(.+?)">(.*?)<\/a>/gs;
      const contentWithRouterLinks = `${this.content}`.replace(
        regex,
        `<router-link :to="{ name: 'journal-entries', params: { date: '${
          this.date
        }' }, query: { filter: '$1' }}">$2</router-link>`
      );

      const template = Vue.compile(`<div>${contentWithRouterLinks}</div>`);
      return { ...template, data: () => ({}) };
    }
  }
};
</script>

<style lang="scss">
.day-content {
  p {
    display: inline !important;
  }
  br {
    display: none;
  }
}
</style>
