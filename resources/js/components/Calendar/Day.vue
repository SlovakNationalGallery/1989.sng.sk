<template>
  <div class="day" @click="$emit('click', $event)" :class="{ selected, active }">
    {{ dateParsed.format("D") }}
    <div class="month">{{ dateParsed.format("MMMM") }}</div>
  </div>
</template>

<script>
import dayjs from "dayjs";
import "dayjs/locale/sk";
dayjs.locale("sk");

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
  width: 76px;
  height: 76px;
  padding-top: 10px;
  text-align: center;
  color: white;
  border: 4px solid white;
  transition: all, .3s;
  border-radius: 4px;
  font-size: 28px;
  font-weight: bold;
  opacity: .5;
  pointer-events: none;

  .month {
    font-size: 12px;
    font-weight: normal;
    margin-top: -8px;
  }

  &.selected {
    color: black;
    background: white;
  }

  &.active {
    opacity: 1;
    cursor: pointer;
    pointer-events: inherit;

    &:hover {
      color: black;
      background: white;
    }
  }
}
</style>
