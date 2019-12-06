<template>
  <button type="button" class="cldr-day btn px-0 text-center" @click="$emit('click', $event)" :disabled="disabled " :class="{ active, ...monthClass }">
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
  width: 4rem;
  height: 4rem;
  border-width: 3.3px;
  border-radius: 3px;
  font-size: 1.5rem;
  font-weight: bold;
  display: flex;
  justify-content: center;

  &:focus {
    box-shadow: none !important;
  }

  .month {
    font-size: .64rem;
    font-weight: normal;
    position: absolute;
    bottom: .18rem;
  }
}
</style>
