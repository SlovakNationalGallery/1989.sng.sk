<template>
  <div>
    <div v-if="filter">
      <p>Filter: {{ filter }} <router-link :to="{ name: 'journal-entries', params: { date } }">Zrušiť</router-link></p>
    </div>
    <calendar-row-view
      class="dark mt-4"
      dayClass="btn-outline-dark"
      :days="availableDays.map(day => ({ d: day.written_at, active: true }))"
      :selectedDay="date"
      @change="onDaySelected"
    ></calendar-row-view>
    <!-- <router-link
      v-for="day in availableDays"
      :key="day.written_at"
      :to="{ name: 'journal-entries', params: { date: day.written_at }, query: { filter } }"
    >
      {{ day.written_at | romanize }}
    </router-link> -->

    <transition-page>
      <keep-alive :max="10">
        <journal-entry :key="date" :date="date"></journal-entry>
      </keep-alive>
    </transition-page>
  </div>
</template>

<script>
import dayjs from 'dayjs'
import CalendarRowView from "./RowView";

export default {
  name: "JournalEntriesGallery",
  props: ['date', 'filter'],
  components: { CalendarRowView },
  data() {
    return {
      availableDays: [],
    }
  },
  mounted() {
    this.fetchAvailableDays(this.filter);
  },
  watch: {
    filter(newValue, oldValue) {
      this.fetchAvailableDays(newValue)
    }
  },
  methods: {
    fetchAvailableDays(filter) {
      axios
        .get(`/api/journal-entries`, { params: { tag: filter }  })
        .then(({data: {data}}) => {
          this.availableDays = data
        })
    },
    onDaySelected(date) {
      Router.push({ name: "journal-entries", params: { date } });
    }
  },
}
</script>
