<template>
  <div class="day-content">
    <div
      class="shift-block-container"
      v-touch:swipe="swipeHandler"
    >
      <div class="shift-block koller doubled-bg bg-v3">
        <div class="profile-pic">
          <img class="w-100 h-100" src="/images/koller.jpg" />
        </div>
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-8">
              <div class="intro">
                <div :key="currentDate">
                  <h2 class="date py-3 pt-md-5">{{ currentDate | romanize }}</h2>
                </div>
              </div>
            </div>
            <div class="col-md-4 d-none d-md-block pb-2 text-right read-casopis">
              <a
                :href="hrefToGallery"
                title="Prečítať si originál denníka"
              >
                <img
                  v-if="firstTranscriptionPageId"
                  class="img-fluid mh-100"
                  :src="`https://fromthepage.com/image-service/${firstTranscriptionPageId}/full/300,/0/default.jpg`"
                />
              </a>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="intro text-muted">
                <i>
                  Denník Júliusa Kollera dokumentujúci udalosti a nálady
                  v spoločnosti počas zlomového roku
                </i>
              </div>
            </div>
          </div>
        </div>

        <div :key="currentDate">
          <div class="weather" v-if="dayData && dayData.weather">
            {{ dayData.weather }}
          </div>
          <day-entry
            :key="currentDate"
            :date="currentDate"
            :content="dayData.excerpt"
          ></day-entry>
          <a :href="hrefToGallery" class="btn btn-sm btn-outline-dark">Prečítať si celý denník</a>
        </div>
      </div>

      <div
        v-if="dayData.zatkuliak"
        class="shift-block koller-reply doubled-bg bg-v1"
      >
        <div class="profile-pic ">
          <img class="w-100 h-100" src="/images/zatkuliak.jpg" />
        </div>

        <div v-html="dayData.zatkuliak"></div>

        <div class="credit">
            <a
              href="http://forumhistoriae.sk/documents/10180/734133/zatkuliak-november89-full.pdf" target="_blank"
              title="Prejsť na e-knihu"
            >
              ŽATKULIAK, Jozef a kol.: November '89. Prodama, Bratislava 2009
            </a>
        </div>
      </div>
    </div>

    <div v-if="topics">
      <selected-topics :date="currentDate" :topics="topics"></selected-topics>
    </div>
  </div>
</template>

<script>
import dayjs from "dayjs";
import { initializeJournalTagPopovers } from '../journal-entries-popovers';

export default {
  name: "DayEntriesGallery",
  props: ["defaultDate", "activeDatesStart", "activeDatesEnd"],
  data() {
    return {
      dayData: "",
      currentDate: this.defaultDate,
      topics: [],
      scrollTop: 0,
      firstTranscriptionPageId: null,
    };
  },
  computed: {
    hrefToGallery() {
      return Router.resolve({
        name: 'journal-entries',
        params: { date: this.currentDate },
      }).href
    }
  },
  mounted() {
    this.getData(this.currentDate);
    initializeJournalTagPopovers();
  },
  watch: {
    $route(to) {
      this.currentDate = to.params.date || this.defaultDate
      this.getData(this.currentDate);
    }
  },
  methods: {
    getData(date) {
      axios.get(`/api/day/${date}`).then(
        ({ data }) => {
          this.dayData = data.journalEntry;
          this.topics = data.topics;
          this.firstTranscriptionPageId = data.journalEntry.transcription_pages_ids[0]
        }
      );
    },
    swipeHandler(e) {
      switch (e) {
        case "left":
          var dayAfter = dayjs(this.currentDate).add(1, "day")

          if (dayAfter.isAfter(dayjs(this.activeDatesEnd))) return;

          Router.push({
            name: "days",
            params: {
              date: dayAfter.format("YYYY-MM-DD")
            }
          });
          setTimeout(() => document.querySelector('#dennik').scrollIntoView({ behavior: 'smooth' }), 100);
          break;

        case "right":
          var dayBefore = dayjs(this.currentDate).subtract(1, "day")

          if (dayBefore.isBefore(dayjs(this.activeDatesStart))) return;

          Router.push({
            name: "days",
            params: {
              date: dayBefore.format("YYYY-MM-DD")
            }
          });
          setTimeout(() => document.querySelector('#dennik').scrollIntoView({ behavior: 'smooth' }), 100);
      }
    }
  }
};
</script>
