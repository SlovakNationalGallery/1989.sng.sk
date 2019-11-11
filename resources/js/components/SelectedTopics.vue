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
            <img
              v-if="$topic.cover_image"
              class="w-100"
              :src="'/' + $topic.cover_image"
            />
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
.selected-topics {
  margin-top: 3rem;
}

.selected-topic {
  padding: 2em !important;
}

.selected-topics .selection-for {
  text-align: center;
  color: white;
  padding-left: 0;
}

.selected-topics .selection-for .selection {
  display: block;
  font-weight: normal;
  padding: 0.5rem;
  font-family: "AvenirLTPro";
  font-style: oblique;
}
.selected-topics .selection-for .date {
  font-family: "AvenirLTPro";
  font-weight: 700;
}

.selected-topic img {
  transform: translate(-0.5em, -0.5em);
}

.selected-topic .description {
  color: white;
  text-align: left;
}
.selected-topic .description h4 {
  margin: 0;
}
</style>
