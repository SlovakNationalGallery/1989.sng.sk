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
      let content =
        this.dayData.content_for_frontpage || this.dayData.content || "";
      const breakingP = `${content}`.match(/^[\S\s]{100,2000}<\/p>/g);
      if (
        breakingP &&
        breakingP[0] &&
        breakingP[0].length < content.length &&
        breakingP[0].length > 800 &&
        content.length - breakingP[0].length > 800
      ) {
        // TODO update when final texts are available
        content =
          content.substr(0, breakingP[0].length) +
          " <span @click='showMore()' class='read-more' v-if='!show'>Prečítaj si celý deň</span><transition name='slide-in'><div v-if='show'>" +
          content.substr(breakingP[0].length) +
          "</div></transition>";
      }

      // TODO update with router links
      const contentWithReadMe = content
        .replace(regex, `<i>$2</i>`)
        .replace(/(\W\w{1,2})\s/g, `$1&nbsp;`);

      const template = Vue.compile(`<div>${contentWithReadMe}</div>`);
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