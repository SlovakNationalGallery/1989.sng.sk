<template>
  <div>
    <h3>Gallery</h3>
    <p v-if="filter">Filter: {{ filter }}</p>

    <router-link :to="`/journal-entries/${this.previousDate}`">Previous</router-link>
    <router-link :to="`/journal-entries/${this.nextDate}`">Next</router-link>

    <transition name="fade">
      <keep-alive :max=10>
        <journal-entry :key="date" :date="date"></journal-entry>
      </keep-alive>
    </transition>
  </div>
</template>

<script>
import dayjs from "dayjs"

export default {
  name: "JournalEntriesGallery",
  props: ['date'],
  data() {
    return {
      filter: null,
      availableDays: [],
    }
  },
  computed: {
    previousDate() {
      return dayjs(this.date, 'YYYY-MM-DD').subtract(1, 'day').format('YYYY-MM-DD')
    },
    nextDate() {
      return dayjs(this.date, 'YYYY-MM-DD').add(1, 'day').format('YYYY-MM-DD')
    }
  },
  methods: {
    onPreviousDayClick() {
      this.date = dayjs(this.date, 'YYYY-MM-DD').subtract(1, 'day').format('YYYY-MM-DD')
    },
    onNextDayClick() {
      this.date = dayjs(this.date, 'YYYY-MM-DD').add(1, 'day').format('YYYY-MM-DD')
    }
  }
}
</script>

<style lang="scss" scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity .5s;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}
</style>
