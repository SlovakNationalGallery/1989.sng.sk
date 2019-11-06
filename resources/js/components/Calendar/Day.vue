<template>
  <div class="day" @click="$emit('click', $event)" :class="{ selected, active }">
    {{ dateParsed.format("D") }}
    <div class="month">{{ dateParsed.format("MMMM") }}</div>
  </div>
</template>

<script>
import dayjs from "dayjs";
import utc from "dayjs/plugin/utc";
import "dayjs/locale/sk";
dayjs.extend(utc);
dayjs.locale("sk");
import weekOfYear from "dayjs/plugin/weekOfYear";

export default {
  name: "CalendarDay",
  props: {
    date: {
      type: String,
      required: true,
    },
    active: {
      type: Boolean,
      default: false,
    },
    selected: {
      type: Boolean,
      default: false,
    },
  },
  computed: {
    dateParsed() {
      return dayjs(this.date)
    },
  },
};
</script>

<style lang="scss" scoped>

.day {
  width: 80px;
  height: 80px;
  padding-top: 10px;
  cursor: pointer;
  text-align: center;
  transition: all 0.5s;
  color: white;
  border: 2px solid white;
  border-radius: 2px;
  font-size: 16px;
  font-weight: bold;

  .month {
    font-size: 7px;
    font-weight: normal;
    margin-top: -2px;
  }

  &.selected {
    background: red;
  }
}
.cldr-row-day.inactive {
  color: #aaa;
  pointer-events: none;
}
</style>
