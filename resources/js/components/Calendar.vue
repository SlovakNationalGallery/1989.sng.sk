<template>
  <div class="cldr">
    <span @click="showCalendar = !showCalendar">📅</span>
    <transition name="slide">
      <months-view v-if="showCalendar" :days="days" @input="setDate($event)" />
    </transition>
    <row-view :days="days" :startAt="startAt || ''" @input="setDate($event)" />
  </div>
</template>

<script>
import RowView from "./RowView";
import MonthsView from "./MonthsView";

import dayjs from "dayjs";
import utc from 'dayjs/plugin/utc';
import 'dayjs/locale/sk';
dayjs.extend(utc);
dayjs.locale('sk');
import weekOfYear from 'dayjs/plugin/weekOfYear'

dayjs.extend(weekOfYear)

export default {
  name: "Calendar",
  components: { RowView, MonthsView },
  props: ["start", "end", "startAt", "dayCallback"],
  data() {
    return {
      days: [],
      cldr: [],
      showCalendar: false
    };
  },
  created() {
    let day = dayjs(this.start, 'YYYY-MM-DD')
      .startOf("week")
      .subtract(1, 'week');
    const end = dayjs(this.end, 'YYYY-MM-DD')
      .endOf("week")
      .add(1, 'week');
    this.days = [];
    while (day.isBefore(end) || day.isSame(end)) {
      const newDay = {
        d: day.format('YYYY-MM-DD'),
        dt: day.date(),
        m: day.format("M"),
        y: day.format("YYYY"),
        w: +day.week(),
        active: (day.isAfter(this.start) || day.isSame(this.start)) && (day.isBefore(this.end))
      };
      day = day.add(1, 'day');
      this.days.push(newDay);
    }
  },
  methods: {
    setDate(date) {
      this.dayCallback(date);
      this.showCalendar = false;
      this.startAtDay = date;
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss">
.cldr {
  position: relative;
}
.weekend {
  font-weight: bolder;
}

.cldr-months-wrapper {
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  z-index: 1000;
}
.cldr-week-wrapper {
  position: relative;
  text-align: left;
  background: rgba(255, 255, 255, 0.95);
}
.cldr-week {
  display: inline-block;
  text-align: right;
  width: 2em;
}

.cldr-days-wrapper {
  display: inline-block;
  margin-left: 2em;
}
.cldr-day-wrapper {
  display: inline-block;
  left: 1em;
  padding: 4px;
  width: 3em;
  line-height: 2em;
  cursor: pointer;
  text-align: center;
}
.cldr-day-wrapper.inactive {
  opacity: 0.4;
  pointer-events: none;
}
.cldr-day-wrapper.shaded {
  background: rgba(0, 0, 0, 0.1);
}
.cldr-day-wrapper:hover {
  background: rgba(0, 0, 0, 0.2);
}
.cldr-day {
  display: inline-block;
}
</style>
