<template>
  <div>
    <h2>{{ date | romanize }}</h2>
    <div style="display: flex">
      <img
        v-for="id in transcriptionPagesIds"
        :key="id"
        :src="`https://fromthepage.com/image-service/${id}/full/full/0/default.jpg`"
        width="300"
      />
    </div>
   <div :is="contentCompiled"></div>
  </div>
</template>

<script>
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
    contentCompiled() {
      const regex = /<a\s+href="tag:\/\/(.+?)">(.*?)<\/a>/gs
      const contentWithRouterLinks = this.content.replace(
        regex,
        `<router-link :to="{ name: 'journal-entries', params: { date: '${this.date}' }, query: { filter: '$1' }}">$2</router-link>`
      )

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
