<template>
  <div class="mt-5">
    <img
      v-if="detailedTranscriptionPageId"
      class="img-fluid"
      :key="detailedTranscriptionPageId"
      :src="`https://fromthepage.com/image-service/${detailedTranscriptionPageId || transcriptionPagesIds[0]}/full/full/0/default.jpg`"
    />
    <carousel
      class="mt-2"
      :perPage="8"
      :paginationEnabled="false"
    >
      <slide
        class="slide"
        v-for="transcriptionPageId in transcriptionPagesIds"
        :key="transcriptionPageId"
        @slideclick="onTranscriptionPageClick(transcriptionPageId)"
        :class="{active: detailedTranscriptionPageId === transcriptionPageId}"
      >
        <img
          :src="`https://fromthepage.com/image-service/${transcriptionPageId}/full/full/0/default.jpg`"
          width="80"
        />
        <hr class="mx-2 mt-2">
      </slide>
    </carousel>
    <h2 class="h5 px-0">{{date | romanize }}</h2>
    <p>{{weather}}</p>
    <div :is="contentCompiled"></div>
    <div class="text-center">
      <a href="#top" title="Na začiatok stránky" class="jump-to-top btn btn-outline-dark">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="10" viewBox="0 0 16 10">
            <path class="a" d="M14,14.281l-6.993-7.5L0,14.281" style="fill:none;stroke-width:3px;" transform="translate(1.096 -4.588)"/>
        </svg>
      </a>
    </div>
  </div>
</template>

<script>
import { Carousel, Slide } from "vue-carousel";

export default {
  name: "JournalEntry",
  components: { Carousel, Slide },
  props: ['date'],
  data() {
    return {
      transcriptionPagesIds: [],
      detailedTranscriptionPageId: null,
      content: '',
      weather: '',
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
          this.detailedTranscriptionPageId = data.transcription_pages_ids[0]
          this.content = data.content
          this.weather = data.weather
        })
    },
    onTranscriptionPageClick(transcriptionPageId) {
      this.detailedTranscriptionPageId = transcriptionPageId
    }
  },
}
</script>

<style lang="scss" scoped>
@import '~@/_variables.scss';

img {
  max-height: 100vh;
}

.slide {
  cursor: pointer;

  hr {
    visibility: hidden;
  }

  &.active {
    hr {
      visibility: visible;
      border-color: $blue;
    }
  }


  &:hover > hr {
    visibility: visible;
  }
}
</style>
