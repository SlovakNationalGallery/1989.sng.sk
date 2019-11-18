<template>
  <button type="button" class="cldr-day btn px-0" @click="$emit('click', $event)" :disabled="disabled " :class="{ active }">
    {{ dateParsed.format("D") }}
    <div class="month">{{ dateParsed.format("MMMM") }}</div>
  </button>
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
    disabled: {
      type: Boolean,
      default: false,
    },
    active: {
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

<style lang="scss">
.cldr-day.btn {
  width: 76px;
  height: 76px;
  text-align: center;
  border-width: 4px;
  border-radius: 4px;
  font-size: 28px;
  font-weight: bold;

  &:focus {
    box-shadow: none !important;
  }

  .month {
    font-size: 12px;
    font-weight: normal;
    margin-top: -8px;
  }
}
</style>
