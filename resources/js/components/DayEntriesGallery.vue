<template>
  <div class="day-content">
    <div class="shift-block-container ">
      <div class="shift-block koller doubled-bg bg-v3">
        <div class="profile-pic">
          <img class="w-100 h-100" src="/images/koller.jpg" />
        </div>
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-8">
              <div class="intro">
                <h1>Časo-pis</h1>
                <i>
                  Denník Júliusa Kollera dokumentujúci udalosti a nálady
                  v spoločnosti počas zlomového roku
                </i>
              </div>
            </div>
            <div class="col-md-4">
              <a :href="'/journal-entries/' + date" class="read-casopis">
                <img class="w-100" src="/images/read_casopis.jpg" />
              </a>
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
            :content="dayData.content_for_frontpage"
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
  </div>
</template>

<script>
export default {
  name: "DayEntriesGallery",
  props: ["date"],
  data() {
    return {
      availableDays: [],
      dayData: ""
    };
  },
  computed: {
    currentDate() {
      return this.date;
    }
  },
  mounted() {
    axios.get(`/api/journal-entries/${this.date}`).then(({ data: { data } }) => {
      this.dayData = data;
    });
  },
  beforeRouteUpdate(to, from, next) {
    axios.get(`/api/journal-entries/${to.params.date}`).then(({ data: { data } }) => {
      this.dayData = data;
      next();
    });
  }
};
</script>
