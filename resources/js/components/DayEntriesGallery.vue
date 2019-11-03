<template>
  <div>
    day entries gallery
    <transition-page>
      <keep-alive :max="10">
        <day-entry :key="date" :date="currentDate"></day-entry>
      </keep-alive>
    </transition-page>
  </div>
</template>

<script>
import dayjs from "dayjs";

export default {
  name: "JournalEntriesGallery",
  props: ["date"],
  data() {
    return {
      availableDays: []
    };
  },
  computed: {
    currentDate() {
      return this.date;
    }
  }
};
</script>
