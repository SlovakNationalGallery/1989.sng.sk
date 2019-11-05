<template>
  <div class="day-entry">
    <div class="ruled" :is="contentCompiled"></div>
  </div>
</template>

<script>
export default {
  name: "DayEntry",
  props: ["date", "dayData"],
  computed: {
    contentCompiled() {
      const regex = /<a\s+href="tag:\/\/(.+?)">(.*?)<\/a>/gs;
      let content = this.dayData.content || "";
      const breakingP = `${content}`.match(/^[\S\s]{100,2000}<\/p>/g);
      if (
        breakingP &&
        breakingP[0] &&
        breakingP[0].length < content.length &&
        breakingP[0].length > 800 &&
        content.length - breakingP[0].length > 800
      ) {
        content =
          content.substr(0, breakingP[0].length) +
          " <span @click='showMore()' class='read-more' v-if='!show'>Prečítaj si celý deň</span><transition name='slide-in'><div v-if='show'>" +
          content.substr(breakingP[0].length) +
          "</div></transition>";
      }

      const contentWithRouterLinks = content.replace(
        regex,
        `<router-link :to="{ name: 'journal-entries', params: { date: '${
          this.date
        }' }, query: { filter: '$1' }}">$2</router-link>`
      );

      const template = Vue.compile(`<div >${contentWithRouterLinks}</div>`);
      return {
        ...template,
        data: () => ({ show: false }),
        methods: {
          showMore() {
            this.show = 1;
          }
        }
      };
    }
  }
};
</script>