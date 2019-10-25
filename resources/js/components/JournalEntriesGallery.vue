<template>
  <div>
    <h3>Gallery</h3>
    <p>{{ availableDays.length }} entries</p>
    <div v-if="filter">
      <p>Filter: {{ filter }} <router-link :to="{ name: 'journal-entries', params: { date: currentDate } }">Zrušiť</router-link></p>
    </div>
    <router-link
      v-for="day in availableDays"
      :key="day.written_at"
      :to="{ name: 'journal-entries', params: { date: day.written_at }, query: { filter } }"
    >
      {{ day.written_at | romanize }}
    </router-link>
    <br />
    <router-link :to="{ name: 'journal-entries', params: { date: previousDate }, query: { filter } }">Previous</router-link>
    <router-link :to="{ name: 'journal-entries', params: { date: nextDate }, query: { filter } }">Next</router-link>

    <transition name="fade">
      <keep-alive :max=10>
        <journal-entry :key="date" :date="currentDate"></journal-entry>
      </keep-alive>
    </transition>
  </div>
</template>

<script>
import dayjs from 'dayjs'

export default {
  name: "JournalEntriesGallery",
  props: ['date', 'filter'],
  data() {
    return {
      availableDays: [],
    }
  },
  mounted() {
    this.fetchAvailableDays(this.filter);
  },
  computed: {
    previousDate() {
      return dayjs(this.date).subtract(1, 'day').format('YYYY-MM-DD')
    },
    nextDate() {
      return dayjs(this.date).add(1, 'day').format('YYYY-MM-DD')
    },
    currentDate() {
      return this.date
    }
  },
  watch: {
    filter(newValue, oldValue) {
      console.log(oldValue, newValue)
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
    }
  },
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
