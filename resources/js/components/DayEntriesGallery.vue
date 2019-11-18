<template>
  <div class="day-content">
    <div class="shift-block-container" v-touch:swipe="swipeHandler">
      <div class="shift-block koller doubled-bg bg-v3">
        <div class="profile-pic">
          <img class="w-100 h-100" src="/images/koller.jpg" />
        </div>
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-8">
              <div class="intro">
                <h1>Časo-pis</h1>
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
              <div class="intro">
                <i>
                  Denník Júliusa Kollera dokumentujúci udalosti a nálady
                  v spoločnosti počas zlomového roku
                </i>
              </div>
            </div>
          </div>
        </div>

        <transition-page>
          <div :key="date">
            <h4 class="date">{{ date | romanize }}</h4>
            <div class="weather" v-if="dayData.weather">
              {{ dayData.weather }}
            </div>
          </div>
        </transition-page>

        <transition-page>
          <day-entry
            :key="date"
            :date="currentDate"
            :content="dayData.excerpt"
          ></day-entry>
        </transition-page>
      </div>

      <div
        v-if="dayData.zatkuliak"
        class="shift-block koller-reply doubled-bg bg-v1"
      >
        <div class="profile-pic ">
          <img class="w-100 h-100" src="/images/zatkuliak.jpg" />
        </div>
        <transition-page>
          <div :key="date">
            <div v-html="dayData.zatkuliak"></div>

            <div class="credit">
              ŽATKULIAK, Jozef a kol.: November '89. Prodama, Bratislava 2009
            </div>
          </div>
        </transition-page>
      </div>
    </div>

    <transition-page>
      <div v-if="topics">
        <selected-topics :date="date" :topics="topics"></selected-topics>
      </div>
    </transition-page>
  </div>
</template>

<script>
import dayjs from "dayjs";

export default {
  name: "DayEntriesGallery",
  props: ["date"],
  data() {
    return {
      activeDatesStart: "",
      activeDatesEnd: "",
      dayData: "",
      topics: []
    };
  },
  computed: {
    currentDate() {
      return this.date;
    }
  },
  mounted() {
    this.getData(this.date);
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
      const self = this;
      axios.get(`/api/journal-entries/${date || fallbackDate}`).then(
        ({ data }) => {
          const entry = data.data;
          this.activeDatesStart = data.meta.activeDatesStart;
          this.activeDatesEnd = data.meta.activeDatesEnd;
          this.topics = data.meta.topics;
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
          const dayAfter = dayjs(this.date, "YYYY-MM-DD")
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
          const dayBefore = dayjs(this.date, "YYYY-MM-DD")
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
