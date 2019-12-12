<template>
  <div>
    <div v-if="filter" id="filter" class="text-center pt-3">
      <p class="lead mb-1">Preskúmať heslo: {{ filter }}</p>
      <p v-if="filterTagCategories" class="mb-0">Kategórie: {{ filterTagCategories.join(', ') }}</p>
      <p>Heslo sa nachádza v nasledujúcich dňoch:</p>

    </div>
    <calendar-row-view
      v-if="availableDays.length > 0"
      class="mt-4 mx-xl-5"
      dark
      :days="availableDays.map(day => ({ d: day.written_at, active: true }))"
      :currentDate="date"
      @change="onDaySelected"
    ></calendar-row-view>
    <div id="button-controls" class="text-center mt-3">
      <button type="button" class="btn btn-sm btn-outline-dark m-1" data-toggle="modal" data-target="#calendar-full">
        Kalendár
      </button>
      <router-link v-if="filter" class="btn btn-sm btn-outline-dark m-1" :to="{ name: 'journal-entries', params: { date } }">× Zrušiť filter</router-link>
    </div>
    <calendar-full
      id="calendar-full"
      :enabledDays="availableDays.map(({written_at}) => written_at)"
      :activeDay="date"
      @dayClick="onDaySelected"
    ></calendar-full>
    <transition name="fade">
      <keep-alive :max="10">
        <journal-entry :key="date" :date="date"></journal-entry>
      </keep-alive>
    </transition>
    <div class="row py-5">
      <div class="col-sm-2 order-1 order-sm-2 text-center">
        <a href="#top" title="Na začiatok stránky" class="jump-to-top btn btn-outline-dark btn-sm">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="10" viewBox="0 0 16 10">
              <path class="a" d="M14,14.281l-6.993-7.5L0,14.281" style="fill:none;stroke-width:3px;" transform="translate(1.096 -4.588)"/>
          </svg>
        </a>
      </div>
      <div class="col-sm-5 order-2 order-sm-1 pt-2">
        <router-link
          :to="{ name: 'journal-entries', params: { date: previousDate }, query: { filter } }"
          class="btn btn-outline-dark btn-sm btn-block"
          :class="{ disabled: !this.previousDate }"
        >← Predchádzajúci deň</router-link>
      </div>
      <div class="col-sm-5 order-3 text-right pt-2">
        <router-link
          :to="{ name: 'journal-entries', params: { date: nextDate }, query: { filter } }"
          class="btn btn-outline-dark btn-sm btn-block"
          :class="{ disabled: !this.nextDate }"
        >Nasledujúci deň →</router-link>
      </div>
    </div>
  </div>
</template>

<script>
import dayjs from 'dayjs'
import { isEmpty, get } from "lodash";
import CalendarRowView from "./RowView";
import CalendarFull from "./Calendar/Full";
import { initializeJournalTagPopovers } from '../journal-entries-popovers';


export default {
  name: "JournalEntriesGallery",
  props: ['date', 'filter'],
  components: { CalendarRowView, CalendarFull },
  data() {
    return {
      availableDays: [],
      filterTagCategories: []
    }
  },
  mounted() {
    this.fetchAvailableDays(this.filter);
    initializeJournalTagPopovers();
  },
  computed: {
    previousDate() {
      const previousDayIndex = this.availableDays.findIndex(({written_at}) => written_at === this.date) - 1
      return get(this.availableDays[previousDayIndex], 'written_at');
    },
    nextDate() {
      const nextDayIndex = this.availableDays.findIndex(({written_at}) => written_at === this.date) + 1
      return get(this.availableDays[nextDayIndex], 'written_at');
    },
  },
  watch: {
    filter(newValue) {
      this.fetchAvailableDays(newValue)
    },
  },
  methods: {
    fetchAvailableDays(filter) {
      axios
        .get(`/api/journal-entries`, { params: { tag: filter }  })
        .then(({data: {data}}) => {
          this.availableDays = get(data, 'days', [])
          this.filterTagCategories = get(data, 'tag.categories', [])
        })
    },
    onDaySelected(date) {
      Router.push({ name: "journal-entries", params: { date }, query: { filter: this.filter } });
    }
  },
}
</script>
<style lang="scss">
@import "~@/_variables.scss";

#filter {
  h2 {
    font-family: $font-family-base;
    font-size: 2rem;
  }
}

#button-controls > * {
  width: 10em;
}
</style>
