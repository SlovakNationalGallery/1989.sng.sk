<template>
  <div class="day-content">
    <div
      class="shift-block-container"
      v-touch:swipe="swipeHandler"
      ref="anchor"
    >
      <div class="shift-block koller doubled-bg bg-v3">
        <div class="profile-pic">
          <img class="w-100 h-100" src="/images/koller.jpg" />
        </div>
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-8">
              <div class="intro">
                <div :key="date">
                  <h2 class="date py-3 pt-md-5">{{ date | romanize }}</h2>
                </div>
              </div>
            </div>
            <div class="col-md-4 read-casopis">
              <!-- <a :href="'/journal-entries/' + date" class="read-casopis"> -->
              <img
                class="w-100 d-none d-md-block"
                src="/images/read_casopis.jpg"
              />
              <!-- </a> -->
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

        <div :key="date">
          <div class="weather" v-if="dayData && dayData.weather">
            {{ dayData.weather }}
          </div>
          <day-entry
            :key="date"
            :date="currentDate"
            :content="dayData.excerpt"
          ></day-entry>
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
          ŽATKULIAK, Jozef a kol.: November '89. Prodama, Bratislava 2009
        </div>
      </div>
    </div>

    <div v-if="topics">
      <selected-topics :date="date" :topics="topics"></selected-topics>
    </div>
  </div>
</template>

<script>
import dayjs from "dayjs";

export default {
  name: "DayEntriesGallery",
  props: ["date"],
  data() {
    return {
      dayData: "",
      topics: [],
      activeDatesEnd : "",
      activeDatesStart: "",
      scrollTop: 0
    };
  },
  computed: {
    currentDate() {
      return this.date;
    }
  },
  mounted() {
    this.getData(this.date);
    this.scrollTop = this.$refs.anchor.getBoundingClientRect().y;
  },
  watch: {
    $route(to) {
      this.getData(to.params.date);
    }
  },
  methods: {
    getData(date, callback) {
      //TODO make sure fallbackDate does not run outside the journal range
      const fallbackDate = dayjs()
        .set("year", 1989)
        .format("YYYY-MM-DD");
      axios.get(`/api/day/${date || fallbackDate}`).then(
        ({ data }) => {
          this.dayData = data.journalEntry;
          this.topics = data.topics;
          this.activeDatesEnd = data.activeDatesEnd;
          this.activeDatesStart = data.activeDatesStart;
          if (this.scrollTop < document.scrollingElement.scrollTop) {
            window.scrollTo({ top: this.scrollTop, behavior: "smooth" });
          }
          callback && callback();
        },
        () => {
          self.topics = null;
          self.dayData = {
            weather: "",
            excerpt: "Pre daný deň neexistuje záznam v denníku"
          };
          callback && callback();
        }
      );
      return;
    },
    swipeHandler(e) {
      switch (e) {
        case "left":
          var dayAfter = dayjs(this.date, "YYYY-MM-DD")
            .add(1, "day")
            .set("year", 1989)
            .format("YYYY-MM-DD");

          if (dayAfter > this.activeDatesEnd) return;

          Router.push({
            name: "days",
            params: {
              date: dayAfter
            }
          });
          break;

        case "right":
          var dayBefore = dayjs(this.date, "YYYY-MM-DD")
            .subtract(1, "day")
            .set("year", 1989)
            .format("YYYY-MM-DD");

          if (dayBefore < this.activeDatesStart) return;

          Router.push({
            name: "days",
            params: {
              date: dayBefore
            }
          });
      }
    }
  }
};
</script>
