<template>
  <button
    type="button"
    class="cldr-day btn px-0 text-center"
    :class="{ active, ...buttonVariant }"
    :disabled="disabled"
    @click="$emit('click', $event)"
  >
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
    dark: {
      type: Boolean,
      default: false,
    },
    colorCoded: {
      type: Boolean,
      default: false,
    },
  },
  computed: {
    dateParsed() {
      return dayjs(this.date)
    },
    buttonVariant() {
      if (this.dark) return { "btn-outline-dark": true }
      if (!this.colorCoded) return { "btn-outline-light": true }

      const monthNumber = this.dateParsed.month();
      return {
        "btn-outline-august": monthNumber === 7,
        "btn-outline-september": monthNumber === 8,
        "btn-outline-october": monthNumber === 9,
        "btn-outline-november": monthNumber === 10,
        "btn-outline-december": monthNumber === 11,
      }
    }
  },
};
</script>

<style lang="scss">
.cldr-day.btn {
  width: 3.9rem;
  height: 3.9rem;
  border-width: 3.3px;
  border-radius: 4px;
  font-size: 1.5rem;
  font-weight: bold;

  display: flex;
  justify-content: center;
  margin: auto;

  &:focus {
    box-shadow: none !important;
  }

  .month {
    font-size: .65rem;
    font-weight: normal;
    position: absolute;
    bottom: .18rem;
  }

  &.btn-outline-august,
  &.btn-outline-september,
  &.btn-outline-october,
  &.btn-outline-november,
  &.btn-outline-december {
    color: black;
  }
}
</style>
