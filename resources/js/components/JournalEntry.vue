<template>
  <div>
    <h2>{{ dateFormatted }}</h2>
    <div style="display: flex">
      <!-- <img
        v-for="id in transcriptionPagesIds"
        :key="id"
        :src="`https://fromthepage.com/image-service/${id}/full/full/0/default.jpg`"
        width="300"
      /> -->
    </div>
   <!-- <div v-html="content" ></div> -->
   <div :is="contentCompiled"></div>
  </div>
</template>

<script>
import dayjs from "dayjs"

const romanNumbers = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII']

export default {
  name: "JournalEntry",
  props: ['date'],
  data() {
    return {
      transcriptionPagesIds: [],
      content: '',
    }
  },
  mounted() {
    this.fetchData(this.date);
  },
  computed: {
    dateFormatted() {
      const date = dayjs(this.date, "YYYY-MM-DD")
      return date.format(`D. [${romanNumbers[date.month()]}]. YYYY`)
    },
    contentCompiled() {
      const regex = /<a href="topic:\/\/(.+?)">(.+?)<\/a>/g
      const contentWithRouterLinks = this.content.replace(regex, `<router-link :to="'/journal-entries?tag=$1'">$2</router-link>`)

      const template = Vue.compile(`<div>${contentWithRouterLinks}</div>`)
      return { ...template, data: () => ({}) }
    }
  },
  watch: {
    date(newDate, oldDate) {
      this.fetchData(this.newDate);
    }
  },
  methods: {
    fetchData(date) {
      axios
        .get(`/api/journal-entries/${this.date}`)
        .then(({data: {data}}) => {
          this.transcriptionPagesIds = data.transcription_pages_ids
          this.content = data.content
        })
    }
  },
}
</script>

<style lang="scss" scoped>

</style>
