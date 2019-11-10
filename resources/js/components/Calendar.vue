<template>
  <div id="calendar" class="cldr">
    <transition name="slide">
      <months-view v-if="showCalendar" :days="days" @input="setDate($event)" />
    </transition>
    <row-view :days="days" :startAt="startAt" @change="setDate($event)" />
    <div class="container-fluid buttons row">
      <!-- <div class="offset-sm-2 col-sm-4 offset-md-3 col-md-3">
        <button
          class="btn btn-dark w-100"
          @click="showCalendar = !showCalendar"
        >
          Kalendár
        </button>
      </div> -->
      <div class="offset-sm-4 col-sm-4  offset-md-5 col-md-2">
        <button class="btn btn-dark w-100" @click="setDate(today)">
          Dnes
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import RowView from "./RowView";
import MonthsView from "./MonthsView";

import dayjs from "dayjs";
import utc from "dayjs/plugin/utc";
import "dayjs/locale/sk";
dayjs.extend(utc);
dayjs.locale("sk");
import weekOfYear from "dayjs/plugin/weekOfYear";

dayjs.extend(weekOfYear);

export default {
  name: "Calendar",
  components: { RowView, MonthsView },
  props: ["available-days", "end", "startAt", "today"],
  data() {
    return {
      days: [],
      cldr: [],
      showCalendar: false,
      currentDay: this.startAt
    };
  },
  created() {
    const ds = this.availableDays.map(d => dayjs(d).format("YYYY-MM-DD"));
    dayjs.locale("sk");
    let day = dayjs(this.start, "YYYY-MM-DD")
      .startOf("week")
      .set("year", 1989)
      .subtract(1, "week");
    const end = dayjs(this.end, "YYYY-MM-DD")
      .endOf("week")
      .set("year", 1989)
      .add(1, "week");
    this.days = [];
    while (day.isBefore(end) || day.isSame(end)) {
      const dateString = day.format("YYYY-MM-DD");
      const newDay = {
        d: dateString,
        dt: day.date(),
        m: day.format("MMMM"),
        y: day.format("YYYY"),
        w: +day.week(),
        active: ds.indexOf(dateString) > -1
      };
      day = day.add(1, "day");
      this.days.push(newDay);
    }
  },
  methods: {
    setDate(date) {
      if (this.currentDay === date) {
        return;
      }
      Router.push({ name: "day-entries", params: { date } });
      this.currentDay = date;
      this.showCalendar = false;
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss">
.cldr {
  position: relative;
  .buttons {
    margin: 1rem auto;
  }
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
