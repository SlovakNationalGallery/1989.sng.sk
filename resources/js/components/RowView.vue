<template>
  <div class="cldr-row">
    <button class='btn btn-dark' @click="prevPeriod()">〈</button>
    <button @click="prevPeriod()">〈</button>
    <transition-group name="list" class="days-wrapper" :class="direction">
      <calendar-day
        v-for="(day) in displayedDays"
        :onClick="selectDay.bind(this, day)"
        :key="day.d"
        :date="day.d"
        :active="day.active"
        :selected="selectedDay === day.d"
      ></calendar-day>
    </transition-group>
    <button @click="nextPeriod()">〉</button>
  </div>
</template>

<script>
import CalendarDay from './Calendar/Day'

export default {
  name: "RowView",
  components: { CalendarDay },
  props: {
    startAt: {
      type: String,
      required: true
    },
    days: {
      type: Array,
      required: true
    }
  },
  data() {
    return {
      selectedIndex: this.startAt
        ? this.days.findIndex(a => a.d === this.startAt)
        : this.days.findIndex(a => a.active),
      middle: Math.floor(this.displayCount / 2),
      direction: "left",
      cnt: this.displayCount * 3,
      displayWindow: 9,
    };
  },
  created() {
    this.updateDisplayWindow();

    this.onWindowResize = _.debounce(this.updateDisplayWindow, 200)
    window.addEventListener("resize", this.onWindowResize);
  },
  beforeDestroy() {
    window.removeEventListener("resize", this.onWindowResize);
  },
  watch: {
    startAt() {
      this.selectedIndex = this.startAt
        ? this.days.findIndex(a => a.d === this.startAt)
        : this.days.findIndex(a => a.active);
    },
  },
  computed: {
    selectedDay() {
      return (
        this.startAt &&
        this.days[this.selectedIndex] &&
        this.days[this.selectedIndex].d
      );
    },
    displayedDays() {
      const padding = (this.displayWindow - 1) / 2
      return _
        .range(-padding, padding + 1)
        .map(dayIndexOffset => this.days[this.selectedIndex + dayIndexOffset])
    },
    startIndex() {
      return this.days.findIndex(a => a.active);
    },
    endIndex() {
      return this.days.findIndex(a => a.d > this.startAt && !a.active) - 1;
    }
  },
  methods: {
    prevPeriod() {
      this.direction = "right";
      this.selectedIndex = Math.max(
        this.selectedIndex - this.displayCount,
        this.startIndex
      );
      this.$emit("input", this.days[this.selectedIndex].d);
    },
    nextPeriod() {
      this.direction = "left";
      this.selectedIndex = Math.min(
        this.selectedIndex + this.displayCount,
        this.endIndex
      );
      this.$emit("input", this.days[this.selectedIndex].d);
    },
    selectDay(d) {
      const target = this.days.indexOf(d);
      this.direction = target > this.selectedIndex ? "left" : "right";
      this.selectedIndex = target;
      this.$emit("input", d.d);
    },
    updateDisplayWindow() {
      function minSize(daysCount) {
        const dayWidth = 50
        const gutter = 10
        const buttonWidth = 40
        // This needs to be kept in sync with CSS dimensions under .cldr-row
        return daysCount * (dayWidth + gutter) + 2 * (buttonWidth + 3 * gutter)
      }

      if (window.innerWidth > minSize(9)) return this.displayWindow = 9
      if (window.innerWidth > minSize(7)) return this.displayWindow = 7
      if (window.innerWidth > minSize(5)) return this.displayWindow = 5
      if (window.innerWidth > minSize(3)) return this.displayWindow = 3

      return this.displayWindow = 1
    },
  }
};
</script>

<style lang="scss" scoped>
.cldr-row {
  $day-width: 50px;
  $gutter: 10px;
  $button-width: 40px;

  display: flex;
  justify-content: center;

  button {
    width: $button-width;
  }

  .days-wrapper {
    display: flex;
    overflow-x: hidden;
    margin-left: 2 * $gutter;
    margin-right: 2 * $gutter;
    max-width: 9 * ($day-width + $gutter) - $gutter;

    @media screen and (max-width: 9 * ($day-width + $gutter) + 2 * ($button-width + 3 * $gutter)) {
      max-width: 7 * ($day-width + $gutter) - $gutter;
    }
    @media screen and (max-width: 7 * ($day-width + $gutter) + 2 * ($button-width + 3 * $gutter)) {
      max-width: 5 * ($day-width + $gutter) - $gutter;
    }
    @media screen and (max-width: 5 * ($day-width + $gutter) + 2 * ($button-width + 3 * $gutter)) {
      max-width: 3 * ($day-width + $gutter) - $gutter;
    }
    @media screen and (max-width: 2 * ($day-width + $gutter) + 2 * ($button-width + 3 * $gutter)) {
      width: 1 * ($day-width + $gutter) - $gutter;
    }
  }

  .day {
    flex-shrink: 0;
    margin-left: $gutter;
    width: $day-width;
    height: $day-width;

    &:first-child {
      margin-left: 0;
    }
  }
}
</style>
