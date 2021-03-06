<template>
  <div id="calendar" class="cldr">
    <calendar-full
      id="calendar-full"
      :enabledDays="activeDays.map(({d}) => d)"
      :activeDay="currentDate"
      @dayClick="setDate"
    ></calendar-full>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8 col-xl-7">
          <row-view ref="rowView" :days="days" :currentDate="currentDate" @change="setDate" />
        </div>
      </div>
      <div id="buttons" class="text-center pt-4">
        <button type="button" class="btn btn-outline-light m-1" data-toggle="modal" data-target="#calendar-full">
          Kalendár
        </button>
        <button class="btn btn-outline-light" v-if="today" @click="goToToday">
          Dnes
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import RowView from "./RowView";
import MonthsView from "./MonthsView";
import CalendarFull from "./Calendar/Full";

import dayjs from "dayjs";
import utc from "dayjs/plugin/utc";
import "dayjs/locale/sk";
dayjs.extend(utc);
dayjs.locale("sk");
import weekOfYear from "dayjs/plugin/weekOfYear";

dayjs.extend(weekOfYear);

export default {
  name: "Calendar",
  components: { RowView, MonthsView, CalendarFull },
  props: [
    "startDate",
    "endDate",
    "activeDatesStart",
    "activeDatesEnd",
    "today",
    "defaultDate"
  ],
  computed: {
    days() {
      const days = [];
      const end = dayjs(this.endDate);

      for (
        var day = dayjs(this.startDate);
        !day.isAfter(end);
        day = day.add(1, "day")
      ) {
        days.push({
          d: day.format("YYYY-MM-DD"),
          active:
            !day.isBefore(this.activeDatesStart) &&
            !day.isAfter(this.activeDatesEnd)
        });
      }

      return days
    },
    activeDays() {
      return this.days.filter(({active}) => active)
    },
    currentDate() {
      return _.get(this, '$route.params.date') || this.defaultDate
    }
  },
  methods: {
    setDate(date) {
      setTimeout(() => document.querySelector('#dennik').scrollIntoView({ behavior: 'smooth' }), 100);
      if (date !== _.get(this, "$route.params.date")) Router.push({ name: "days", params: { date } });
    },
    goToToday() {
      this.setDate(this.today)
      this.$refs.rowView.navigateToCurrentDate()
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="scss">
.cldr {
  position: relative;

  & #buttons > .btn {
    width: 10em;
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
