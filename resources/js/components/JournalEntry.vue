<template>
  <div class="mt-3">
    <div id="ximage-container" class="ratio-container">
      <picture
        v-if="detailedTranscriptionPageId"
        :key="detailedTranscriptionPageId">
        <source media="(min-width: 1200px)" :srcset="`https://fromthepage.com/image-service/${detailedTranscriptionPageId}/full/1200,/0/default.jpg`">
        <source media="(min-width: 992px)" :srcset="`https://fromthepage.com/image-service/${detailedTranscriptionPageId}/full/992,/0/default.jpg`">
        <source media="(min-width: 768px)" :srcset="`https://fromthepage.com/image-service/${detailedTranscriptionPageId}/full/768,/0/default.jpg`">
        <source media="(min-width: 576px)" :srcset="`https://fromthepage.com/image-service/${detailedTranscriptionPageId}/full/576,/0/default.jpg`">
        <img
          :src="`https://fromthepage.com/image-service/${detailedTranscriptionPageId}/full/400,/0/default.jpg`"
        >
      </picture>
    </div>
    <carousel
      class="carousel mt-2"
      :perPage="8"
      :paginationEnabled="false"
    >
      <slide
        class="slide text-center"
        v-for="transcriptionPageId in transcriptionPagesIds"
        :key="transcriptionPageId"
        @slideclick="onTranscriptionPageClick(transcriptionPageId)"
        :class="{active: detailedTranscriptionPageId === transcriptionPageId}"
      >
        <img :src="`https://fromthepage.com/image-service/${transcriptionPageId}/full/,100/0/default.jpg`" />
        <hr class="mx-2 mt-2" />
      </slide>
    </carousel>
    <h2 class="h5 px-0">{{date | romanize }}</h2>
    <p>{{weather}}</p>
    <div v-html="content"></div>
  </div>
</template>

<script>
import { Carousel, Slide } from "vue-carousel";

export default {
  name: "JournalEntry",
  components: { Carousel, Slide },
  props: ["date"],
  data() {
    return {
      transcriptionPagesIds: [],
      detailedTranscriptionPageId: null,
      content: "",
      weather: ""
    };
  },
  mounted() {
    this.fetchData(this.date);
  },
  methods: {
    fetchData(date) {
      axios
        .get(`/api/journal-entries/${this.date}`)
        .then(({ data: { data } }) => {
          this.transcriptionPagesIds = data.transcription_pages_ids;
          this.detailedTranscriptionPageId = data.transcription_pages_ids[0];
          this.content = data.content;
          this.weather = data.weather;
        });
    },
    onTranscriptionPageClick(transcriptionPageId) {
      this.detailedTranscriptionPageId = transcriptionPageId;
    }
  }
};
</script>

<style lang="scss">
@import "~@/_variables.scss";
@import '~bootstrap/scss/bootstrap';

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

.ratio-container {
  position: relative;

  &:after {
    content: '';
    display: block;
    height: 0;
    width: 100%;
    padding-bottom: calc(3 / 4 * 100%) ; /* 4:3 */
  }

  & img {
    position: absolute;
    top: 0;
    left: 50%;
    margin-left: -50%;
    height: 100%;
    display: block;
  }
}
</style>
