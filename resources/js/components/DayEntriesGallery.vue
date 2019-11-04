<template>
  <div>
    <transition-page>
      <day-entry :key="date" :date="currentDate" :content="content"></day-entry>
    </transition-page>
  </div>
</template>

<script>
export default {
  name: "JournalEntriesGallery",
  props: ["date"],
  data() {
    return {
      availableDays: [],
      content: ""
    };
  },
  computed: {
    currentDate() {
      return this.date;
    }
  },
  mounted() {
    axios.get(`/api/day/${this.date}`).then(({ data }) => {
      this.content = data.content;
    });
  },
  beforeRouteUpdate(to, from, next) {
    axios.get(`/api/day/${to.params.date}`).then(({ data }) => {
      this.content = data.content;
      next();
    });
  }
};
</script>
