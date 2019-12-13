<template>
  <div class="mt-3">
    <div id="toolbar" class="py-2">
      <button id="toolbar-zoom-in" class="btn btn-sm btn-light">
        <i class="fas fa-plus"></i>
      </button>
      <button id="toolbar-zoom-out" class="btn btn-sm btn-light">
        <i class="fas fa-minus"></i>
      </button>
      <button id="toolbar-home" class="btn btn-sm btn-light">
        <i class="fas fa-home"></i>
      </button>
      <button id="toolbar-full" class="btn btn-sm btn-light">
        <i class="fas fa-expand-arrows-alt"></i>
      </button>
      <button id="toolbar-prev" class="btn btn-sm btn-light">
        <i class="fas fa-long-arrow-alt-left"></i>
      </button>
      <button id="toolbar-next" class="btn btn-sm btn-light">
        <i class="fas fa-long-arrow-alt-right"></i>
      </button>
    </div>
    <div id="image-container" class="bg-white"></div>
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
import OpenSeadragon from "openseadragon";

OpenSeadragon.setString("Tooltips.Home","Počiatočné priblíženie");
OpenSeadragon.setString("Tooltips.ZoomOut","Oddialiť");
OpenSeadragon.setString("Tooltips.ZoomIn", "Priblížiť");
OpenSeadragon.setString("Tooltips.FullPage","Na celú obrazovku");
OpenSeadragon.setString("Tooltips.NextPage","Ďalšia strana");
OpenSeadragon.setString("Tooltips.PreviousPage","Predchádzajúca strana");

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
  watch: {
    transcriptionPagesIds(transcriptionPagesIds) {
      if (this.imageViewer) this.imageViewer.destroy();

      this.imageViewer = OpenSeadragon({
        id: "image-container",
        prefixUrl: "/vendor/openseadragon/images/",
        zoomInButton: "toolbar-zoom-in",
        zoomOutButton: "toolbar-zoom-out",
        homeButton: "toolbar-home",
        fullPageButton: "toolbar-full",
        previousButton: "toolbar-prev",
        nextButton: "toolbar-next",
        toolbar: "toolbar",
        visibilityRatio: 1,
        minZoomLevel: 1,
        sequenceMode: true,
        tileSources: transcriptionPagesIds.map(id => `https://fromthepage.com/image-service/${id}/info.json`)
      });

      const vm = this;
      this.imageViewer.addHandler('page', function ({page}) {
        vm.detailedTranscriptionPageId = vm.transcriptionPagesIds[page]
      })
    }
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
      this.imageViewer.goToPage(this.transcriptionPagesIds.indexOf(transcriptionPageId))
    }
  }
};
</script>

<style lang="scss">
@import "~@/_variables.scss";

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

// https://github.com/openseadragon/openseadragon/issues/893
.openseadragon-container :focus { outline: none; }

#image-container {
  height: 40vh;
}
</style>
