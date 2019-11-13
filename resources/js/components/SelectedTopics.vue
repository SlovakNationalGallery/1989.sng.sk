<template>
  <div class="container selected-topics">
    <div class="row">
      <div class="col-sm-12">
        <h3 class="selection-for">
          <span class="selection">Výber tém pre</span>
          <span class="date"
            >{{ dateJS.format("D.") }}
            <span class="underline">{{ dateJS.format("MMMM") }}</span>
            {{ dateJS.format("YYYY") }}</span
          >
        </h3>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-4 col-sm-12 selected-topic" v-for="$topic in topics" :key="$topic.slug">
        <!-- na mobile by som sem dal carousel -->
        <div class="white">
          <a :href="'/' + $topic.slug">
            <div class="topic-preview" v-bind:style="{ backgroundImage: 'url(' + $topic.cover_image + ')' }"></div>
          </a>
        </div>
        <div class="description">
          <h3>
            <a :href="'/' + $topic.slug">
              {{ $topic.name }}
            </a>
          </h3>
          <p>
            {{ $topic.description && $topic.description.substr(0, 200) }}
            <span v-if="$topic.description && $topic.description.length > 200"
              >...</span
            >
          </p>
          <a class="btn btn-outline-light" :href="'/' + $topic.slug">Čítaj viac</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import dayjs from "dayjs";
import utc from "dayjs/plugin/utc";
import "dayjs/locale/sk";
dayjs.extend(utc);
dayjs.locale("sk");

export default {
  props: ["date", "topics"],
  computed: {
    dateJS() {
      return dayjs(this.date, "YYYY-MM-DD");
    }
  }
};
</script>
<style lang="scss">

@import '~@/_variables.scss';

.selected-topics {
  margin-top: 3rem;
}

.selected-topic {
  padding: 2em !important;
}

.selected-topics .selection-for {
  text-align: center;
  color: $white;
  padding-left: 0;
}

.selected-topics .selection-for .selection {
  display: block;
  font-weight: normal;
  padding: 0.5rem;
  font-family: $font-family-base;
  font-style: oblique;
}
.selected-topics .selection-for .date {
  font-family: $font-family-base;
  font-weight: $headings-font-weight;
}

.selected-topic .description {
  color: $white;
  text-align: left;
}
.selected-topic .description h4 {
  margin: 0;
}

div.topic-preview {
  transform: translate(-0.5em, -0.5em);
  background-color: $gray-dark;
  background-size: cover;
  background-position: top center;
  width: 100%;
  padding-bottom: 65%;
  opacity: 0.9;
  transition: opacity, transform .2s ease-in-out;
  .white a:hover & {
    opacity: 1.0;
    transform: translate(-0.3em, -0.3em);
  }
}

</style>
