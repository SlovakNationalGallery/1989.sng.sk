<template>
  <div class="day-entry">
    <div class="ruled" v-html="content"></div>
  </div>
</template>

<script>
export default {
  name: "DayEntry",
  props: ["date", "content"],
  computed: {
    contentCompiled() {
      let content = this.content
      const breakingP = `${content}`.match(/^[\S\s]{100,2000}<\/p>/g);
      if (
        breakingP &&
        breakingP[0] &&
        breakingP[0].length < content.length &&
        breakingP[0].length > 1000 &&
        content.length - breakingP[0].length > 1000
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
